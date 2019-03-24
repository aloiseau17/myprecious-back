<?php

namespace App\Http\Controllers;

// Repository
use App\Repositories\UserRepository;

// Request
use App\Http\Requests\UserEmailUpdateRequest;
use App\Http\Requests\UserPasswordUpdateRequest;

// Helpers
use Lang;

class UserController extends Controller
{

    public function __construct(UserRepository $user)
    {

        $this->userRepo = $user;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

        return view('users.user-account');

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

        $message = $status ? Lang::get('app.user_edit_success') : Lang::get('app.user_edit_fail');

        return redirect()->route('user-account.edit')->with('status', $message);

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

        $message = $status ? Lang::get('app.user_edit_success') : Lang::get('app.user_edit_fail');

        return redirect()->route('user-account.edit')->with('status', $message);

    }
}
