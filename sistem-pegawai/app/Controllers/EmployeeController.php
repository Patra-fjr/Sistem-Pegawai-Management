<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\UserModel;
use App\Models\DepartmentModel;
use App\Models\PositionModel;

class EmployeeController extends BaseController
{
    protected $employeeModel;
    protected $userModel;
    protected $departmentModel;
    protected $positionModel;

    public function __construct()
    {
        $this->employeeModel   = new EmployeeModel();
        $this->userModel       = new UserModel();
        $this->departmentModel = new DepartmentModel();
        $this->positionModel   = new PositionModel();
    }

    public function index()
    {
        $search     = $this->request->getGet('search');
        $department = $this->request->getGet('department');

        $builder = $this->employeeModel
            ->select('employees.*, users.name, users.email, departments.department_name, positions.position_name')
            ->join('users', 'users.id = employees.user_id')
            ->join('departments', 'departments.id = employees.department_id')
            ->join('positions', 'positions.id = employees.position_id');

        if ($search) {
            $builder->like('users.name', $search)->orLike('employees.nip', $search);
        }
        if ($department) {
            $builder->where('employees.department_id', $department);
        }

        $data['employees']    = $builder->findAll();
        $data['departments']  = $this->departmentModel->findAll();
        $data['title']        = 'Data Pegawai';
        return view('employees/index', $data);
    }

    public function create()
    {
        $data['departments'] = $this->departmentModel->findAll();
        $data['positions']   = $this->positionModel->findAll();
        $data['title']       = 'Tambah Pegawai';
        return view('employees/create', $data);
    }

    public function store()
    {
        $rules = [
            'name'          => 'required',
            'email'         => 'required|valid_email|is_unique[users.email]',
            'password'      => 'required|min_length[6]',
            'nip'           => 'required|is_unique[employees.nip]',
            'department_id' => 'required',
            'position_id'   => 'required',
            'gender'        => 'required',
            'phone'         => 'required',
            'address'       => 'required',
            'salary'        => 'required',
            'photo'         => 'uploaded[photo]|is_image[photo]|max_size[photo,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload foto
        $photo     = $this->request->getFile('photo');
        $photoName = $photo->getRandomName();
        $photo->move('uploads/employees', $photoName);

        // Simpan user
        $this->userModel->save([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'pegawai',
        ]);
        $userId = $this->userModel->getInsertID();

        // Simpan employee
        $this->employeeModel->save([
            'user_id'       => $userId,
            'department_id' => $this->request->getPost('department_id'),
            'position_id'   => $this->request->getPost('position_id'),
            'nip'           => $this->request->getPost('nip'),
            'gender'        => $this->request->getPost('gender'),
            'phone'         => $this->request->getPost('phone'),
            'address'       => $this->request->getPost('address'),
            'salary'        => $this->request->getPost('salary'),
            'photo'         => $photoName,
        ]);

        return redirect()->to('/employees')->with('success', 'Pegawai berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $employee = $this->employeeModel
            ->select('employees.*, users.name, users.email')
            ->join('users', 'users.id = employees.user_id')
            ->find($id);

        $data['employee']    = $employee;
        $data['departments'] = $this->departmentModel->findAll();
        $data['positions']   = $this->positionModel->findAll();
        $data['title']       = 'Edit Pegawai';
        return view('employees/edit', $data);
    }

    public function update($id)
    {
        $employee = $this->employeeModel->find($id);

        $rules = [
            'name'          => 'required',
            'email'         => "required|valid_email|is_unique[users.email,id,{$employee['user_id']}]",
            'nip'           => "required|is_unique[employees.nip,id,{$id}]",
            'department_id' => 'required',
            'position_id'   => 'required',
            'gender'        => 'required',
            'phone'         => 'required',
            'address'       => 'required',
            'salary'        => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update foto jika ada
        $photoName = $employee['photo'];
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            if (!$this->validateData(['photo' => $photo], ['photo' => 'is_image[photo]|max_size[photo,2048]'])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
            if ($photoName && file_exists('uploads/employees/' . $photoName)) {
                unlink('uploads/employees/' . $photoName);
            }
            $photoName = $photo->getRandomName();
            $photo->move('uploads/employees', $photoName);
        }

        // Update user
        $this->userModel->update($employee['user_id'], [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ]);

        // Update employee
        $this->employeeModel->update($id, [
            'department_id' => $this->request->getPost('department_id'),
            'position_id'   => $this->request->getPost('position_id'),
            'nip'           => $this->request->getPost('nip'),
            'gender'        => $this->request->getPost('gender'),
            'phone'         => $this->request->getPost('phone'),
            'address'       => $this->request->getPost('address'),
            'salary'        => $this->request->getPost('salary'),
            'photo'         => $photoName,
        ]);

        return redirect()->to('/employees')->with('success', 'Pegawai berhasil diupdate!');
    }

    public function delete($id)
    {
        $employee = $this->employeeModel->find($id);
        if ($employee['photo'] && file_exists('uploads/employees/' . $employee['photo'])) {
            unlink('uploads/employees/' . $employee['photo']);
        }
        $this->userModel->delete($employee['user_id']);
        $this->employeeModel->delete($id);
        return redirect()->to('/employees')->with('success', 'Pegawai berhasil dihapus!');
    }

    public function show($id)
    {
        $employee = $this->employeeModel
            ->select('employees.*, users.name, users.email, departments.department_name, positions.position_name')
            ->join('users', 'users.id = employees.user_id')
            ->join('departments', 'departments.id = employees.department_id')
            ->join('positions', 'positions.id = employees.position_id')
            ->find($id);

        $data['employee'] = $employee;
        $data['title']    = 'Detail Pegawai';
        return view('employees/show', $data);
    }
}