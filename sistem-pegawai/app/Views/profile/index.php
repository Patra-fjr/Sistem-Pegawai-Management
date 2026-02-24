<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3><i class="bi bi-person-circle"></i> Profil Saya</h3>
    <a href="/profile/edit" class="btn btn-primary">
        <i class="bi bi-pencil"></i> Edit Profil
    </a>
</div>
<hr>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row align-items-center">

                    <!-- Foto -->
                    <div class="col-md-3 text-center mb-3 mb-md-0">
                        <?php if (!empty($employee['photo'])): ?>
                            <img src="/uploads/employees/<?= esc($employee['photo']) ?>"
                                 class="rounded-circle img-fluid"
                                 style="width:130px; height:130px; object-fit:cover;"
                                 alt="Foto Profil">
                        <?php else: ?>
                            <i class="bi bi-person-circle text-secondary" style="font-size:110px;"></i>
                        <?php endif; ?>
                    </div>

                    <!-- Info -->
                    <div class="col-md-9">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th width="150">Nama</th>
                                <td>: <?= esc($user['name']) ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>: <?= esc($user['email']) ?></td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>: <?= esc($user['role']) ?></td>
                            </tr>
                            <?php if (!empty($employee['department_name'])): ?>
                            <tr>
                                <th>Departemen</th>
                                <td>: <?= esc($employee['department_name']) ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if (!empty($employee['position_name'])): ?>
                            <tr>
                                <th>Jabatan</th>
                                <td>: <?= esc($employee['position_name']) ?></td>
                            </tr>
                            <?php endif; ?>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
