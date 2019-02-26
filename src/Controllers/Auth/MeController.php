<?php

namespace akr4m\jwtauth\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use akr4m\jwtauth\Resources\User\UserResource;

class MeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function __invoke(Request $request)
    {
        return new UserResource($request->user());
    }
}
