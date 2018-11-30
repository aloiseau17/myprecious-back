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
        'director',
        'type',
        'rating',
        'possession_state',
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

}
