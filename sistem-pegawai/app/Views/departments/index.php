<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Data Departemen</h2>
    <a href="/departments/create" class="btn btn-primary">
        <i class="bi bi-plus"></i> Tambah
    </a>
</div>

<table class="table table-bordered table-hover">
    <thead class="table-primary">
        <tr>
            <th>No</th>
            <th>Nama Departemen</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($departments as $i => $dept): ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= $dept['department_name'] ?></td>
            <td>
                <a href="/departments/edit/<?= $dept['id'] ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="/departments/delete/<?= $dept['id'] ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin hapus?')">
                    <i class="bi bi-trash"></i> Hapus
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>