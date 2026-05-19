<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>AcoustiBook</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">AcoustiBook</a>
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-person-circle fs-4 text-primary"></i>
            <span class="fw-semibold">
                <?php 
                    if ($utente) {
                        echo htmlspecialchars($utente['nome'] . ' ' . $utente['cognome']);
                    } else {
                        echo 'Ospite';
                    }
                ?>
            </span>
        </div>
    </div>
</nav>

<div class="container-fluid p-4">
    <div class="row g-3 mb-4">

        <!-- MENU -->
        <div class="col-12 col-md-4">
            <a href="index.php"
               class="btn w-100 py-3 menu-btn <?= ($currentPage === 'dashboard') ? 'btn-primary' : 'btn-outline-primary' ?>">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>
        </div>

        <div class="col-12 col-md-4">
            <a href="catalogo.php"
               class="btn w-100 py-3 menu-btn <?= ($currentPage === 'catalogo') ? 'btn-primary' : 'btn-outline-primary' ?>">
                <i class="bi bi-journal-text me-2"></i>Catalogo
            </a>
        </div>

        <div class="col-12 col-md-4">
            <a href="calendario.php"
               class="btn w-100 py-3 menu-btn <?= ($currentPage === 'calendario') ? 'btn-primary' : 'btn-outline-primary' ?>">
                <i class="bi bi-calendar-event me-2"></i>Calendario
            </a>
        </div>

    </div>
