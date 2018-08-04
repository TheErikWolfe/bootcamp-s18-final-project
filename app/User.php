<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    public function doodles_created ()
    {
        return $this->hasMany('App\Doodle', 'creator_id');
    }

    public function votes ()
    {
        return $this->hasMany('App/Votes', 'voter_id');
    }

    public function reports ()
    {
        return $this->hasMany('App/Reports', 'reporter_id');
    }
    public function comments ()
    {
        return $this->hasmany('App\Comment');
    }
}
