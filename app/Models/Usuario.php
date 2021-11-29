<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $hidden = ['contraseña','created_at','updated_at'];
    public function cursos()
    {
        return $this->belongsToMany(Curso::class,'cursos_inscritos');
    }
}
