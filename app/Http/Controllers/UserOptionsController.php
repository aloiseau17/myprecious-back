<?php

namespace App\Http\Controllers;

// Repository
use App\Repositories\UserOptionsRepository;

// Request
use App\Http\Requests\UserOptionsRequest;

class UserOptionsController extends Controller
{

    public function __construct(UserOptionsRepository $userOptions)
    {

        $this->userOptionsRepo = $userOptions;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

        return view('users.user-options');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UserOptionsRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserOptionsRequest $request)
    {
    	$status = $this->userOptionsRepo->update($request->all(), $request->user()->id);

        return redirect('/');

    }
}
