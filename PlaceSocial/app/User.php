<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['expired_date'];

    public function authorizingToken()
    {
        $this->generateToken();
        return $this->createExpiredDate();
    }

    public function disableAuthorization()
    {
        $this->disableToken();
        return $this->disableExpiredDate();
    }

    private function generateToken()
    {
        $this->api_token = str_random(191);
        $this->save();

        return $this->api_token;
    }

    private function createExpiredDate()
    {
        $this->expired_date = Carbon::now()->addDays(1);
        $this->save();

        return $this->expired_date;
    }

    private function disableToken()
    {
        $this->api_token = NULL;
        return $this->save();
    }

    private function disableExpiredDate()
    {
        $this->expired_date = NULL;
        return $this->save();
    }

    
}
