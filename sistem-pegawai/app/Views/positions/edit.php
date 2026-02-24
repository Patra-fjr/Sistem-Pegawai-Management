<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<h2>Edit Jabatan</h2>
<hr>
<div class="card">
    <div class="card-body">
        <form action="/positions/update/<?= $position['id'] ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label>Nama Jabatan</label>
                <input type="text" name="position_name" class="form-control" value="<?= esc($position['position_name']) ?>" required>
            </div>
            <a href="/positions" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
