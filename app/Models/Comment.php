<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public $table = 'comments';
    protected $fillable = [
        'user_id',
        'service_id',
        'comment',
        'comment_date',
        'rating'
        
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function post(){
        return $this->belongsTo('App\Models\Post');
    }


}
