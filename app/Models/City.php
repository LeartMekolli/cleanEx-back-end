<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    
    use HasFactory;
    public $table = 'cities';
    protected $fillable = ['id', 'city_name'];
    public function region(){
        return $this->hasMany('App\Models\Region');
    }
    public function country(){
        return $this->belongsTo('App\Models\Country');
    }

    public $timestamps = false;
}
