<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FtSponsorship extends Model
{
    protected $table = 'ft_sponsorship';
    protected $guarded = [];
	protected $dates = ['expired_at'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
