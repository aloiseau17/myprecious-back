<?php

namespace App\Http\Controllers;

// Laravel utilities
use Lang;

// Models
use App\Movie;

// Repository
use App\Repositories\MovieRepository;
use App\Repositories\TypeRepository;
use App\Repositories\DirectorRepository;

// Request
use App\Http\Requests\MovieRequest;

class ApiMovieController extends Controller
{
    protected $movies;

    public function __construct(MovieRepository $movie, TypeRepository $type, DirectorRepository $director)
    {

        $this->movie = $movie;
        $this->type = $type;
        $this->director = $director;

    }

    /**
     * Return movie collection.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return $this->movie->all(); // 200

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
        if($request->types)
        {
            $request['types'] = $this->manage_movie_types($request->types);
        }

        // Store types
        $movie = $this->movie->create($request->all());

        return response()->json($movie, 201);

    }

    /**
     * Return a spectific resource by id
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        return $movie; // automatically return 404 if not found
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(MovieRequest $request, Movie $movie)
    {

        // manage director
        if($request->director)
        {
            $request['director_id'] = $this->manage_movie_director($request->director);
        }

        // store types
        if($request->types)
        {
            $request['types'] = $this->manage_movie_types($request->types);
        }
        
        // update movie
        $status = $this->movie->update($request->all(), $movie->id);

        // remove not related director(s)
        $this->director->removeIsolated();

        // remove not related type(s)
        $this->type->removeIsolated();

        $message = $status ? Lang::get('app.movie_edit_success') : Lang::get('app.movie_edit_fail');

        return response()->json($message, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {

        $this->movie->delete($movie->id);

        // remove not related director(s)
        $this->director->removeIsolated();

        // remove not related type(s)
        $this->type->removeIsolated();

        return response()->json(null, 204); // 204 (No content)

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