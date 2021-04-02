<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public function Post(){
        return $this->hasOne('App\Models\Post');
    }
    public function method(){
        return $this->belongsTo('App\Models\Method');
    }

}
