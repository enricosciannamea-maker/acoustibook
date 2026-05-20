<?php
session_start();
require "db.php";

$errore = "";

$messaggi = [
    "email_inviata"  => ["success", "Email inviata! Controlla la casella e clicca il link di conferma."],
    "token_invalido" => ["danger",  "Il link di verifica non è valido o è scaduto. Registrati di nuovo."],
    "errore_db"      => ["danger",  "Errore interno durante la registrazione. Riprova più tardi."],
];

$stato = $_GET["stato"] ?? "";

if (isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = trim($_POST["email"]);
    $username = trim($_POST["username"]);
    $nome     = trim($_POST["nome"]);
    $cognome  = trim($_POST["cognome"]);
    $password = $_POST["password"];
    $conferma = $_POST["conferma"];

    if ($password !== $conferma) {
        $errore = "Le password non coincidono.";
    } else {
        $check = $conn->prepare("SELECT id FROM utenti WHERE email = ? OR username = ?");
        $check->bind_param("ss", $email, $username);
        $check->execute();
        $check->store_result();
        $gia_registrato = $check->num_rows > 0;
        $check->close();

        if ($gia_registrato) {
            $errore = "Email o username già registrati.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $token         = password_hash($password_hash, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("
                INSERT INTO utenti (email, username, password, token, autenticato, nome, cognome)
                VALUES (?, ?, ?, ?, 0, ?, ?)
            ");
            $stmt->bind_param("ssssss", $email, $username, $password_hash, $token, $nome, $cognome);

            if ($stmt->execute()) {
                $stmt->close();

                $link = "https://acoustibook.altervista.org/auth/check.php?token=" . $token;

                $oggetto = "Conferma la registrazione su AcoustiBook";
                $corpo   = "Ciao {$nome} {$cognome},\r\n\r\n";
                $corpo  .= "Hai richiesto la registrazione su AcoustiBook.\r\n\r\n";
                $corpo  .= "Clicca il link qui sotto per confermare il tuo account:\r\n";
                $corpo  .= $link . "\r\n\r\n";
                $corpo  .= "Se non hai richiesto questa registrazione, ignora questa email.";

                if (mail($email, $oggetto, $corpo)) {
                    header("Location: register.php?stato=email_inviata");
                    exit;
                } else {
                    $del = $conn->prepare("DELETE FROM utenti WHERE token = ?");
                    $del->bind_param("s", $token);
                    $del->execute();
                    $del->close();
                    $errore = "Impossibile inviare l'email di conferma. Riprova più tardi.";
                }
            } else {
                $errore = "Errore: " . $stmt->error;
                $stmt->close();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrazione - AcoustiBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/auth.css">
</head>
<body class="auth-body">
<div class="auth-container">
    <div class="card auth-card shadow-lg">
        <div class="card-body p-5">
            <h3 class="text-center mb-4">
                <i class="bi bi-music-note-beamed text-primary"></i> AcoustiBook
            </h3>
            <h5 class="text-center text-muted mb-4">Crea un account</h5>

            <?php if (isset($messaggi[$stato])): ?>
                <div class="alert alert-<?= $messaggi[$stato][0] ?> text-center">
                    <i class="bi bi-<?= $messaggi[$stato][0] === 'success' ? 'envelope-check' : 'exclamation-triangle' ?> me-2"></i>
                    <?= $messaggi[$stato][1] ?>
                </div>
            <?php else: ?>
                <?php if (!empty($errore)): ?>
                    <div class="alert alert-danger text-center">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <?= htmlspecialchars($errore) ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control"
                                   placeholder="Inserisci nome"
                                   value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"
                                   required>
                        </div>
                        <div class="col">
                            <label class="form-label">Cognome</label>
                            <input type="text" name="cognome" class="form-control"
                                   placeholder="Inserisci cognome"
                                   value="<?= htmlspecialchars($_POST['cognome'] ?? '') ?>"
                                   required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control"
                               placeholder="Scegli username"
                               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                               required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               placeholder="Inserisci email"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                               required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Inserisci password" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Conferma Password</label>
                        <input type="password" name="conferma" class="form-control"
                               placeholder="Ripeti la password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-envelope me-2"></i>Invia email di conferma
                        </button>
                    </div>
                </form>

                <hr class="my-4">
                <p class="text-center mb-0">
                    Hai già un account? <a href="login.php" class="auth-link">Accedi</a>
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>