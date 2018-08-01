<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    public function img_reports() 
    {
        return $this->belongsTo(App\Doodle);
    }
}
