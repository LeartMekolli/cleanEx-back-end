<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;
    protected $fillable = ['id','gender_type'];
    public function detail(){
        return $this->hasMany('App\Models\Detail');
    }
    public $timestamps = false;
}
