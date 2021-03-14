<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'payment_id',
        'job_description',
        'price',
        'created_at',
        'status',
        'deleted',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    

    public function payment(){
        return $this->belongsTo('App\Models\Payment');
    }
    public function job(){
        return $this->belongsTo('App\Models\Job'); //hasMany or hasOne ? return $this->hasOne('App\Models\Job','job_id','id');
    }
    public function comment(){
        return $this->hasMany('App\Models\Comment');//???
    }
    public $timestamps  = false;
}
