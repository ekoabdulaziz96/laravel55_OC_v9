<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FtAdmin extends Model
{
    protected $table = 'ft_admin';
    protected $guarded = [];
	protected $dates = ['expired_at'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
