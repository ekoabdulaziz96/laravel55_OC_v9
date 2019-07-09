<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FtKacab extends Model
{
    protected $table = 'ft_kacab';
    protected $guarded = [];
	protected $dates = ['expired_at'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
