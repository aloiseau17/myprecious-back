<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Show the application movie adding page.
     *
     * @return void
     */
    public function add()
    {
    	return view('movie.add');
    }

    /**
     * Show the movies seen list.
     *
     * @return void
     */
    public function seen()
    {
    	return view('movie.seen');
    }
}
