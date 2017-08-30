<?php

namespace App\Request\User;

use Validator;

Class RegisterRequest{

	private $message;

	/**
	*@description: Register validate method
	*@param: request
	*@return: boolean
	**/
	public function validator($request)
	{
		$rules = [
			'name'                  => 'required|max:255',
            'email'                 => 'required|email|max:255|unique:users',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:3',
		];

		$validator = Validator::make($request->all(), $rules);

		if($validator->fails())
		{
			$this->message = $validator->errors();
			return false;
		}

		else return true;
	}

	public function message()
	{
		return $this->message;
	}
}