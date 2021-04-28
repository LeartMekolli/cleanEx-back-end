<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    public $table = 'details';
    protected $fillable = [
        'first_name' ,
            'last_name' ,
            'birthday',
            'phone_number',
            'street_name'  ,
            'street_number' ,
            'postal_code' ,
            'region_id' ,
            'gender_id',
            'updated_at'
            
    ];
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
