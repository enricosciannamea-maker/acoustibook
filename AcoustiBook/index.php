<!DOCTYPE html>
<?php
$currentPage = 'dashboard';
?>
<?php
// Placeholder PHP: collegare DB, sessioni utente, ecc.
$prenotazioniBreve = 5;
?>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AcoustiBook – Dashboard</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

        <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>

    <!-- SEZIONI KPI + NOTE -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-4">
            <div class="card card-gradient-blue shadow h-100">
                <div class="card-body">
                    <h5 class="section-title">Prenotazioni a breve</h5>
                    <p class="display-4 fw-bold mb-0"><?php echo $prenotazioniBreve; ?></p>
                    <small>Prossimi 7 giorni</small>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card card-gradient-green shadow h-100">
                <div class="card-body">
                    <h5 class="section-title">Stato attività</h5>
                    <p class="fs-4 fw-semibold mb-1">Operativo</p>
                    <small>Tutti i sistemi attivi</small>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card card-gradient-purple shadow h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="section-title">Note</h5>

                    <textarea id="notesText"
                              class="form-control mb-2 flex-grow-1"
                              placeholder="Scrivi qui le note rapide..."></textarea>

                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-light" onclick="saveNotes()">Salva</button>
                        <button class="btn btn-sm btn-light" onclick="clearNotes()">Pulisci</button>
                    </div>
                </div>
            </div>
        </div>


    <!-- CALENDARIO + AVVISI -->
    <div class="row g-3">
        <div class="col-12 col-lg-8">
            <div class="card shadow h-100">
                <div class="card-body">
                    <h5 class="section-title">Calendario</h5>
                    <div class="calendar-placeholder">
                        Widget calendario (da collegare)
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <h5 class="section-title">Avvisi</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Taratura fonometro in scadenza</li>
                        <li class="list-group-item">Nuova normativa acustica</li>
                        <li class="list-group-item">Riunione tecnica domani</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="notesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Note rapide</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <canvas id="noteCanvas"
                        width="700"
                        height="350"
                        class="border rounded w-100 bg-white">
                </canvas>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="clearCanvas()">Pulisci</button>
                <button class="btn btn-primary" onclick="saveCanvas()">Salva</button>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/notes.js"></script>
</body>
</html>
