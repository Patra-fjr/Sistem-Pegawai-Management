<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\EmployeeModel;

class ProfileController extends BaseController
{
    private function getEmployee($userId)
    {
        $employeeModel = new EmployeeModel();
        return $employeeModel
            ->select('employees.*, departments.department_name, positions.position_name')
            ->join('departments', 'departments.id = employees.department_id', 'left')
            ->join('positions', 'positions.id = employees.position_id', 'left')
            ->where('employees.user_id', $userId)
            ->first();
    }

    public function index()
    {
        $userModel = new UserModel();
        $userId    = session()->get('user_id');
        $user      = $userModel->find($userId);
        $employee  = $this->getEmployee($userId);

        return view('profile/index', [
            'title'    => 'Profil Saya',
            'user'     => $user,
            'employee' => $employee,
        ]);
    }

    public function edit()
    {
        $userModel = new UserModel();
        $userId    = session()->get('user_id');
        $user      = $userModel->find($userId);
        $employee  = $this->getEmployee($userId);

        return view('profile/edit', [
            'title'    => 'Edit Profil',
            'user'     => $user,
            'employee' => $employee,
        ]);
    }

    public function update()
    {
        $userModel     = new UserModel();
        $employeeModel = new EmployeeModel();
        $userId        = session()->get('user_id');

        $name  = $this->request->getPost('name');
        $email = $this->request->getPost('email');

        // Cek email sudah dipakai user lain
        $existing = $userModel->where('email', $email)->where('id !=', $userId)->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Email sudah digunakan oleh pengguna lain.');
        }

        $userData = [
            'name'  => $name,
            'email' => $email,
        ];

        // Ganti password jika diisi
        $newPassword     = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if (!empty($newPassword)) {
            if ($newPassword !== $confirmPassword) {
                return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.');
            }
            $userData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $userModel->update($userId, $userData);

        // Upload foto jika ada
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $employee = $this->getEmployee($userId);

            // Hapus foto lama
            if ($employee && !empty($employee['photo'])) {
                $oldPath = FCPATH . 'uploads/employees/' . $employee['photo'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $photoName = $photo->getRandomName();
            $photo->move('uploads/employees', $photoName);

            if ($employee) {
                $employeeModel->update($employee['id'], ['photo' => $photoName]);
            }
        }

        // Update session
        session()->set([
            'name'  => $name,
            'email' => $email,
        ]);

        return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
