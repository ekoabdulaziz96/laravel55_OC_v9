<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table = 'cabang';
    protected $guarded = [];

    public function user(){
	    return $this->hasMany(User::class);
	}
}
