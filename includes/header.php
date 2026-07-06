<?php $pageTitle = $pageTitle ?? 'Karibu'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="site-header">
    <a href="index.php" class="brand">Karibu<span>.</span></a>
    <nav>
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="contact.php">Contact</a>
    </nav>
  </header>
