<?php

namespace App\Http\Controllers;

// Repositoriers
use App\Repositories\UserRepository;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\UserEmailUpdateRequest;
use App\Http\Requests\UserPasswordUpdateRequest;

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

    /**
     * Update user email field
     *
     * @param  \Illuminate\Http\UserOptionsRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEmail(UserEmailUpdateRequest $request)
    {

        $status = $this->userRepo->update($request->all(), $request->user()->id);

        return response()->json(null, 200);

    }

    /**
     * Update user password field
     *
     * @param  \Illuminate\Http\UserOptionsRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UserPasswordUpdateRequest $request)
    {
        
        $status = $this->userRepo->update($request->all(), $request->user()->id);

        return response()->json($status, 200);

    }
}
