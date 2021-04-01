<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'service_id',
        'comment',
        'comment_date',
        'rating',
        
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function service(){
        return $this->belongsTo('App\Models\Service');
    }


}
