<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'title',
        'director_id',
        'rating',
        'possession_state',
        'seen',
        'image',
    ];

    /**
     * Set the movie's rating 'empty' value to null in database
     *
     * @param  string  $value
     * @return string
     */
    public function setRatingAttribute($value)
    {
    	if($value === 'empty') {
        	$this->attributes['rating'] = null;
    	} else {
    		$this->attributes['rating'] = $value;
    	}
    }

    /**
     * Set the movie's possession_state 'empty' value to null in database
     *
     * @param  string  $value
     * @return string
     */
    public function setPossessionStateAttribute($value)
    {
    	if($value === 'empty') {
        	$this->attributes['possession_state'] = null;
    	} else {
    		$this->attributes['possession_state'] = $value;
    	}
    }

    /**
     * Get the director for the movie.
     */
    public function director()
    {
        return $this->belongsTo('App\Director');  
    }

    /**
     * The types that belong to the movie.
     */
    public function types()
    {
        return $this->belongsToMany('App\Type');
    }

}
