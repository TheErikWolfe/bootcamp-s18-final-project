<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doodle extends Model
{
    public function creator ()
    {
        return $this->belongsTo('App\User', 'creator_id');
    }
    public function votes ()
    {
        return $this->hasMany('App\Votes');
    }
    public function reports ()
    {
        return $this->hasMany('App\Reports');
    }
    public function comments ()
    {
        return $this->hasMany('App\Comment');
    }
    public function signature ()
    {
        return $this->belongsTo('App\Signature');
    }
}
