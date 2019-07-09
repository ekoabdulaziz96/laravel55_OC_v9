<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];
    protected $hidden = [
        'remember_token',
    ];

    public function ftAdmin(){
        return $this->hasMany(FtAdmin::class);
    }
    public function ftSponsorship(){
        return $this->hasMany(FtSponsorship::class);
    }
    public function ftKacab(){
        return $this->hasMany(FtKacab::class);
    }
    public function manajer(){
        return $this->hasMany(Manajer::class);
    }
    public function direktur(){
        return $this->hasMany(Direktur::class);
    }

    public function cabang(){
        return $this->belongsTo(Cabang::class);
    }
}
