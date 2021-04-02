<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    public function post(){
        return $this->hasMany('App\Models\Post');
    }
}
