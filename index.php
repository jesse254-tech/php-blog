<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/functions.php';

$q = trim($_GET['q'] ?? '');
$perPage = 4;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;

if ($q !== '') {
    $like = '%' . $q . '%';
    $countStmt = $pdo->prepare('SELECT COUNT(*) FROM posts WHERE title LIKE ? OR excerpt LIKE ? OR body LIKE ?');
    $countStmt->execute([$like, $like, $like]);
    $total = (int) $countStmt->fetchColumn();

    $stmt = $pdo->prepare('SELECT * FROM posts WHERE title LIKE ? OR excerpt LIKE ? OR body LIKE ? ORDER BY created_at DESC LIMIT ? OFFSET ?');
    $stmt->bindValue(1, $like);
    $stmt->bindValue(2, $like);
    $stmt->bindValue(3, $like);
    $stmt->bindValue(4, $perPage, PDO::PARAM_INT);
    $stmt->bindValue(5, $offset, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll();
} else {
    $total = (int) $pdo->query('SELECT COUNT(*) FROM posts')->fetchColumn();
    $stmt = $pdo->prepare('SELECT * FROM posts ORDER BY created_at DESC LIMIT ? OFFSET ?');
    $stmt->bindValue(1, $perPage, PDO::PARAM_INT);
    $stmt->bindValue(2, $offset, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll();
}

$totalPages = max(1, (int) ceil($total / $perPage));

$pageTitle = 'Karibu — Travel & Lifestyle';
require __DIR__ . '/includes/header.php';
?>
  <section class="hero">
    <div class="hero-inner">
      <h1>Karibu</h1>
      <p>Travel stories, hidden gems, and everyday adventures across Kenya.</p>
      <form class="search" method="get" action="index.php">
        <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Search posts...">
        <button type="submit">Search</button>
      </form>
    </div>
  </section>

  <main class="posts-wrap">
    <?php if ($q !== ''): ?>
      <p class="results-info"><?= $total ?> result<?= $total === 1 ? '' : 's' ?> for &ldquo;<?= htmlspecialchars($q) ?>&rdquo; · <a href="index.php">Clear</a></p>
    <?php endif; ?>

    <?php if (!$posts): ?>
      <p class="results-info">No posts found.</p>
    <?php endif; ?>

    <div class="posts">
      <?php foreach ($posts as $post): ?>
        <article class="post-card">
          <a href="post.php?id=<?= (int) $post['id'] ?>">
            <img src="images/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
          </a>
          <div class="post-card-body">
            <span class="date"><?= date('F j, Y', strtotime($post['created_at'])) ?> · <?= reading_time($post['body']) ?></span>
            <h2><a href="post.php?id=<?= (int) $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a></h2>
            <p><?= htmlspecialchars($post['excerpt']) ?></p>
            <a class="read-more" href="post.php?id=<?= (int) $post['id'] ?>">Read more →</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <?php if ($totalPages > 1): ?>
      <nav class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <?php $qs = 'page=' . $i . ($q !== '' ? '&q=' . urlencode($q) : ''); ?>
          <a href="index.php?<?= $qs ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
      </nav>
    <?php endif; ?>
  </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
