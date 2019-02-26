<?php

namespace akr4m\jwtauth\Controllers\Auth\Password;

use DB;
use Mail;
use Illuminate\Http\Request;
use akr4m\jwtauth\Models\User;
use akr4m\jwtauth\Mail\Auth\Reset;
use App\Http\Controllers\Controller;
use akr4m\jwtauth\Resources\User\UserResource;

class ResetController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|max:128',
        ]);

        return $this->getEmailTokenTableRow($request) ? $this->changePassword($request) : $this->emailTokenMismatch();
    }

    private function getEmailTokenTableRow($request)
    {
        return DB::table('password_resets')->where($request->only(['email', 'token']))->first();
    }

    private function emailTokenMismatch()
    {
        return response()->json([
            'errors' => [
                'email' => ['Email is not valid for this reset token.']
            ]
        ], 422);
    }

    private function changePassword($request)
    {
        $user = User::whereEmail($request->email)->first();

        $updatePassword = $user->update([
            'password' => $request->password
        ]);

        if ($updatePassword) {
            DB::table('password_resets')->where($request->only('email'))->delete();
        }

        if (!$token = auth()->attempt($request->only('email', 'password'))) {
            return abort(401);
        }

        Mail::to($user)->queue(
            new Reset($user)
        );

        return (new UserResource($request->user()))
            ->additional([
                'meta' => [
                    'token' => $token
                ]
            ]);
    }
}
