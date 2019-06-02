<?php namespace App\Repositories;

// Model
use App\Movie;

// Helpers
use Illuminate\Support\Facades\Storage;
use Image;

class MovieRepository implements RepositoryInterface
{
    // model property on class instances
    protected $movie;
    private $posterFolder = 'posters';
    private $posterDisk = 'public';

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
        $data = $this->sanitizeData($data);

        $movie = $this->movie->create($data);

        // Attach types list to movie via pivot table
        if(isset($data['types'])) {

            $movie->types()->attach($data['types']);

        }

        // If image save movieId name + update movie image path
        if(isset($data['file'])) {

            $this->savePoster($movie, $data['file']);

        } elseif (isset($data['poster_link'])) {

            $this->downloadUrlImage($movie, $data['poster_link']);

        }

        return $movie;
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $data = $this->sanitizeData($data);

        $record = $this->movie->find($id);

        if(isset($data['file']) || isset($data['file_remove']) || isset($data['poster_link'])) {
            // remove old file if exist with other extension
            $this->removePoster($record->image, $record, isset($data['file_remove']));
        }

        // If new file
        if(isset($data['file'])) {

            $this->savePoster($record, $data['file']);

        } elseif (isset($data['poster_link'])) {

            $this->downloadUrlImage($record, $data['poster_link']);

        }

        $status = $record->update($data);

        // Attach types list to movie via pivot table
        if(isset($request->types))
        {
            $record->types()->sync($data['types']);
        }

        return $status;
    }

    // remove record from the database
    public function delete($id)
    {
        $movie = $this->movie->find($id);

        $this->removePoster($movie->image);

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
        return $this->movie->with('director')->with('types')->find($id);
    }

    // Remove existing file
    private function removePoster($path, $record = null, $sync = false) {
        if($path) {
            Storage::disk($this->posterDisk)->delete($path);
        }

        if($path && $record && $sync)
            $record->update([
                'image' => null
            ]);
    }

    // Save and sync movie poster
    private function savePoster($record, $file) {
        $filename = $this->posterName($record, $file->getClientOriginalExtension());

        $image_path = $file->storeAs(
            $this->posterFolder, // folder
            $filename, // name
            $this->posterDisk // disk
        );

        $path = $this->posterPath($filename);

        //make Intervention Image instance and resize to specific pixel
        $resized_image = Image::make($path)->fit(230, 310);

        //save the image with new sizes by replacing the existing sl- prefix file
        //but this save method would not be require in this case
        $resized_image->save();  

        $record->update([
            'image' => $this->posterFolder . '/' . $filename
        ]);
    }

    private function loadFile($url) {
        $http = new \GuzzleHttp\Client;

        try {

            $response = $http->get($url, [
                'headers'        => ['content-type' => 'image/*'],
            ]);

            return $response->getBody();

        } catch (\GuzzleHttp\Exception\RequestException $e) {

            return false;

        } catch (\GuzzleHttp\Exception\BadResponseException $e) {

            return false;

        }
    }

    private function downloadUrlImage($record, $url) {

        //Get the file
        $image_content = $this->loadFile($url);

        if($image_content === false)
            return false;

        $extension = pathinfo($url, PATHINFO_EXTENSION) ?: 'jpg';
        $filename = $this->posterName($record, $extension);
        $image_path = $this->posterPath($filename);

        //Store in the filesystem.
        $fp = fopen($image_path, "w");
        fwrite($fp, $image_content);
        fclose($fp);

        try {
            $img = Image::make($image_path);
        } catch (\Exception $e) {
            $this->removePoster($this->posterFolder . '/' . $filename);
            return false;
        }

        //make Intervention Image instance and resize to specific pixel
        $resized_image = $img->fit(230, 310);
        $resized_image->save();

        $record->update([
            'image' => $this->posterFolder . '/' . $filename
        ]);
    }

    private function posterName($record, $extension) {
        return $record->id . '-' . time() . '.' . $extension;
    }

    private function posterPath($filename) {
        return Storage::disk($this->posterDisk)->path($this->posterFolder . '/' . $filename);
    }

    private function sanitizeData(array $data)
    {
        // Sanitize seen attribut
        if(isset($data['seen']))
            $data['seen'] = ($data['seen'] == 'true' || $data['seen'] == '1') ? true : false;

        // Sanitize file_remove attribut
        if(isset($data['file_remove']))
            $data['file_remove'] = ($data['file_remove'] == 'true') ? true : false;
        
        return $data;
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
     * random : get random movie (used only if you require on page)
     * types : types.name
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
            "random"            => false,
            "types"             => null,
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
            ->when($inputs['types'], function ($query, $types) {
                return $query->whereHas('types', function ($query) use ($types) {
                    $query->where('name', 'like', '%' . $types . '%');
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
                return $query->whereNotIn('id', $not_in);
            })
            ->when($inputs['random'], function($query) {
                return $query->inRandomOrder();
            })
            ->when(!$inputs['random'], function($query) use ($inputs) {
                return $query->orderBy($inputs['order_by'], $inputs['order']);
            })
            ->paginate($inputs["number"]);

        return $movies;
    }
}