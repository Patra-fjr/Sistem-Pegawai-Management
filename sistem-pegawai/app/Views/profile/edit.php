<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3><i class="bi bi-pencil-square"></i> Edit Profil</h3>
    <a href="/profile" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>
<hr>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="/profile/update" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <!-- Foto -->
                    <div class="mb-3 text-center">
                        <?php if (!empty($employee['photo'])): ?>
                            <img id="photoPreview"
                                 src="/uploads/employees/<?= esc($employee['photo']) ?>"
                                 class="rounded-circle mb-2"
                                 style="width:120px; height:120px; object-fit:cover;">
                        <?php else: ?>
                            <img id="photoPreview"
                                 src="https://via.placeholder.com/120/dee2e6/6c757d?text=No+Photo"
                                 class="rounded-circle mb-2"
                                 style="width:120px; height:120px; object-fit:cover;">
                        <?php endif; ?>
                        <div>
                            <label class="form-label fw-semibold d-block">Foto Profil</label>
                            <input type="file" name="photo" id="photoInput"
                                   class="form-control" accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah foto. Maks 2MB.</small>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama</label>
                        <input type="text" name="name" class="form-control"
                               value="<?= esc($user['name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="<?= esc($user['email']) ?>" required>
                    </div>

                    <hr>
                    <p class="text-muted small">Kosongkan jika tidak ingin mengganti password.</p>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Baru</label>
                        <input type="password" name="new_password" class="form-control"
                               placeholder="Isi jika ingin ganti password">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Konfirmasi Password</label>
                        <input type="password" name="confirm_password" class="form-control"
                               placeholder="Ulangi password baru">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </form>

                <script>
                    document.getElementById('photoInput').addEventListener('change', function() {
                        const file = this.files[0];
                        if (file) {
                            document.getElementById('photoPreview').src = URL.createObjectURL(file);
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
