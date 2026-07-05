<?php $title = $title ?? 'Karibu Admin'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title) ?></title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <header class="admin-bar">
    <a class="brand" href="index.php">Karibu Admin</a>
    <div class="admin-bar-right">
      <span><?= htmlspecialchars($_SESSION['admin'] ?? '') ?></span>
      <a href="../index.php" target="_blank">View site</a>
      <a href="logout.php">Log out</a>
    </div>
  </header>
  <main class="admin-main">
