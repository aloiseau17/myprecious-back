<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Show the movies seen list.
     *
     * @return void
     */
    public function index()
    {
        return view('movies.index');
    }

    /**
     * Show the application movie adding page.
     *
     * @return void
     */
    public function create()
    {
    	return view('movies.create');
    }
}
