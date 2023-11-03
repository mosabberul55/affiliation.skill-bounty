<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Http\Resources\ImcomeResource;
use App\Models\Income;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomes = Income::where('user_id', auth()->id())->latest()->paginate($this->itemsPerPage);
        return Inertia::render('Income', [
            'incomes' => ImcomeResource::collection($incomes),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|exists:users,code|size:6',
            'customer_phone' => 'required|string|max:11|regex:/(01)[2-9]{1}[0-9]{8}/',
            'customer_name' => 'required|string|max:255',
            'sale_price' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $data = $request->except(['percent', 'income']);
        $data['percent'] = 12;
        $data['income'] = $data['sale_price'] * $data['percent'] / 100;
        $user = User::where('code', $request->code)->first();
        $data['user_id'] = $user->id;
        $income = Income::create($data);
        return new ImcomeResource($income);
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Income $income)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIncomeRequest $request, Income $income)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        //
    }
}
