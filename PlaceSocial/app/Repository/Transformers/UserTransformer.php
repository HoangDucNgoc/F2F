<?php

namespace App\Repository\Transformers;

use App\User;
class UserTransformer extends Transformer{

    public function transform($user){

        return [
            'fullname' => $user->name,
            'email' => $user->email,
            'api_token' => $user->api_token,
        ];

    }

}