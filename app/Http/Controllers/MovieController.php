<?php

namespace App\Http\Controllers;

// Laravel utilities
use Lang;

// Repository
use App\Repositories\MovieRepository;

// Request
use App\Http\Requests\MovieRequest;

class MovieController extends Controller
{
    protected $movies;

    public function __construct(MovieRepository $movies)
    {
        // set the model
        $this->movies = $movies;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = $this->movies->all();
        return view('movies.index', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('movies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovieRequest $request)
    {

        $this->movies->create($request->all());
        
        return redirect()->route('movies.index')->with('status', Lang::get('app.movie_add_success', ['title' => $request->title]));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $movie = $this->movies->getItemById($id);

        return view('movies.edit', compact('movie'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MovieRequest $request, $id)
    {
        
        $status = $this->movies->update($request->all(), $id);
        $movie = $this->movies->getItemById($id);
        $message = $status ? Lang::get('app.movie_edit_success') : Lang::get('app.movie_edit_fail');

        return redirect()->route('movies.index')->with('status', $message);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $movie = $this->movies->getItemById($id);
        $status = $this->movies->delete($id);
        $message = $status ? Lang::get('app.movie_delete_success', ['title' => $movie->title]) : Lang::get('app.movie_delete_fail', ['title' => $movie->title]);

        return redirect()->route('movies.index')->with('status', $message);

    }
}
