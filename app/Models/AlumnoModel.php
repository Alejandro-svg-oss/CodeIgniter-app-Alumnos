<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumnoModel extends Model
{
    protected $table            = 'alumnos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'codigo',
        'nombres',
        'apellidos',
        'telefono',
        'codigo_carrera', // <-- Añadir
    ];

    protected $useTimestamps = false;
}
?>
