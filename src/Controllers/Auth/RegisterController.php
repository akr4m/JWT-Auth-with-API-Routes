<?php

namespace akr4m\jwtauth\Controllers\Auth;

use Illuminate\Http\Request;
use akr4m\jwtauth\Models\User;
use App\Http\Controllers\Controller;
use akr4m\jwtauth\Resources\User\UserResource;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string',
            'password' => 'required|min:6|max:128'
        ]);

        // $user = User::create(array_merge($request->only('name', 'email', 'phone'), [
        //     'password' => bcrypt($request->password)
        // ]));

        $user = User::create($request->only('name', 'email', 'password'));

        if (!$token = auth()->attempt($request->only('email', 'password'))) {
            return abort(401);
        }

        return (new UserResource($request->user()))
            ->additional([
                'meta' => [
                    'token' => $token,
                ],
            ]);
    }
}
