<?php

namespace App\Controllers;

use App\Models\AlumnoModel;
use App\Models\Alumno_carreraModel; // <-- Importar el nuevo modelo
use CodeIgniter\Database\Exceptions\DatabaseException;

class AlumnosController extends BaseController
{
    public function index()
    {
        $alumnos = [];
        $dbError = null;

        try {
            $model = new AlumnoModel();

            // Listado simple, DataTables se encargará del filtrado/orden en el cliente.
            $alumnos = $model->orderBy('nombres', 'asc')->findAll();
        } catch (DatabaseException $e) {
            $dbError = $e->getMessage();
        }

        return view('alumnos_list', [
            'alumnos' => $alumnos,
            'dbError' => $dbError,
        ]);
    }

    public function create()
    {
        $carreraModel = new Alumno_carreraModel();
        $data['carreras'] = $carreraModel->obtenerCarreras();
        return view('alumnos_create', $data);
    }

    public function store()
    {
        $data = [
            'codigo'   => $this->request->getPost('codigo'),
            'nombres'  => $this->request->getPost('nombres'),
            'apellidos'=> $this->request->getPost('apellidos'),
            'telefono' => $this->request->getPost('telefono'),
            'codigo_carrera' => $this->request->getPost('codigo_carrera'), // <-- Añadir carrera
        ];

        try {
            $model = new AlumnoModel();

        
            $existente = $model->where('codigo', $data['codigo'])->first();
            if ($existente !== null) {
                return redirect()
                    ->to(base_url('alumnos/create'))
                    ->withInput()
                    ->with('error', 'Ya existe un alumno con ese código.');
            }

            $model->insert($data);
        } catch (DatabaseException $e) {
            return redirect()
                ->to(base_url('alumnos/create'))
                ->withInput()
                ->with('error', $e->getMessage());
        }

        return redirect()->to(base_url('alumnos'));
    }

    public function edit($id)
    {
        $model  = new AlumnoModel();
        $alumno = $model->find($id);

        if ($alumno === null) {
            return redirect()->to(base_url('alumnos'));
        }

        $carreraModel = new Alumno_carreraModel();
        $data['carreras'] = $carreraModel->obtenerCarreras();
        $data['alumno'] = $alumno;

        return view('alumnos_edit', $data);
    }

    public function update($id)
    {
        $data = [
            'codigo'   => $this->request->getPost('codigo'),
            'nombres'  => $this->request->getPost('nombres'),
            'apellidos'=> $this->request->getPost('apellidos'),
            'telefono' => $this->request->getPost('telefono'),
            'codigo_carrera' => $this->request->getPost('codigo_carrera'), // <-- Añadir carrera
        ];

        try {
            $model = new AlumnoModel();

            // Verificar duplicado de código en otro registro
            $existente = $model
                ->where('codigo', $data['codigo'])
                ->where('id !=', $id)
                ->first();

            if ($existente !== null) {
                return redirect()
                    ->to(base_url('alumnos/edit/' . $id))
                    ->withInput()
                    ->with('error', 'Ya existe otro alumno con ese código.');
            }

            $model->update($id, $data);
        } catch (DatabaseException $e) {
            return redirect()
                ->to(base_url('alumnos/edit/' . $id))
                ->withInput()
                ->with('error', $e->getMessage());
        }

        return redirect()->to(base_url('alumnos'));
    }

    public function delete($id)
    {
        try {
            $model = new AlumnoModel();
            $model->delete($id);
        } catch (DatabaseException $e) {
            return redirect()
                ->to(base_url('alumnos'))
                ->with('error', $e->getMessage());
        }

        return redirect()->to(base_url('alumnos'));
    }
}
