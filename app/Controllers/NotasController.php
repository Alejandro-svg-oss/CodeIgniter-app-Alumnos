<?php

namespace App\Controllers;

use App\Models\MateriaModel;
use App\Models\MatriculaModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class NotasController extends BaseController
{
    public function index()
    {
        $materiaModel = new MateriaModel();

        $data = [
            'materias' => $materiaModel->orderBy('nombre_materia', 'asc')->findAll(),
            'mensaje'  => session()->getFlashdata('mensaje'),
            'error'    => session()->getFlashdata('error'),
        ];

        return view('notas/index', $data);
    }

    public function porMateria($idMateria)
    {
        $idMateria = (int) $idMateria;
        if ($idMateria <= 0) {
            return $this->response->setJSON([]);
        }

        $periodo = (int) ($this->request->getGet('periodo') ?? 1);
        if ($periodo < 1 || $periodo > 4) {
            $periodo = 1;
        }

        $map = [
            1 => ['lab' => 'lab1', 'parcial' => 'parcial1'],
            2 => ['lab' => 'lab2', 'parcial' => 'parcial2'],
            3 => ['lab' => 'lab3', 'parcial' => 'parcial3'],
            4 => ['lab' => 'lab4', 'parcial' => 'parcial4'],
        ];

        $colLab = $map[$periodo]['lab'];
        $colParcial = $map[$periodo]['parcial'];

        $matriculaModel = new MatriculaModel();

        $alumnos = $matriculaModel
            ->select("matricula.id as id_matricula,
                      alumnos.id as id_alumno,
                      alumnos.codigo,
                      alumnos.nombres,
                      alumnos.apellidos,
                      matricula.$colLab as lab,
                      matricula.$colParcial as parcial")
            ->join('alumnos', 'alumnos.id = matricula.id_alumno')
            ->where('matricula.id_materia', $idMateria)
            ->orderBy('alumnos.nombres', 'asc')
            ->findAll();

        return $this->response->setJSON([
            'periodo' => $periodo,
            'alumnos' => $alumnos,
        ]);
    }

    public function guardar()
    {
        $periodo     = (int) ($this->request->getPost('periodo') ?? 1);
        if ($periodo < 1 || $periodo > 4) {
            $periodo = 1;
        }

        $map = [
            1 => ['lab' => 'lab1', 'parcial' => 'parcial1'],
            2 => ['lab' => 'lab2', 'parcial' => 'parcial2'],
            3 => ['lab' => 'lab3', 'parcial' => 'parcial3'],
            4 => ['lab' => 'lab4', 'parcial' => 'parcial4'],
        ];

        $colLab     = $map[$periodo]['lab'];
        $colParcial = $map[$periodo]['parcial'];

        $matriculaIds = $this->request->getPost('id_matricula') ?? [];
        $lab          = $this->request->getPost('lab') ?? [];
        $parcial      = $this->request->getPost('parcial') ?? [];

        if (empty($matriculaIds)) {
            return redirect()->back()->with('error', 'No hay datos para guardar.');
        }

        $matriculaModel = new MatriculaModel();

        try {
            foreach ($matriculaIds as $idMatricula) {
                $idMatricula = (int) $idMatricula;
                if ($idMatricula <= 0) {
                    continue;
                }

                $notaLab     = $lab[$idMatricula]     ?? null;
                $notaParcial = $parcial[$idMatricula] ?? null;

                $matriculaModel->update($idMatricula, [
                    $colLab     => $notaLab,
                    $colParcial => $notaParcial,
                ]);
            }
        } catch (DatabaseException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('mensaje', 'Notas guardadas correctamente.');
    }
}

