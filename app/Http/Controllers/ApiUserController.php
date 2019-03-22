<?php

namespace App\Http\Controllers;

// Repositoriers
use App\Repositories\UserRepository;

use Illuminate\Http\Request;

class ApiUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user)
    {
        $this->middleware('auth');
        $this->userRepo = $user;
    }

    /**
     * Retrieve user information
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = $this->userRepo->getUserById($request->user()->id);
        return response()->json($user, 200);
    }
}
