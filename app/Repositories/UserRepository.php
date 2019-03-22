<?php namespace App\Repositories;

// Model
use App\User;

class UserRepository
{
    // model property on class instances
    protected $user;

    // Constructor to bind model to repo
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    // Get user options by $user_id
    public function getUserById($id)
    {
        return $this->user->with('userOptions')->find($id);
    }
}