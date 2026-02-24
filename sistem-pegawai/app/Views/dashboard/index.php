<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Selamat datang, <?= session()->get('name') ?>!</h2>
    <p>Role: <?= session()->get('role') ?></p>
    <a href="/logout" class="btn btn-danger">Logout</a>
</div>
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<h2>Dashboard</h2>
<hr>
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5>Selamat datang, <strong><?= session()->get('name') ?></strong>!</h5>
                <p>Role: <span class="badge bg-primary"><?= session()->get('role') ?></span></p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
</body>
</html>