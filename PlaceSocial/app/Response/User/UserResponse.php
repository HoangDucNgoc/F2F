<?php
namespace App\Response\User;

class UserResponse
{
    public $id;
    public $name;
    public $email;
    public $created_at;
    public $token;

    /**
     * @param /app/models/user
     * @return UserResponse
     */
    public function newUser($user)
    {

        $this->id         = $user->id;
        $this->email      = $user->email;
        $this->name       = $user->name;
        $this->created_at = $user->created_at;
        $this->token      = $user->api_token;

        return $this;
    }

}
