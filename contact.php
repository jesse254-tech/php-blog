<?php
require __DIR__ . '/includes/db.php';

$sent = false;
$errors = [];
$name = $email = $message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '') {
        $errors[] = 'Please enter your name.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if ($message === '') {
        $errors[] = 'Please enter a message.';
    }

    if (!$errors) {
        $stmt = $pdo->prepare('INSERT INTO messages (name, email, message) VALUES (?, ?, ?)');
        $stmt->execute([$name, $email, $message]);
        $sent = true;
        $name = $email = $message = '';
    }
}

$pageTitle = 'Contact — Karibu';
require __DIR__ . '/includes/header.php';
?>
  <article class="page">
    <h1>Get in Touch</h1>

    <?php if ($sent): ?>
      <p class="success">Thank you! Your message has been received.</p>
    <?php endif; ?>

    <?php if ($errors): ?>
      <div class="errors"><?php foreach ($errors as $e): ?><p><?= htmlspecialchars($e) ?></p><?php endforeach; ?></div>
    <?php endif; ?>

    <form class="contact-form" method="post" action="contact.php">
      <label>Name
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required>
      </label>
      <label>Email
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
      </label>
      <label>Message
        <textarea name="message" rows="6" required><?= htmlspecialchars($message) ?></textarea>
      </label>
      <button type="submit" class="btn-teal">Send Message</button>
    </form>
  </article>
<?php require __DIR__ . '/includes/footer.php'; ?>
