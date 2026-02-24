<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<h2>Edit Departemen</h2>
<hr>
<div class="card">
    <div class="card-body">
        <form action="/departments/update/<?= $department['id'] ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label>Nama Departemen</label>
                <input type="text" name="department_name" class="form-control" 
                       value="<?= $department['department_name'] ?>" required>
            </div>
            <a href="/departments" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>