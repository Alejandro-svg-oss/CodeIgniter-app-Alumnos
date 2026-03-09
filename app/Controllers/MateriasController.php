<?php

namespace App\Controllers;

use App\Models\MateriaModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class MateriasController extends BaseController
{
    public function index()
    {
        $model    = new MateriaModel();
        $materias = $model->orderBy('nombre_materia', 'asc')->findAll();

        return view('materias/index', ['materias' => $materias]);
    }

    public function create()
    {
        return view('materias/create');
    }

    public function store()
    {
        $data = [
            'nombre_materia' => $this->request->getPost('nombre_materia'),
            'descripcion'    => $this->request->getPost('descripcion'),
        ];

        try {
            $model = new MateriaModel();
            $model->insert($data);
        } catch (DatabaseException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(base_url('materias'))->with('success', 'Materia guardada correctamente.');
    }

    public function edit($id)
    {
        $model   = new MateriaModel();
        $materia = $model->find($id);

        if ($materia === null) {
            return redirect()->to(base_url('materias'));
        }

        return view('materias/edit', ['materia' => $materia]);
    }

    public function update($id)
    {
        $data = [
            'nombre_materia' => $this->request->getPost('nombre_materia'),
            'descripcion'    => $this->request->getPost('descripcion'),
        ];

        try {
            $model = new MateriaModel();
            $model->update($id, $data);
        } catch (DatabaseException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(base_url('materias'))->with('success', 'Materia actualizada correctamente.');
    }

    public function delete($id)
    {
        try {
            $model = new MateriaModel();
            $model->delete($id);
        } catch (DatabaseException $e) {
            return redirect()->to(base_url('materias'))->with('error', $e->getMessage());
        }

        return redirect()->to(base_url('materias'))->with('success', 'Materia eliminada correctamente.');
    }
}

