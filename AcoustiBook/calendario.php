<?php
$currentPage = 'calendario';
?>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AcoustiBook – Catalogo</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS Custom -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row g-4">

        <!-- COLONNA SINISTRA -->
        <div class="col-12 col-lg-4">

            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h5 class="section-title mb-0">Prenotazioni</h5>
                    <button class="btn btn-success px-3 py-2" data-bs-toggle="modal" data-bs-target="#dayBookingsModal">
                        <i class="bi bi-plus-circle me-1"></i>Aggiungi prenotazione
                    </button>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="section-title mb-3">Calendario</h5>
                    <div class="calendar-placeholder">
                        Calendario interattivo
                    </div>
                </div>
            </div>
        </div>

        <!-- COLONNA DESTRA -->
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="section-title mb-3">Calendario</h5>
                    <div class="calendar-placeholder" id="calendarWidget">
                        Calendario interattivo (da collegare)
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- MODAL PRENOTAZIONI GIORNO -->
<div class="modal fade" id="dayBookingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Prenotazioni del giorno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="text-muted">Nessuna prenotazione per questo giorno.</p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                <button class="btn btn-primary">Aggiungi prenotazione</button>
            </div>

        </div>
    </div>
</div>
