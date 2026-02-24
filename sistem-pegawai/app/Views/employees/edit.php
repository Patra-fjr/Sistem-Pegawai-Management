<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<h2>Edit Pegawai</h2>
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
        <form action="/employees/update/<?= $employee['id'] ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="<?= $employee['name'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $employee['email'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>NIP</label>
                    <input type="text" name="nip" class="form-control" value="<?= $employee['nip'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Departemen</label>
                    <select name="department_id" class="form-select" required>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?= $dept['id'] ?>" 
                                <?= $dept['id'] == $employee['department_id'] ? 'selected' : '' ?>>
                                <?= $dept['department_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Jabatan</label>
                    <select name="position_id" class="form-select" required>
                        <?php foreach ($positions as $pos): ?>
                            <option value="<?= $pos['id'] ?>"
                                <?= $pos['id'] == $employee['position_id'] ? 'selected' : '' ?>>
                                <?= $pos['position_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Jenis Kelamin</label>
                    <select name="gender" class="form-select" required>
                        <option value="Laki-laki" <?= $employee['gender'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= $employee['gender'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>No. HP</label>
                    <input type="text" name="phone" class="form-control" value="<?= $employee['phone'] ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Gaji</label>
                    <input type="number" name="salary" class="form-control" value="<?= $employee['salary'] ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Foto (kosongkan jika tidak diubah)</label>
                    <?php if ($employee['photo']): ?>
                        <div class="mb-2">
                            <img src="/uploads/employees/<?= $employee['photo'] ?>" width="80" height="80" style="object-fit:cover; border-radius:8px">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                </div>
                <div class="col-md-12 mb-3">
                    <label>Alamat</label>
                    <textarea name="address" class="form-control" rows="3"><?= $employee['address'] ?></textarea>
                </div>
            </div>
            <a href="/employees" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>