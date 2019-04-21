<?php

namespace App\Http\Controllers;

// Laravel utilities
use Lang;

// Repository
use App\Repositories\MovieRepository;
use App\Repositories\TypeRepository;
use App\Repositories\DirectorRepository;

// Request
use App\Http\Requests\MovieRequest;
use App\Http\Requests\MovieSearchRequest;

class MovieController extends Controller
{
    protected $movies;

    public function __construct(MovieRepository $movie, TypeRepository $type, DirectorRepository $director)
    {

        $this->movie = $movie;
        $this->type = $type;
        $this->director = $director;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $movies = $this->movie->all();
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

        // manage director
        if($request->director)
        {
            $request['director_id'] = $this->manage_movie_director($request->director);
        }

        // store types
        if(isset($request->types))
        {
            $request['types'] = $this->manage_movie_types($request->types);
        }

        // Store types
        $this->movie->create($request->all());
        
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

        $movie = $this->movie->getItemById($id);
        $types_names = implode(';', $movie->types->pluck('name')->toArray());

        return view('movies.edit', compact('movie', 'types_names'));

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

        // manage director
        if($request->director)
        {
            $request['director_id'] = $this->manage_movie_director($request->director);
        } else {
            $request['director_id'] = null;
        }

        // store types
        if(isset($request->types))
        {
            $request['types'] = $this->manage_movie_types($request->types);
        }
        
        // update movie
        $status = $this->movie->update($request->all(), $id);

        // remove not related director(s)
        $this->director->removeIsolated();

        // remove not related type(s)
        $this->type->removeIsolated();

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

        $movie = $this->movie->getItemById($id);
        $status = $this->movie->delete($id);

        // remove not related director(s)
        $this->director->removeIsolated();

        // remove not related type(s)
        $this->type->removeIsolated();
        
        $message = $status ? Lang::get('app.movie_delete_success', ['title' => $movie->title]) : Lang::get('app.movie_delete_fail', ['title' => $movie->title]);

        return redirect()->route('movies.index')->with('status', $message);

    }

    /**
     * Show the form for filter movies
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        return view('movies.search');
    }

    /**
     * Return movies list according to the request parameters
     *
     * @param  \Illuminate\Http\App\Http\Requests\MovieSearchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(MovieSearchRequest $request)
    {
        $movies = $this->movie->find($request->all());
        return view('movies.filter', compact('movies', 'request'));
    }

    /**
     * Store or retrieve director's id
     *
     * @param  string  $director_name
     * @return int $id
     */
    protected function manage_movie_director($director_name)
    {

        $director = $this->director->findOrCreate(['name' => $director_name]);

        return $director->id;

    }

    /**
     * Store or retrieve types'id
     *
     * @param  string  $types_names
     * @return array $types_ids
     */
    protected function manage_movie_types($types_names)
    {

        $types = explode(';', $types_names);
        $types_ids = [];

        foreach ($types as $name) {

            $type = $this->type->findOrCreate(['name' => $name]);
            $types_ids[] = $type->id;

        }

        return $types_ids;

    }

}
