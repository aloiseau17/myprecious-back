<?php namespace App\Repositories;

// Model
use App\Movie;

class MovieRepository implements RepositoryInterface
{
    // model property on class instances
    protected $movie;

    // Constructor to bind model to repo
    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    // Get all instances of model
    public function all()
    {
        return $this->movie->all();
    }

    // create a new record in the database
    public function create(array $data)
    {

        $movie = $this->movie->create($data);

        // Attach types list to movie via pivot table
        if($data['types']) {

            $movie->types()->attach($data['types']);

        }

        return $movie;
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->movie->find($id);

        $status = $record->update($data);

        // Attach types list to movie via pivot table
        if($data['types']) {

            $record->types()->sync($data['types']);

        }

        return $status;
    }

    // remove record from the database
    public function delete($id)
    {
        $movie = $this->movie->find($id);

        $movie->types()->detach();

        return $this->movie->destroy($id);
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->movie->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->movie;
    }

    // Get movie item by $id
    public function getItemById($id)
    {
        return $this->movie->find($id);
    }
}