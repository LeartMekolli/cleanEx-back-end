<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
  /*   protected $fillable = [
        'name',
        'lastname',
        'username',
        'email',
        'birthday',
        'phoneNo',
        
    ]; */

    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
   /*  protected $hidden = [
        'password',
        'remember_token',
    ]; */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function comment(){
        return $this->hasMany('App\Models\Comment');
    }
    public function post(){
        return $this->hasMany('App\Models\Post');
    }
    public function requestmessage(){
        return $this->hasMany('App\Models\RequestMessage');
    }

    public function detail(){
        return $this->belongsTo('App\Models\Detail');
    }
}
