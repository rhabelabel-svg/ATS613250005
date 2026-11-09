<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require __DIR__ . "/koneksi.php";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT id, email, nama, password FROM member_005 WHERE email=? AND aktive='1'"
    );
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $hasil = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($hasil);

    if ($data) {
        $passwordTersimpan = (string)$data['password'];
        $cocok = hash_equals($passwordTersimpan, $password)
            || hash_equals(strtolower($passwordTersimpan), md5($password));

        if ($cocok) {
            session_regenerate_id(true);
            $_SESSION['id'] = $data['id'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['nama'] = $data['nama'];
            header("Location: dashboard.php");
            exit;
        }
    }

    $error = "Email atau password salah / akun tidak aktif";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Rental Kendaraan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh">
  <div class="container" style="max-width:440px">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-4 p-md-5">
        <div class="text-center mb-4">
          <div class="text-primary mb-2"><i class="bi bi-car-front-fill display-5"></i></div>
          <h1 class="h3 mb-1">Rental Kendaraan</h1>
          <p class="text-secondary mb-0">Masuk untuk mengelola data kendaraan</p>
        </div>
        <?php if ($error): ?>
          <div class="alert alert-danger py-2" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
        <form method="post">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control"
                   autocomplete="username" value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
          </div>
          <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control"
                   autocomplete="current-password" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-box-arrow-in-right me-1"></i>Login
          </button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
