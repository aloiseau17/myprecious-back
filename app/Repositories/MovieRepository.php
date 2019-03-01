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

    // Get movies according to parameters
    /**
     * Available parameters
     *
     * director : directors.name
     * first_letter : movies.title get movie with title starting with this letter
     * not_in : array of ids to exclude
     * number : number of movies to retrieve
     * order : ASC or DESC
     * order_by : title or created_at
     * page : page number
     * possession_state : movies.possession_state
     * rating : movies.rating
     * seen : movie.seen
     * type : types.name
     **/
    public function find($inputs)
    {
        $defaults = array(
            "director"          => null,
            "first_letter"      => null,
            "not_in"            => null,
            "number"            => 10,
            "order"             => "DESC",
            "order_by"          => "created_at",
            "page"              => 1,
            "possession_state"  => null,
            "rating"            => null,
            "seen"              => null,
            "type"              => null,
        );
        
        // Apply defaut to undefined keys
        $inputs = array_replace_recursive($defaults, $inputs);

        $movies = $this->movie
            ->when($inputs['possession_state'], function ($query, $possession_state) {
                return $query->where('possession_state', '=', $possession_state);
            })
            ->when($inputs['rating'], function ($query, $rating) {
                return $query->where('rating', '=', $rating);
            })
            ->when(!is_null($inputs['seen']), function ($query) use ($inputs) {
                $seenState = $inputs['seen'] == "1" ? 1 : 0;
                return $query->where('seen', '=', $seenState);
            })
            ->when($inputs['type'], function ($query, $type) {
                return $query->whereHas('types', function ($query) use ($type) {
                    $query->where('name', 'like', '%' . $type . '%');
                });
            })
            ->when($inputs['director'], function ($query, $director) {
                return $query->whereHas('director', function ($query) use ($director) {
                    $query->where('name', 'like', '%' . $director . '%');
                });
            })
            ->when($inputs['first_letter'], function ($query, $letter) {
                return $query->where('title', 'like', $letter . '%');
            })
            ->when($inputs['not_in'], function ($query, $not_in) {
                return $query->whereNotIn('id', json_decode($not_in));
            })
            ->orderBy($inputs['order_by'], $inputs['order'])
            ->paginate($inputs["number"]);

        return $movies;
    }
}