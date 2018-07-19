<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doodle extends Model
{
    public function creator ()
    {
        return $this->belongsTo('App\User', 'creator_id');
    }
}
