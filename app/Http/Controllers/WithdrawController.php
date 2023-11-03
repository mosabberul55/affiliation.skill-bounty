<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWithdrawRequest;
use App\Http\Requests\UpdateWithdrawRequest;
use App\Http\Resources\WithdrawResource;
use App\Models\Income;
use App\Models\Withdraw;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $withdraws = Withdraw::where('user_id', auth()->id())->latest()->paginate($this->itemsPerPage);
        return Inertia::render('Withdraw/All', [
            'withdraws' => WithdrawResource::collection($withdraws),
            'success' => false,
            'successMessage' => ''
        ]);
    }

    public function adminIndex()
    {
        $withdraws = Withdraw::with('user')
            ->when(request('status'), function ($query) {
                $query->where('status', request('status'));
            })->when(request('search'), function ($query) {
                $query->whereLike(['user.name', 'mfs', 'user.phone', 'status'], request('search'));
            })->orderByDesc('id')->paginate($this->itemsPerPage);
        return Inertia::render('Withdraw/AdminAll', [
            'withdraws' => WithdrawResource::collection($withdraws),
            'success' => false,
            'successMessage' => ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Withdraw/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWithdrawRequest $request)
    {
        $userBalance = Income::where('user_id', auth()->id())->sum('income') - Withdraw::where('user_id', auth()->id())->where('status', 'approved')->sum('amount');
        if ($userBalance < $request->amount) {
            throw ValidationException::withMessages([
                'amount' => 'You do not have enough balance to withdraw this amount.'
            ]);
        }
        $checkLast7DaysWithdraws = Withdraw::where('user_id', auth()->id())->where('created_at', '>=', now()->subDays(7))->exists();
        if ($checkLast7DaysWithdraws) {
            throw ValidationException::withMessages([
                'amount' => 'You can not withdraw more than once in 7 days.'
            ]);
        }

        Withdraw::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'mfs' => $request->mfs,
            'note' => $request->note,
            'status' => 'pending'
        ]);

        return Inertia::render('Withdraw/All', [
            'withdraws' => WithdrawResource::collection(Withdraw::where('user_id', auth()->id())->latest()->paginate($this->itemsPerPage)),
            'success' => true,
            'successMessage' => 'Your withdraw request has been submitted successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Withdraw $withdraw)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Withdraw $withdraw)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWithdrawRequest $request, Withdraw $withdraw)
    {
        $withdraw->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'successMessage' => 'Withdraw status updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Withdraw $withdraw)
    {
        //
    }
}
