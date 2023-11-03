<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public mixed $itemsPerPage = 25;

    public function __construct()
    {
        $this->itemsPerPage = request('per_page', 25);
    }

    public function generateCode($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, $charactersLength - 1)];
        }
        $ckecode = User::where('code', $code)->first();
        if ($ckecode) {
            $this->generateCode();
        }
        return $code;
    }

    public function createOtp($user)
    {
        $otp = new Otp();
        $newOtp = mt_rand(100000, 999999);
        $otp->code = $this->checkOtp($newOtp);
        $otp->expires_at = now()->addMinutes(5);
        $otp->user_id = $user->id;
        $otp->phone = $user->phone;
        $otp->save();
        return $otp;
    }
    public function checkOtp($otp)
    {
        if (Otp::where('code', $otp)->exists()) {
            $otp = mt_rand(100000, 999999);
            $this->checkOtp($otp);
        } else {
            return $otp;
        }
        return $otp;
    }

    public function sendOtp($phone, $otp)
    {
        $client = new \GuzzleHttp\Client(['cookies' => true]);
        $request = $client->request('GET', 'http://api.greenweb.com.bd/api.php?', [
            "query" => [
                "token" => '9550163252168544277278e4cc3b49bcd99787927d3ad24d1761',
                "to" => $phone,
                "message" => urlencode('Your+OTP+is: ' . $otp),
                "submit" => ""
            ]
        ]);

        if($request->getStatusCode() == 200){
            return true;
        } else{
            return false;
        }
    }
}
