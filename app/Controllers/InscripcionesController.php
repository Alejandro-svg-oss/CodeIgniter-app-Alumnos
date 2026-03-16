<?php

namespace App\Controllers;

use App\Models\AlumnoModel;
use App\Models\MateriaModel;
use App\Models\MatriculaModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class InscripcionesController extends BaseController
{
    public function index()
    {
        $alumnoModel  = new AlumnoModel();
        $materiaModel = new MateriaModel();

        $data = [
            'alumnos'   => $alumnoModel->orderBy('nombres', 'asc')->findAll(),
            'materias'  => $materiaModel->orderBy('nombre_materia', 'asc')->findAll(),
            'mensaje'   => session()->getFlashdata('mensaje'),
            'error'     => session()->getFlashdata('error'),
        ];

        return view('inscripciones/index', $data);
    }

    public function guardar()
    {
        $idAlumno    = (int) $this->request->getPost('id_alumno');
        $materiasIds = $this->request->getPost('id_materia') ?? [];

        if ($idAlumno <= 0 || empty($materiasIds)) {
            return redirect()->back()->withInput()->with('error', 'Debe seleccionar un alumno y al menos una materia.');
        }

        $matriculaModel = new MatriculaModel();

        $actuales = $matriculaModel->contarMateriasAlumno($idAlumno);
        $nuevas   = count($materiasIds);

        if ($actuales + $nuevas > 5) {
            return redirect()->back()->withInput()->with('error', 'No se pueden inscribir más de 5 materias por alumno.');
        }

        try {
            foreach ($materiasIds as $idMateria) {
                $idMateria = (int) $idMateria;
                if ($idMateria <= 0) {
                    continue;
                }

                $existe = $matriculaModel
                    ->where('id_alumno', $idAlumno)
                    ->where('id_materia', $idMateria)
                    ->first();

                if ($existe === null) {
                    $matriculaModel->insert([
                        'id_alumno'  => $idAlumno,
                        'id_materia' => $idMateria,
                    ]);
                }
            }
        } catch (DatabaseException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(base_url('inscripciones'))->with('mensaje', 'Inscripción guardada correctamente.');
    }

    public function materiasPorAlumno($idAlumno)
    {
        $idAlumno = (int) $idAlumno;
        if ($idAlumno <= 0) {
            return $this->response->setJSON([]);
        }

        $matriculaModel = new MatriculaModel();
        $materias       = $matriculaModel->obtenerMateriasPorAlumno($idAlumno);

        return $this->response->setJSON($materias);
    }
}

