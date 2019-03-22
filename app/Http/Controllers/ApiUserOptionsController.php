<?php

namespace App\Http\Controllers;

// Repository
use App\Repositories\UserOptionsRepository;

// Request
use App\Http\Requests\UserOptionsRequest;
use Auth;

class ApiUserOptionsController extends Controller
{

    public function __construct(UserOptionsRepository $userOptions)
    {

        $this->userOptionsRepo = $userOptions;

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
    	$this->userOptionsRepo->update($request->all(), $request->user()->id);

        return response()->json(null, 200);

    }
}
