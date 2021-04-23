<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

   /*  protected $fillable = [
        'user_id',
        'job_id',
        'payment_id',
        'job_description',
        'price',
        'status',
        'deleted',
    ]; */

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    

    public function payment(){
        return $this->belongsTo('App\Models\Payment');
    }
    public function service(){
        return $this->belongsTo('App\Models\Service'); //hasMany or hasOne ? return $this->hasOne('App\Models\Service','service_id','id');
    }
    public function comment(){
        return $this->hasMany('App\Models\Comment');//???
    }
    public function requestmessage(){
        return $this->hasMany('App\Models\RequestMessage');
    }
}


