<?php

namespace App\Repository\Transformers;

use App\Models\User;

class UserTransformer extends Transformer{

    public function transform($user){

        return [
            'fullname' => $user->name,
            'email' => $user->email,
            'api_token' => $user->api_token,
            'expired_date' => $user->expired_date,
        ];

    }

}