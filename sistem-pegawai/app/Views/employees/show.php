<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<h2>Detail Pegawai</h2>
<hr>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 text-center">
                <?php if ($employee['photo']): ?>
                    <img src="/uploads/employees/<?= $employee['photo'] ?>" 
                         class="img-fluid rounded" style="max-height:200px; object-fit:cover">
                <?php else: ?>
                    <i class="bi bi-person-circle" style="font-size:100px"></i>
                <?php endif; ?>
            </div>
            <div class="col-md-9">
                <table class="table table-borderless">
                    <tr><th>Nama</th><td>: <?= $employee['name'] ?></td></tr>
                    <tr><th>NIP</th><td>: <?= $employee['nip'] ?></td></tr>
                    <tr><th>Email</th><td>: <?= $employee['email'] ?></td></tr>
                    <tr><th>Departemen</th><td>: <?= $employee['department_name'] ?></td></tr>
                    <tr><th>Jabatan</th><td>: <?= $employee['position_name'] ?></td></tr>
                    <tr><th>Jenis Kelamin</th><td>: <?= $employee['gender'] ?></td></tr>
                    <tr><th>No. HP</th><td>: <?= $employee['phone'] ?></td></tr>
                    <tr><th>Alamat</th><td>: <?= $employee['address'] ?></td></tr>
                    <tr><th>Gaji</th><td>: Rp <?= number_format($employee['salary'], 0, ',', '.') ?></td></tr>
                </table>
            </div>
        </div>
        <a href="/employees" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>

<?= $this->endSection() ?>