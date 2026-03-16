<?php

namespace App\Controllers;

use App\Models\DocenteModel;
use App\Models\MateriaModel;
use App\Models\HorarioModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class HorariosController extends BaseController
{
  
    public function asignar()
    {
        $docenteModel = new DocenteModel();
        $materiaModel = new MateriaModel();

        $docentes = $docenteModel->orderBy('nombres', 'asc')->findAll();
        $materias = $materiaModel->orderBy('nombre_materia', 'asc')->findAll();

        $data = [
            'docentes' => $docentes,
            'materias' => $materias,
        ];

        return view('horarios/asignar_view', $data);
    }


    public function guardarAsignacion()
    {
        $idDocente = $this->request->getPost('id_docente');
        $idMateria = $this->request->getPost('id_materia');

        $dia1       = $this->request->getPost('dia_1');
        $horaInicio1 = $this->request->getPost('hora_inicio_1');
        $horaFin1    = $this->request->getPost('hora_fin_1');

        $dia2        = $this->request->getPost('dia_2');
        $horaInicio2 = $this->request->getPost('hora_inicio_2');
        $horaFin2    = $this->request->getPost('hora_fin_2');

        if ($horaInicio1 !== null && $horaFin1 !== null && $horaFin1 <= $horaInicio1) {
            return redirect()->back()->withInput()->with('error', 'En el Día 1, la hora de fin debe ser posterior a la hora de inicio. (Use 12:00 para mediodía; 00:00 es medianoche.)');
        }

        if (!empty($dia2)) {
            if ($horaInicio2 === null || $horaFin2 === null) {
                return redirect()->back()->withInput()->with('error', 'Si selecciona un Día 2 debe indicar hora de inicio y fin para ese día.');
            }
            if ($horaFin2 <= $horaInicio2) {
                return redirect()->back()->withInput()->with('error', 'En el Día 2, la hora de fin debe ser posterior a la hora de inicio. (Use 12:00 para mediodía; 00:00 es medianoche.)');
            }
        }

        try {
            $horarioModel = new HorarioModel();

            // Día 1 (obligatorio)
            $horarioModel->insert([
                'id_docente'  => $idDocente,
                'id_materia'  => $idMateria,
                'dia_1'       => $dia1,
                'dia_2'       => null,
                'hora_inicio' => $horaInicio1,
                'hora_fin'    => $horaFin1,
            ]);

            // Día 2 (opcional, independiente)
            if (!empty($dia2)) {
                $horarioModel->insert([
                    'id_docente'  => $idDocente,
                    'id_materia'  => $idMateria,
                    'dia_1'       => $dia2,
                    'dia_2'       => null,
                    'hora_inicio' => $horaInicio2,
                    'hora_fin'    => $horaFin2,
                ]);
            }
        } catch (DatabaseException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(base_url('horarios/por_docente'))->with('success', 'Asignación guardada correctamente.');
    }


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

 
    public function editar($id)
    {
        $horarioModel = new HorarioModel();
        $docenteModel = new DocenteModel();
        $materiaModel = new MateriaModel();

        $horario = $horarioModel->find($id);
        if ($horario === null) {
            return redirect()->to(base_url('horarios/por_docente'));
        }

        $data = [
            'horario'  => $horario,
            'docentes' => $docenteModel->findAll(),
            'materias' => $materiaModel->findAll(),
        ];

        return view('horarios/editar_view', $data);
    }


    public function actualizar($id)
    {
        $horaInicio = $this->request->getPost('hora_inicio');
        $horaFin    = $this->request->getPost('hora_fin');

        if ($horaInicio !== null && $horaFin !== null && $horaFin <= $horaInicio) {
            return redirect()->back()->withInput()->with('error', 'La hora de fin debe ser posterior a la hora de inicio. (Use 12:00 para mediodía; 00:00 es medianoche.)');
        }

        $data = [
            'id_docente'  => $this->request->getPost('id_docente'),
            'id_materia'  => $this->request->getPost('id_materia'),
            'dia_1'       => $this->request->getPost('dia_1'),
            'dia_2'       => $this->request->getPost('dia_2'),
            'hora_inicio' => $horaInicio,
            'hora_fin'    => $horaFin,
        ];

        try {
            $horarioModel = new HorarioModel();
            $horarioModel->update($id, $data);
        } catch (DatabaseException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(base_url('horarios/por_docente'))->with('success', 'Asignación actualizada correctamente.');
    }


    public function eliminar($id)
    {
        try {
            $horarioModel = new HorarioModel();
            $horarioModel->delete($id);
        } catch (DatabaseException $e) {
            return redirect()->to(base_url('horarios/por_docente'))->with('error', $e->getMessage());
        }

        return redirect()->to(base_url('horarios/por_docente'))->with('success', 'Asignación eliminada correctamente.');
    }


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
