<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';
    public $timestamps = false; // Desactiva las marcas de tiempo

    protected $primaryKey = 'COD_EMPLEADO';

    protected $fillable = [
        'COD_PERSONAS',
        'NOM_AREA',
        'FECH_CONTRATO',
        'SALARIO',
        'EST_EMPLEADO'
    ];

    public function persona()
    {
        return $this->belongsTo(Personas::class, 'COD_PERSONAS', 'COD_PERSONAS');
    }
}
