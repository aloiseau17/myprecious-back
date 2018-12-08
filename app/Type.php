<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Model
// use App\Movie;

class Type extends Model
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The movies that belong to the type.
     */
    public function movies()
    {
        return $this->belongsToMany('App\Movie');
    }

}
