<?php

namespace akr4m\jwtauth\Controllers\Auth\Password;

use DB;
use Mail;
use Illuminate\Http\Request;
use akr4m\jwtauth\Mail\Auth\Forgot;
use App\Http\Controllers\Controller;

class ForgotController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $email = $request->email;

        $emailCheck = DB::table('password_resets')->where('email', $email)->first();

        if ($emailCheck) {
            $token = $emailCheck->token;
        } else {
            $token = uniqid(true);
            $this->saveTokenDatabase($email, $token);
        }

        $this->sendToken($email, $token);

        return response()->json([
            'sent' => ['Password reset code has sent to your email. Please check your email.']
        ], 200);
    }

    private function saveTokenDatabase($email, $token)
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now()
        ]);
    }

    private function sendToken($email, $token)
    {
        Mail::to($email)->queue(
            new Forgot($email, $token)
        );
    }
}
