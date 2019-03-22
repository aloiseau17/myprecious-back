<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOptions extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id',
        'list_order',
        'list_order_by',
    ];

    /**
     * Get the director for the movie.
     */
    public function user()
    {
        return $this->hasOne('App\User');   
    }
}
