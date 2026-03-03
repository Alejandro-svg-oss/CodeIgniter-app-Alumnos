<?php

namespace App\Controllers;

use App\Models\DocenteModel;
use App\Models\MateriaModel;
use App\Models\HorarioModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class HorariosController extends BaseController
{
    /**
     * Muestra el formulario para asignar una materia a un docente.
     */
    public function asignar()
    {
        $docenteModel = new DocenteModel();
        $materiaModel = new MateriaModel();

        $data = [
            'docentes' => $docenteModel->findAll(),
            'materias' => $materiaModel->findAll(),
        ];

        return view('horarios/asignar_view', $data);
    }

    /**
     * Guarda la nueva asignación de horario.
     */
    public function guardarAsignacion()
    {
        $data = [
            'id_docente' => $this->request->getPost('id_docente'),
            'id_materia' => $this->request->getPost('id_materia'),
            'dia_1'      => $this->request->getPost('dia_1'),
            'dia_2'      => $this->request->getPost('dia_2'),
            'hor-inicio'=> $this->request->getPost('hor-inicio'),
            'hora_fin'   => $this->request->getPost('hora_fin'),
        ];

        try {
            $horarioModel = new HorarioModel();
            $horarioModel->insert($data);
        } catch (DatabaseException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(base_url('horarios/por_docente'))->with('success', 'Asignación guardada correctamente.');
    }

    /**
     * Muestra la página para filtrar materias por docente.
     */
    public function porDocente()
    {
        $docenteModel = new DocenteModel();
        $data = [
            'docentes' => $docenteModel->findAll(),
            'horarios' => [],
            'docente_seleccionado' => null,
        ];

        return view('horarios/por_docente_view', $data);
    }

    /**
     * Filtra y muestra los horarios de un docente específico.
     */
    public function filtrarPorDocente()
    {
        $id_docente = $this->request->getPost('id_docente');

        $docenteModel = new DocenteModel();
        $horarioModel = new HorarioModel();

        $data = [
            'docentes' => $docenteModel->findAll(),
            'horarios' => $horarioModel->getHorariosPorDocente($id_docente),
            'docente_seleccionado' => $docenteModel->find($id_docente),
        ];

        return view('horarios/por_docente_view', $data);
    }

    /**
     * Muestra la página para filtrar alumnos por materia.
     */
    public function porMateria()
    {
        $materiaModel = new MateriaModel();
        $data = [
            'materias' => $materiaModel->findAll(),
            'alumnos' => [],
            'materia_seleccionada' => null,
        ];

        return view('horarios/por_materia_view', $data);
    }

    /**
     * Filtra y muestra los alumnos de una materia específica.
     */
    public function filtrarPorMateria()
    {
        $id_materia = $this->request->getPost('id_materia');

        $materiaModel = new MateriaModel();
        $horarioModel = new HorarioModel();

        $data = [
            'materias' => $materiaModel->findAll(),
            'alumnos'  => $horarioModel->getAlumnosPorMateria($id_materia),
            'materia_seleccionada' => $materiaModel->find($id_materia),
        ];

        return view('horarios/por_materia_view', $data);
    }
}
