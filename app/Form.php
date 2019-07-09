<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
class Form extends Model
{
    // protected $table = 'kategori';
    // protected $fillable = [
    //     'nama','tipe','slug','status'
    // ]; 
    protected $table = 'form';
    protected $guarded = [];
    public function setTextArea(){
        return $this->hasMany(SetTextArea::class);
    }    
    public function pilihan(){
        return $this->hasMany(Pilihan::class);
    }
    //  public function status(){
    //     return $this->hasMany(Status::class);
    // }
//     public function __construct() {
//      $this->fillable(\Schema::getColumnListing($this->getTable()))
// }
}
