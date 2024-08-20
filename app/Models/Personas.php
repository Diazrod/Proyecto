<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personas extends Model
{
    use HasFactory;

    protected $table = 'personas';

    protected $primaryKey = 'COD_PERSONAS'; // Asegúrate de que la clave primaria esté configurada correctamente
    public $timestamps = false; // Si no utilizas timestamps en esta tabla

    protected $fillable = [
        'PR_NOMBRE', 'SG_NOMBRE', 'PR_APELLIDO', 'SG_APELLIDO', // Añade otros campos según sea necesario
    ];
}
