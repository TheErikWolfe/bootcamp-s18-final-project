<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    public function creator ()
    {
        return $this->hasOne('App\User', 'creator_id');
    }
}
