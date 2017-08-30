<?php

namespace App\Http\Controllers;

// namespace libary
use Hash;
use App\Models\User;
use App\Repository\Transformers\UserTransformer;
use Carbon\Carbon;
// namespace project
use App\Request\User\LoginRequest;
use App\Request\User\RegisterRequest;
use App\Response\User\UserResponse;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * @var \App\Repository\Transformers\UserTransformer
     * */
    protected $userTransformer;

    public function __construct(userTransformer $userTransformer)
    {

        $this->userTransformer = $userTransformer;

    }

    /**
     * @description: Api user authenticate method
     * @author: Tao
     * @param: Request
     * @return: Json String response
     */
    public function authenticate(Request $request)
    {

        //$user         = new User();
        $loginRequest = new LoginRequest();

        if (!$loginRequest->validator($request)) {
            return $this->respondWithErrors($loginRequest->message());
        }

        return $this->_login($request['email'], $request['password']);
    }

    /**
     * @description: Api user register method
     * @author: Adelekan David Aderemi
     * @param: lastname, firstname, username, email, password
     * @return: Json String response
     */
    public function register(Request $request)
    {
        $registerRequest = new RegisterRequest();

        if(!$registerRequest->validator($request)){
            return $this->respondWithErrors($registerRequest->message());
        }

        else {

            $user = User::create([

                'name'     => $request['name'],
                'email'    => $request['email'],
                'password' => \Hash::make($request['password']),

            ]);

            return $this->_login($request['email'], $request['password']);
        }

    }

    /**
     * @description: Api user logout method
     * @author: Tao
     * @param: Request
     * @return: Json String response
     */
    public function logout(Request $request)
    {
        if ($accessToken = $request->header('Authorization')) 
        {
            $user = User::where('api_token', $accessToken)->first();

            if ($user) 
            {
                $user->api_token = NULL;
                $user->expired_date = NULL;

                $user->save();
                return $this->respond([

                    'status'  => 'success',
                    'message' => 'User logged out successful!',

                ]);
            } 
            else 
            {
                return $this->respondWithError('Authentication failed! API token not match!');
            }
        }
        else
        {
            return $this->respondWithError('User hasnt logged in yet or User not found!');
        }
    }   

    /**
     * @description: Api user login private method
     * @author: Tao
     * @param: email, password
     * @return: Json String response
     */
    private function _login($email, $password)
    {
        $user          = User::where('email', $email)->first();
        $response      = new UserResponse();
        $checkPassword = Hash::check($password, $user->password);

        if ($user && $checkPassword) 
        {
        // logged yet?
            // hasn't
            if ($user->api_token == null) 
            {
                $user->api_token    = str_random(191);
                $user->expired_date = Carbon::now()->addDays(1);
                $user->save();

                // UserResponse
                return $this->respondWithData(
                array(
                    'user' => $response->newUser($user),
                ));
            }
            // has logged
            else 
            {
                return $this->respondWithError('Already logged in!');
            }
        }

        return $this->respondWithError('Email or Password is not correct!');
    }

}
