<?php
namespace App\Request\User;

use Validator;

class LoginRequest
{
    private $message;
    /**
     * validator login
     * @param class Request $request
     * @param App/Models/User $user
     * @return Validator
     */
    public function validator($request)
    {
        $rules = array(
            'email'    => 'required|email',
            'password' => 'required',
        );
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $this->message = $validator->errors();
            return false;
        }

        return true;

    }

    /**
     * return message error
     */
    public function message()
    {
        return $this->message;
    }
}
