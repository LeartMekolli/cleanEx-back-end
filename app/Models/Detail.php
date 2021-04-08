<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    protected $fillable = ['region_id','gender_id','first_name','last_name','birthday','image','phone_number','street_name','street_number','postal_code'];
    
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
