<?php namespace App\Repositories;

// Model
use App\Type;

class TypeRepository implements RepositoryInterface
{
    // model property on class instances
    protected $type;

    // Constructor to bind model to repo
    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    // Get all instances of model
    public function all()
    {
        return $this->type->all();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->type->create($data);
    }

    // return existing or create
    public function findOrCreate(array $data)
    {
        return $this->type->firstOrCreate($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->type->find($id);

        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->type->destroy($id);
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->type->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->type;
    }

    // Get type item by $id
    public function getItemById($id)
    {
        return $this->type->find($id);
    }

    // Destroy types if they are not related to a movie to clean the database
    public function removeIsolated()
    {
        $isolated_types = $this->type->doesntHave('movies')->get();

        foreach ($isolated_types as $type) {
            $this->delete($type->id);
        }
    }
}