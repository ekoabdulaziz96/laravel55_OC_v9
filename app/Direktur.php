<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direktur extends Model
{
    protected $table = 'direktur';
    protected $guarded = [];
	protected $dates = ['expired_at'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
