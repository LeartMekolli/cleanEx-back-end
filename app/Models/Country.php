<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    public function city(){
        return $this->hasMany('App\Models\City');
    }

    public $timestamps = false;
}
