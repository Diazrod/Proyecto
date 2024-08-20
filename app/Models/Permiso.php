<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permisos';
    protected $primaryKey = 'COD_PERMISOS';
    protected $fillable = [
        'COD_ROL',
        'COD_OBJETO',
        'IND_MODULO',
        'IND_SELECT',
        'IND_INSERT',
        'IND_UPDATE',
        'USR_ADD',
    ];

    public function role()
    {
        return $this->belongsTo(Roles::class, 'COD_ROL');
    }

    public function objeto()
    {
        return $this->belongsTo(Objetos::class, 'COD_OBJETO');
    }
}
