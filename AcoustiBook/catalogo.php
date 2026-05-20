<?php
$currentPage = 'catalogo';
require_once 'auth/db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'aggiungi') {
    $nome = trim($_POST['nome'] ?? '');
    $descrizione = trim($_POST['descrizione'] ?? '');

    if ($nome !== '') {
        $stmt = $conn->prepare("INSERT INTO strumento (nome, descrizione) VALUES (?, ?)");
        if ($stmt === false) {
            die("Errore prepare: " . $conn->error);
        }
        $stmt->bind_param("ss", $nome, $descrizione);
        if (!$stmt->execute()) {
            die("Errore execute: " . $stmt->error);
        }
        $stmt->close();
    }

    header("Location: catalogo.php");
    exit;
}

$cerca = trim($_GET['cerca'] ?? '');
$strumenti = [];

if ($cerca !== '') {
    $stmt = $conn->prepare("SELECT * FROM strumento WHERE nome LIKE ? ORDER BY nome ASC");
    $like = '%' . $cerca . '%';
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM strumento ORDER BY nome ASC");
}

while ($row = $result->fetch_assoc()) {
    $strumenti[] = $row;
}


?>
<!DOCTYPE html>
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
    <form method="GET" action="catalogo.php">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-12 col-lg-5">
                <label class="form-label fw-semibold">Cerca strumento</label>
                <input type="text" name="cerca" value="<?php echo htmlspecialchars($cerca); ?>" class="form-control" placeholder="Nome, modello, parola chiave">
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
                <button type="submit" class="btn btn-primary px-3 py-2">
                    <i class="bi bi-search me-1"></i>Cerca
                </button>
                <a href="catalogo.php" class="btn btn-secondary px-3 py-2 ms-1">Reset</a>
                <button type="button" class="btn btn-success px-3 py-2 ms-1"
                        data-bs-toggle="modal"
                        data-bs-target="#addInstrumentModal">
                    <i class="bi bi-plus-circle me-1"></i>Aggiungi
                </button>
            </div>
        </div>
    </form>

    <!-- CATALOGO STRUMENTI -->
    <div class="row g-4">
        <?php foreach ($strumenti as $s) : ?>
            <div class="col-12 col-md-6 col-xl-4">
                <div class="card shadow h-100"
                     style="cursor:pointer"
                     data-bs-toggle="modal"
                     data-bs-target="#dettagliModal"
                     data-id="<?php echo $s['id']; ?>"
                     data-nome="<?php echo htmlspecialchars($s['nome']); ?>"
                     data-descrizione="<?php echo htmlspecialchars($s['descrizione']); ?>">
                    <div class="card-body">
                        <h5 class="card-title text-primary fw-semibold"><?php echo htmlspecialchars($s['nome']); ?></h5>
                        <p class="mb-0 text-muted"><?php echo htmlspecialchars($s['descrizione']); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($strumenti)) : ?>
            <div class="col-12">
                <p class="text-muted">Nessuno strumento trovato.</p>
            </div>
        <?php endif; ?>
    </div>

</div>

<!-- MODAL DETTAGLI STRUMENTO -->
<div class="modal fade" id="dettagliModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle me-2"></i>Dettagli strumento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th class="text-muted bg-light" style="width:35%">ID</th>
                        <td id="dettaglio-id"></td>
                    </tr>
                    <tr>
                        <th class="text-muted bg-light">Nome</th>
                        <td id="dettaglio-nome"></td>
                    </tr>
                    <tr>
                        <th class="text-muted bg-light">Descrizione</th>
                        <td id="dettaglio-descrizione"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL AGGIUNGI STRUMENTO -->
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
                <form id="formAggiungi" method="POST" action="catalogo.php">
                    <input type="hidden" name="action" value="aggiungi">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nome strumento</label>
                        <input type="text" name="nome" class="form-control"
                               placeholder="Es. Fonometro Classe 1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tipologia</label>
                        <select name="tipo" class="form-select">
                            <option>Misura</option>
                            <option>Taratura</option>
                            <option>Vibrazioni</option>
                            <option>Altro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Caratteristiche</label>
                        <textarea name="descrizione" class="form-control" rows="4"
                                  placeholder="Classe, normativa, accessori, note tecniche..."></textarea>
                    </div>
                </form>
            </div>

            <!-- FOOTER MODAL -->
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Annulla
                </button>
                <button type="submit" form="formAggiungi" class="btn btn-primary">
                    Salva strumento
                </button>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const dettagliModal = document.getElementById('dettagliModal');
    dettagliModal.addEventListener('show.bs.modal', function(e) {
        const card = e.relatedTarget;
        document.getElementById('dettaglio-id').textContent          = card.getAttribute('data-id');
        document.getElementById('dettaglio-nome').textContent        = card.getAttribute('data-nome');
        document.getElementById('dettaglio-descrizione').textContent = card.getAttribute('data-descrizione');
    });
</script>
</body>
</html>