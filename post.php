<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/functions.php';

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

$commentErrors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cName = trim($_POST['name'] ?? '');
    $cBody = trim($_POST['comment'] ?? '');
    if ($cName === '') $commentErrors[] = 'Please enter your name.';
    if ($cBody === '') $commentErrors[] = 'Please write a comment.';
    if (!$commentErrors) {
        $pdo->prepare('INSERT INTO comments (post_id, name, body) VALUES (?, ?, ?)')->execute([$id, $cName, $cBody]);
        header('Location: post.php?id=' . $id . '#comments');
        exit;
    }
}

$comments = $pdo->prepare('SELECT * FROM comments WHERE post_id = ? ORDER BY created_at ASC');
$comments->execute([$id]);
$comments = $comments->fetchAll();

$pageTitle = $post['title'] . ' — Karibu';
require __DIR__ . '/includes/header.php';
?>
  <article class="single">
    <a class="back" href="index.php">← All posts</a>
    <span class="date"><?= date('F j, Y', strtotime($post['created_at'])) ?> · <?= reading_time($post['body']) ?></span>
    <h1><?= htmlspecialchars($post['title']) ?></h1>
    <img src="images/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
    <div class="content"><?= render_paragraphs($post['body']) ?></div>

    <section class="comments" id="comments">
      <h2><?= count($comments) ?> Comment<?= count($comments) === 1 ? '' : 's' ?></h2>

      <?php foreach ($comments as $c): ?>
        <div class="comment">
          <div class="comment-avatar"><?= strtoupper(substr($c['name'], 0, 1)) ?></div>
          <div class="comment-body">
            <p class="comment-meta"><strong><?= htmlspecialchars($c['name']) ?></strong> · <?= date('M j, Y', strtotime($c['created_at'])) ?></p>
            <p><?= nl2br(htmlspecialchars($c['body'])) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
      <?php if (!$comments): ?><p class="no-comments">Be the first to comment.</p><?php endif; ?>

      <h3 class="leave-title">Leave a Comment</h3>
      <?php if ($commentErrors): ?><div class="errors"><?php foreach ($commentErrors as $e) echo '<p>' . htmlspecialchars($e) . '</p>'; ?></div><?php endif; ?>
      <form class="comment-form" method="post" action="post.php?id=<?= $id ?>#comments">
        <input type="text" name="name" placeholder="Your name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
        <textarea name="comment" rows="4" placeholder="Your comment" required><?= htmlspecialchars($_POST['comment'] ?? '') ?></textarea>
        <button type="submit" class="btn-teal">Post Comment</button>
      </form>
    </section>
  </article>
<?php require __DIR__ . '/includes/footer.php'; ?>
