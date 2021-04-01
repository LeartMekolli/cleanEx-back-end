<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    public function region(){
        return $this->belongsTo('App\Models\Region');
    }

    public function user(){
        return $this->hasOne('App\Models\User');
    }

    public function gender(){
        return $this->belongsTo('App\Models\Gender');
    }
}
