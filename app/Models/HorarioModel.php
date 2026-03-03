<?php

namespace App\Models;

use CodeIgniter\Model;

class HorarioModel extends Model
{
    protected $table            = 'horarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'id_docente',
        'id_materia',
        'dia_1',
        'dia_2',
        'hor-inicio',
        'hora_fin',
    ];

    /**
     * Obtiene los horarios asignados a un docente específico, 
     * incluyendo los nombres del docente y la materia.
     */
    public function getHorariosPorDocente($id_docente)
    {
        return $this->select('horarios.*, materias.nombre_materia, docentes.nombres, docentes.apellidos')
            ->join('materias', 'materias.id = horarios.id_materia')
            ->join('docentes', 'docentes.id = horarios.id_docente')
            ->where('horarios.id_docente', $id_docente)
            ->findAll();
    }

    /**
     * Obtiene los alumnos inscritos en una materia específica.
     * Asume la existencia de una tabla 'matricula'.
     */
    public function getAlumnosPorMateria($id_materia)
    {
        // Esta consulta asume una tabla `matricula` con `id_alumno` y `id_materia`
        return $this->db->table('matricula')
            ->select('alumnos.codigo, alumnos.nombres, alumnos.apellidos')
            ->join('alumnos', 'alumnos.id = matricula.id_alumno')
            ->where('matricula.id_materia', $id_materia)
            ->get()
            ->getResultArray();
    }
}
