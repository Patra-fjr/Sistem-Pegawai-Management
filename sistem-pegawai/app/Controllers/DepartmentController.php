<?php

namespace App\Controllers;

use App\Models\DepartmentModel;

class DepartmentController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DepartmentModel();
    }

    public function index()
    {
        $data['departments'] = $this->model->findAll();
        $data['title'] = 'Departemen';
        return view('departments/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Departemen';
        return view('departments/create', $data);
    }

    public function store()
    {
        $this->model->save([
            'department_name' => $this->request->getPost('department_name'),
        ]);
        return redirect()->to('/departments')->with('success', 'Departemen berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data['department'] = $this->model->find($id);
        $data['title'] = 'Edit Departemen';
        return view('departments/edit', $data);
    }

    public function update($id)
    {
        $this->model->update($id, [
            'department_name' => $this->request->getPost('department_name'),
        ]);
        return redirect()->to('/departments')->with('success', 'Departemen berhasil diupdate!');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/departments')->with('success', 'Departemen berhasil dihapus!');
    }
}