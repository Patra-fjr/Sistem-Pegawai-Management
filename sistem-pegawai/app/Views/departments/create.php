<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<h2>Tambah Departemen</h2>
<hr>
<div class="card">
    <div class="card-body">
        <form action="/departments/store" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label>Nama Departemen</label>
                <input type="text" name="department_name" class="form-control" required>
            </div>
            <a href="/departments" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>