<!DOCTYPE html>
<?php
$currentPage = 'catalogo';
?>
<?php
// Placeholder dati (DB)
$strumenti = [
    ["nome" => "Fonometro Classe 1", "tipo" => "Misura", "note" => "IEC 61672, certificato"],
    ["nome" => "Calibratore Acustico", "tipo" => "Taratura", "note" => "94/114 dB"],
    ["nome" => "Vibrometro", "tipo" => "Vibrazioni", "note" => "Analisi strutturale"],
];
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
    <!-- FILTRI + AZIONE -->
    <div class="row align-items-end g-3 mb-4">
        <div class="col-12 col-lg-5">
            <label class="form-label fw-semibold">Cerca strumento</label>
            <input type="text" class="form-control" placeholder="Nome, modello, parola chiave">
        </div>
        <div class="col-12 col-lg-4">
            <label class="form-label fw-semibold">Filtro tipologia</label>
            <select class="form-select">
                <option>Tutti</option>
                <option>Misura</option>
                <option>Taratura</option>
                <option>Vibrazioni</option>
            </select>
        </div>
<div class="col-12 col-lg-3 text-lg-end">
    <button class="btn btn-success px-3 py-2"
            data-bs-toggle="modal"
            data-bs-target="#addInstrumentModal">
        <i class="bi bi-plus-circle me-1"></i>Aggiungi strumento
    </button>
</div>

    <!-- CATALOGO STRUMENTI -->
    <div class="row g-4">
        <?php foreach ($strumenti as $s) : ?>
            <div class="col-12 col-md-6 col-xl-4">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h5 class="card-title text-primary fw-semibold"><?php echo $s['nome']; ?></h5>
                        <p class="mb-1"><strong>Tipologia:</strong> <?php echo $s['tipo']; ?></p>
                        <p class="mb-0 text-muted"><?php echo $s['note']; ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<div class="modal fade" id="addInstrumentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <!-- HEADER MODAL -->
            <div class="modal-header">
                <h5 class="modal-title">Aggiungi strumento</h5>

                <!-- Bottone NFC (placeholder) -->
                <button type="button"
                        class="btn btn-outline-primary btn-sm me-2"
                        title="Aggiungi tramite NFC">
                    <i class="bi bi-nfc"></i> NFC
                </button>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY MODAL -->
            <div class="modal-body">
                <form>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nome strumento</label>
                        <input type="text" class="form-control"
                               placeholder="Es. Fonometro Classe 1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tipologia</label>
                        <select class="form-select">
                            <option>Misura</option>
                            <option>Taratura</option>
                            <option>Vibrazioni</option>
                            <option>Altro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Caratteristiche</label>
                        <textarea class="form-control" rows="4"
                                  placeholder="Classe, normativa, accessori, note tecniche..."></textarea>
                    </div>

                </form>
            </div>

            <!-- FOOTER MODAL -->
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Annulla
                </button>
                <button class="btn btn-primary">
                    Salva strumento
                </button>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>