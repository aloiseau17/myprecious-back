<?php namespace App\Repositories;

// Model
use App\Director;

class DirectorRepository implements RepositoryInterface
{
    // model property on class instances
    protected $director;

    // Constructor to bind model to repo
    public function __construct(Director $director)
    {
        $this->director = $director;
    }

    // Get all instances of model
    public function all()
    {
        return $this->director->all();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->director->create($data);
    }

    // return existing or create
    public function findOrCreate(array $data)
    {
        return $this->director->firstOrCreate($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->director->find($id);

        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->director->destroy($id);
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->director->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->director;
    }

    // Get director item by $id
    public function getItemById($id)
    {
        return $this->director->find($id);
    }

    // Destroy directors if they are not related to a movie
    public function removeIsolated()
    {
        $isolated_directors = $this->director->doesntHave('movies')->get();

        foreach ($isolated_directors as $director) {
            $this->delete($director->id);
        }
    }
}