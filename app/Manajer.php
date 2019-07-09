<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manajer extends Model
{
    protected $table = 'manajer';
    protected $guarded = [];
	protected $dates = ['expired_at'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
