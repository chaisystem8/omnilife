<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empleado extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['codigo', 'nombre', 'salarioDolares', 'salarioPesos', 'direccion', 'estado', 'ciudad', 'celular', 'correo', 'activo'];
}
