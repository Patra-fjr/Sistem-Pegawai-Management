<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\EmployeeModel;
use App\Models\UserModel;

class EmployeeController extends ResourceController
{
    protected $format = 'json';

    protected $employeeModel;
    protected $userModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
        $this->userModel     = new UserModel();
    }

    /**
     * GET /api/employees
     * Ambil semua data pegawai
     */
    public function index()
    {
        $employees = $this->employeeModel
            ->select('employees.id, employees.nip, employees.gender, employees.phone,
                      employees.address, employees.salary, employees.photo,
                      users.name, users.email,
                      departments.department_name,
                      positions.position_name')
            ->join('users', 'users.id = employees.user_id')
            ->join('departments', 'departments.id = employees.department_id')
            ->join('positions', 'positions.id = employees.position_id')
            ->findAll();

        return $this->respond([
            'status'  => 200,
            'message' => 'Data pegawai berhasil diambil',
            'data'    => $employees,
        ]);
    }

    /**
     * GET /api/employees/{id}
     * Ambil satu data pegawai berdasarkan ID
     */
    public function show($id = null)
    {
        $employee = $this->employeeModel
            ->select('employees.id, employees.nip, employees.gender, employees.phone,
                      employees.address, employees.salary, employees.photo,
                      employees.user_id,
                      users.name, users.email,
                      departments.id AS department_id, departments.department_name,
                      positions.id AS position_id, positions.position_name')
            ->join('users', 'users.id = employees.user_id')
            ->join('departments', 'departments.id = employees.department_id')
            ->join('positions', 'positions.id = employees.position_id')
            ->find($id);

        if (!$employee) {
            return $this->failNotFound('Pegawai dengan ID ' . $id . ' tidak ditemukan');
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Data pegawai berhasil diambil',
            'data'    => $employee,
        ]);
    }

    /**
     * POST /api/employees
     * Tambah data pegawai baru
     * Body (JSON):
     *   name, email, password, nip, department_id, position_id,
     *   gender, phone, address, salary
     */
    public function create()
    {
        $input = $this->request->getJSON(true);

        // Validasi input
        $rules = [
            'name'          => 'required',
            'email'         => 'required|valid_email|is_unique[users.email]',
            'password'      => 'required|min_length[6]',
            'nip'           => 'required|is_unique[employees.nip]',
            'department_id' => 'required|integer',
            'position_id'   => 'required|integer',
            'gender'        => 'required|in_list[Laki-laki,Perempuan]',
            'phone'         => 'required',
            'address'       => 'required',
            'salary'        => 'required|numeric',
        ];

        if (!$this->validateData($input ?? [], $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        // Simpan ke tabel users
        $this->userModel->save([
            'name'     => $input['name'],
            'email'    => $input['email'],
            'password' => password_hash($input['password'], PASSWORD_DEFAULT),
            'role'     => 'pegawai',
        ]);
        $userId = $this->userModel->getInsertID();

        // Simpan ke tabel employees
        $this->employeeModel->save([
            'user_id'       => $userId,
            'department_id' => $input['department_id'],
            'position_id'   => $input['position_id'],
            'nip'           => $input['nip'],
            'gender'        => $input['gender'],
            'phone'         => $input['phone'],
            'address'       => $input['address'],
            'salary'        => $input['salary'],
            'photo'         => $input['photo'] ?? null,
        ]);
        $employeeId = $this->employeeModel->getInsertID();

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Pegawai berhasil ditambahkan',
            'data'    => ['id' => $employeeId],
        ]);
    }

    /**
     * PUT /api/employees/{id}
     * Update data pegawai
     * Body (JSON):
     *   name, email, nip, department_id, position_id,
     *   gender, phone, address, salary
     */
    public function update($id = null)
    {
        $employee = $this->employeeModel->find($id);

        if (!$employee) {
            return $this->failNotFound('Pegawai dengan ID ' . $id . ' tidak ditemukan');
        }

        $input = $this->request->getJSON(true);

        // Validasi input
        $rules = [
            'name'          => 'required',
            'email'         => "required|valid_email|is_unique[users.email,id,{$employee['user_id']}]",
            'nip'           => "required|is_unique[employees.nip,id,{$id}]",
            'department_id' => 'required|integer',
            'position_id'   => 'required|integer',
            'gender'        => 'required|in_list[Laki-laki,Perempuan]',
            'phone'         => 'required',
            'address'       => 'required',
            'salary'        => 'required|numeric',
        ];

        if (!$this->validateData($input ?? [], $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        // Update tabel users
        $this->userModel->update($employee['user_id'], [
            'name'  => $input['name'],
            'email' => $input['email'],
        ]);

        // Update tabel employees
        $this->employeeModel->update($id, [
            'department_id' => $input['department_id'],
            'position_id'   => $input['position_id'],
            'nip'           => $input['nip'],
            'gender'        => $input['gender'],
            'phone'         => $input['phone'],
            'address'       => $input['address'],
            'salary'        => $input['salary'],
        ]);

        return $this->respond([
            'status'  => 200,
            'message' => 'Pegawai berhasil diupdate',
            'data'    => ['id' => (int) $id],
        ]);
    }

    /**
     * DELETE /api/employees/{id}
     * Hapus data pegawai
     */
    public function delete($id = null)
    {
        $employee = $this->employeeModel->find($id);

        if (!$employee) {
            return $this->failNotFound('Pegawai dengan ID ' . $id . ' tidak ditemukan');
        }

        // Hapus foto jika ada
        if (!empty($employee['photo'])) {
            $photoPath = FCPATH . 'uploads/employees/' . $employee['photo'];
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        $this->employeeModel->delete($id);
        $this->userModel->delete($employee['user_id']);

        return $this->respondDeleted([
            'status'  => 200,
            'message' => 'Pegawai berhasil dihapus',
            'data'    => ['id' => (int) $id],
        ]);
    }
}
