<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Data Pegawai</h2>
    <a href="/employees/create" class="btn btn-primary">
        <i class="bi bi-plus"></i> Tambah Pegawai
    </a>
</div>

<!-- Search & Filter -->
<form method="get" class="row mb-3">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" 
               placeholder="Cari nama / NIP..."value="<?= service('request')->getGet('search') ?>"> 
    </div>
    <div class="col-md-3">
        <select name="department" class="form-select">
            <option value="">-- Semua Departemen --</option>
            <?php foreach ($departments as $dept): ?>
                <option value="<?= $dept['id'] ?>" 
                    <?= service('request')->getGet('department') == $dept['id'] ? 'selected' : '' ?>>
                    <?= $dept['department_name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-secondary">Filter</button>
        <a href="/employees" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

<table class="table table-bordered table-hover">
    <thead class="table-primary">
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Departemen</th>
            <th>Jabatan</th>
            <th>Gaji</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($employees as $i => $emp): ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td>
                <?php if ($emp['photo']): ?>
                    <img src="/uploads/employees/<?= $emp['photo'] ?>" 
                         width="50" height="50" style="object-fit:cover; border-radius:50%">
                <?php else: ?>
                    <i class="bi bi-person-circle fs-3"></i>
                <?php endif; ?>
            </td>
            <td><?= $emp['nip'] ?></td>
            <td><?= $emp['name'] ?></td>
            <td><?= $emp['department_name'] ?></td>
            <td><?= $emp['position_name'] ?></td>
            <td>Rp <?= number_format($emp['salary'], 0, ',', '.') ?></td>
            <td>
                <a href="/employees/show/<?= $emp['id'] ?>" class="btn btn-info btn-sm">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="/employees/edit/<?= $emp['id'] ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i>
                </a>
                <a href="/employees/delete/<?= $emp['id'] ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin hapus?')">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>