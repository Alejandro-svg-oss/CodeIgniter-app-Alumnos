<?php

namespace App\Controllers;

use App\Models\DocenteModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class DocentesController extends BaseController
{
    public function index()
    {
        $model    = new DocenteModel();
        $docentes = $model->orderBy('nombres', 'asc')->findAll();

        return view('docentes/index', ['docentes' => $docentes]);
    }

    public function create()
    {
        return view('docentes/create');
    }

    public function store()
    {
        $data = [
            'nombres'   => $this->request->getPost('nombres'),
            'apellidos' => $this->request->getPost('apellidos'),
            'email'     => $this->request->getPost('email'),
        ];

        try {
            $model = new DocenteModel();
            // Validar email duplicado
            $existente = $model->where('email', $data['email'])->first();
            if ($existente !== null) {
                return redirect()
                    ->to(base_url('docentes/create'))
                    ->withInput()
                    ->with('error', 'Ya existe un docente con ese email.');
            }

            $model->insert($data);
        } catch (DatabaseException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(base_url('docentes'))->with('success', 'Docente guardado correctamente.');
    }

    public function edit($id)
    {
        $model   = new DocenteModel();
        $docente = $model->find($id);

        if ($docente === null) {
            return redirect()->to(base_url('docentes'));
        }

        return view('docentes/edit', ['docente' => $docente]);
    }

    public function update($id)
    {
        $data = [
            'nombres'   => $this->request->getPost('nombres'),
            'apellidos' => $this->request->getPost('apellidos'),
            'email'     => $this->request->getPost('email'),
        ];

        try {
            $model = new DocenteModel();
            // Validar duplicado de email en otro registro
            $existente = $model
                ->where('email', $data['email'])
                ->where('id !=', $id)
                ->first();

            if ($existente !== null) {
                return redirect()
                    ->to(base_url('docentes/edit/' . $id))
                    ->withInput()
                    ->with('error', 'Ya existe otro docente con ese email.');
            }

            $model->update($id, $data);
        } catch (DatabaseException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(base_url('docentes'))->with('success', 'Docente actualizado correctamente.');
    }

    public function delete($id)
    {
        try {
            $model = new DocenteModel();
            $model->delete($id);
        } catch (DatabaseException $e) {
            return redirect()->to(base_url('docentes'))->with('error', $e->getMessage());
        }

        return redirect()->to(base_url('docentes'))->with('success', 'Docente eliminado correctamente.');
    }
}

