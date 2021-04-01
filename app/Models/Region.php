<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    public function city(){
        return $this->belongsTo('App\Models\City');
    }

    public function detail(){
        return $this->hasOne('App\Models\Detail');
    }
    public $timestamps = false;
}
