<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Votes extends Model
{
    public function img_votes() 
    {
        return $this->belongsTo(App\Doodle);
    }
}
