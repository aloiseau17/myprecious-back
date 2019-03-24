<?php namespace App\Repositories;

// Model
use App\User;

// Helpers
use Hash;

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

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->user->find($id);

        // Hash new password
        if(isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $status = $record->update($data);

        return $status;
    }
}