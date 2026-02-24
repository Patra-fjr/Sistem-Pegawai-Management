<?php

namespace App\Controllers;

use App\Models\PositionModel;

class PositionController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PositionModel();
    }

    public function index()
    {
        $data['positions'] = $this->model->findAll();
        $data['title'] = 'Jabatan';
        return view('positions/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Jabatan';
        return view('positions/create', $data);
    }

    public function store()
    {
        $this->model->save([
            'position_name' => $this->request->getPost('position_name'),
        ]);
        return redirect()->to('/positions')->with('success', 'Jabatan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data['position'] = $this->model->find($id);
        $data['title'] = 'Edit Jabatan';
        return view('positions/edit', $data);
    }

    public function update($id)
    {
        $this->model->update($id, [
            'position_name' => $this->request->getPost('position_name'),
        ]);
        return redirect()->to('/positions')->with('success', 'Jabatan berhasil diupdate!');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/positions')->with('success', 'Jabatan berhasil dihapus!');
    }
}