<?php
require __DIR__ . '/includes/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    $pageTitle = 'Post not found';
    require __DIR__ . '/includes/header.php';
    echo '<main class="notice"><p>Sorry, that post could not be found. <a href="index.php">Back home</a></p></main>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = $post['title'] . ' — Karibu';
require __DIR__ . '/includes/header.php';
?>
  <article class="single">
    <a class="back" href="index.php">← All posts</a>
    <span class="date"><?= date('F j, Y', strtotime($post['created_at'])) ?></span>
    <h1><?= htmlspecialchars($post['title']) ?></h1>
    <img src="images/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
    <div class="content"><?= nl2br(htmlspecialchars($post['body'])) ?></div>
  </article>
<?php require __DIR__ . '/includes/footer.php'; ?>
