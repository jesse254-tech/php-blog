<?php
session_start();
require __DIR__ . '/../includes/db.php';

if (!empty($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = ?');
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin'] = $admin['username'];
        header('Location: index.php');
        exit;
    }
    $error = 'Invalid username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — Karibu</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body class="login-page">
  <form class="login-box" method="post">
    <h1>Karibu Admin</h1>
    <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <label>Username
      <input type="text" name="username" required autofocus>
    </label>
    <label>Password
      <input type="password" name="password" required>
    </label>
    <button type="submit" class="btn">Log in</button>
  </form>
</body>
</html>
