<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function img_votes() 
    {
        return $this->belongsTo('App\Doodle');
    }
}
