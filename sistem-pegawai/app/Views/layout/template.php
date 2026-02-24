<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Sistem Pegawai' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/dashboard">
            <i class="bi bi-people-fill"></i> Sistem Pegawai
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="/profile">
                        <i class="bi bi-person-circle"></i> 
                        <?= session()->get('name') ?> 
                        (<?= session()->get('role') ?>)
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/logout">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <nav class="col-md-2 bg-light sidebar py-3 min-vh-100">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="/dashboard">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>

                <?php if (session()->get('role') === 'admin'): ?>
                <li class="nav-item mt-2">
                    <small class="text-muted px-3">MASTER DATA</small>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="/departments">
                        <i class="bi bi-building"></i> Departemen
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="/positions">
                        <i class="bi bi-briefcase"></i> Jabatan
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <small class="text-muted px-3">DATA</small>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="/employees">
                        <i class="bi bi-person-badge"></i> Pegawai
                    </a>
                </li>
                <?php endif; ?>

                <?php if (session()->get('role') === 'pegawai'): ?>
                <li class="nav-item mt-2">
                    <small class="text-muted px-3">DATA SAYA</small>
                </li>
                <?php endif; ?>

                <li class="nav-item mt-2 border-top pt-2">
                    <a class="nav-link text-dark" href="/profile">
                        <i class="bi bi-person-gear"></i> Profil Saya
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 p-4">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>