<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class klhn extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ftphn() {
        return $this->belongsTo(ftphn::class,'slug','slug');
    }
    public function fotos() {
        return $this->hasMany(ftphn::class,'slug','slug');
    }
    public function surats() {
        return $this->hasMany(suratrth::class,'slug','slug');
    }
    public function lmrecs() {
        return $this->hasMany(lmrecomen::class,'slug','slug');
    }
    public function surveis() {
        return $this->hasMany(ftsurvei::class,'slug','slug');
    }
    public function plksns() {
        return $this->hasMany(plksn::class,'slug','slug');
    }
    public function datauser(){
        return $this->hasOne(User::class,'uuid','uuid');
    }
}
