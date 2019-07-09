<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pilihan extends Model
{
    protected $table = 'pilihan';
    protected $guarded = [];
    public function form(){
        return $this->belongsTo(Form::class);
    }
        
}
