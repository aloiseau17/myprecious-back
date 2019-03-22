<?php namespace App\Repositories;

// Model
use App\UserOptions;

class UserOptionsRepository
{
    // model property on class instances
    protected $userOptions;

    // Constructor to bind model to repo
    public function __construct(UserOptions $userOptions)
    {
        $this->userOptions = $userOptions;
    }

    // update record in the database
    public function update($data, int $user_id)
    {
        $record = $this->userOptions->updateOrCreate(
            [
                'user_id' => $user_id
            ], 
            [
                'list_order' => $data['list_order'],
                'list_order_by' => $data['list_order_by']
            ]);

        return $record;
    }

    // Get user options by $user_id
    public function getOptionsByUserId($user_id)
    {
        return $this->userOptions->where('user_id', '===', $user_id)->first();
    }
}