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
use App\Http\Requests\MovieSearchRequest;

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
        if(isset($request->types))
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
    public function show($id)
    {
        $movie = $this->movie->getItemById($id);

        return response()->json($movie, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     *
     * to make it work with patch method use _method = patch magic parameter and send as POST
     * PHP issue https://github.com/laravel/framework/issues/13457#issuecomment-455570274
     */
    public function update(MovieRequest $request, Movie $movie)
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
        $status = $this->movie->update($request->all(), $movie->id);

        // remove not related director(s)
        $this->director->removeIsolated();

        // remove not related type(s)
        $this->type->removeIsolated();

        $message = $status ? Lang::get('app.movie_edit_success') : Lang::get('app.movie_edit_fail');

        return response()->json(['message' => $message], 200);

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
     * Return movies list according to the request parameters
     *
     * @param  \Illuminate\Http\App\Http\Requests\MovieSearchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(MovieSearchRequest $request)
    {
        $movies = $this->movie->find($request->all());

        if($movies->total() === 0) {
            return response()->json(null, 204);  // 204 (No content)
        } else {
            return response()->json($movies, 200);
        }
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
