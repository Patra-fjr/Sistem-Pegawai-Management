<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<h2>Tambah Pegawai</h2>
<hr>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="/employees/store" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <h5 class="mb-3">Data Akun</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" 
                           value="<?= old('name') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" 
                           value="<?= old('email') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>NIP</label>
                    <input type="text" name="nip" class="form-control" 
                           value="<?= old('nip') ?>" required>
                </div>
            </div>
            <h5 class="mb-3 mt-2">Data Pegawai</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Departemen</label>
                    <select name="department_id" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?= $dept['id'] ?>"><?= $dept['department_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Jabatan</label>
                    <select name="position_id" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <?php foreach ($positions as $pos): ?>
                            <option value="<?= $pos['id'] ?>"><?= $pos['position_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Jenis Kelamin</label>
                    <select name="gender" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>No. HP</label>
                    <input type="text" name="phone" class="form-control" 
                           value="<?= old('phone') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Gaji</label>
                    <input type="number" name="salary" class="form-control" 
                           value="<?= old('salary') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Foto</label>
                    <input type="file" name="photo" class="form-control" accept="image/*" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Alamat</label>
                    <textarea name="address" class="form-control" rows="3" required><?= old('address') ?></textarea>
                </div>
            </div>
            <a href="/employees" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>