<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:11|unique:users|regex:/(01)[2-9]{1}[0-9]{8}/'
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'code' => $this->generateCode(),
        ]);

        $otp = $this->createOtp($user);
        $this->sendOtp($user->phone, $otp->code);

        return Inertia::render('Auth/Otp', [
            'phone' => $user->phone,
        ]);

//        event(new Registered($user));

//        Auth::login($user);
//
//        return redirect(RouteServiceProvider::HOME);
    }
}
