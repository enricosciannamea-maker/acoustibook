<?php
session_start();
require "db.php";

if(isset($_SESSION["user_id"])){
  header("Location: ../index.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, password FROM utenti WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $password_hash);
        $stmt->fetch();

        if (password_verify($password, $password_hash)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $username;
            header("Location: ../index.php");
            exit;
        } else {
            $errore = "Password errata.";
        }
    } else {
        $errore = "Utente non trovato.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>

<meta charset="UTF-8">
<title>Login - AcoustiBook</title>

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
<i class="bi"></i>
AcoustiBook
</h3>

<h5 class="text-center text-muted mb-4">
Accedi al sistema
</h5>

<?php if (!empty($errore)): ?>
<div class="alert alert-danger text-center">
<?= $errore ?>
</div>
<?php endif; ?>

<form method="POST">

<div class="mb-3">
<label class="form-label">Username</label>
<input type="text" name="username" class="form-control" placeholder="Inserisci username" required>
</div>

<div class="mb-4">
<label class="form-label">Password</label>
<input type="password" name="password" class="form-control" placeholder="Inserisci password" required>
</div>

<div class="d-grid">
<button type="submit" class="btn btn-primary btn-lg">
<i class="bi bi-box-arrow-in-right me-2"></i>Accedi
</button>
</div>

</form>

<hr class="my-4">

<p class="text-center mb-0">
Non hai un account?
<a href="register.php" class="auth-link">Registrati</a>
</p>

</div>
</div>
</div>

</body>
</html>