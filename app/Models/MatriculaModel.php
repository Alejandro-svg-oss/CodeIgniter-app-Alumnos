<?php

namespace App\Models;

use CodeIgniter\Model;

class MatriculaModel extends Model
{
    protected $table            = 'matricula';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'id_alumno',
        'id_materia',
        'lab1',
        'parcial1',
        'lab2',
        'parcial2',
        'lab3',
        'parcial3',
        'lab4',
        'parcial4',
    ];

    protected $useTimestamps = false;

    public function contarMateriasAlumno(int $idAlumno): int
    {
        return $this->where('id_alumno', $idAlumno)->countAllResults();
    }

    public function obtenerMateriasPorAlumno(int $idAlumno): array
    {
        return $this->select('matricula.*, materias.nombre_materia')
            ->join('materias', 'materias.id = matricula.id_materia')
            ->where('matricula.id_alumno', $idAlumno)
            ->orderBy('materias.nombre_materia', 'asc')
            ->findAll();
    }
}

