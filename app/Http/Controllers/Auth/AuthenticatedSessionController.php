<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Otp;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
//            'canResetPassword' => Route::has('password.request'),
            'canResetPassword' => false,
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|size:11|exists:users|regex:/(01)[2-9]{1}[0-9]{8}/',
        ]);
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            $checkValidOtps = Otp::where('phone', $request->phone)->where('expires_at', '>', Carbon::now())->get();
            if (count($checkValidOtps) > 0) {
                $checkValidOtps->each(function ($otp) {$otp->delete();});
            }
            $otp = $this->createOtp($user);
            $this->sendOtp($user->phone, $otp->code);
            return Inertia::render('Auth/Otp', [
                'phone' => $user->phone,
            ]);
        } else {

        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|size:11|regex:/(01)[2-9]{1}[0-9]{8}/',
            'code' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return Inertia::render('Auth/Otp', [
                'phone' => $request->phone,
                'error' => 'Invalid OTP'
            ]);
        }



        $otp = Otp::where('code', $request->code)->where('phone', $request->phone)->first();
        if ($otp) {
            if ($otp->expires_at < Carbon::now()) {
                return Inertia::render('Auth/Otp', [
                    'phone' => $request->phone,
                    'error' => 'OTP expired'
                ]);
            }
            $otp->delete();
            $user = User::where('phone', $request->phone)->first();
            Auth::login($user);
            return redirect()->route('dashboard');
        } else {
            return Inertia::render('Auth/Otp', [
                'phone' => $request->phone,
                'error' => 'Invalid OTP'
            ]);
        }
    }
}
