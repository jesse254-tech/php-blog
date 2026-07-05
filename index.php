<?php
require __DIR__ . '/includes/db.php';

$posts = $pdo->query('SELECT * FROM posts ORDER BY created_at DESC')->fetchAll();

$pageTitle = 'Karibu — Travel & Lifestyle';
require __DIR__ . '/includes/header.php';
?>
  <section class="hero">
    <div class="hero-inner">
      <h1>Karibu</h1>
      <p>Travel stories, hidden gems, and everyday adventures across Kenya.</p>
    </div>
  </section>

  <main class="posts">
    <?php foreach ($posts as $post): ?>
      <article class="post-card">
        <a href="post.php?id=<?= (int) $post['id'] ?>">
          <img src="images/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
        </a>
        <div class="post-card-body">
          <span class="date"><?= date('F j, Y', strtotime($post['created_at'])) ?></span>
          <h2><a href="post.php?id=<?= (int) $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a></h2>
          <p><?= htmlspecialchars($post['excerpt']) ?></p>
          <a class="read-more" href="post.php?id=<?= (int) $post['id'] ?>">Read more →</a>
        </div>
      </article>
    <?php endforeach; ?>
  </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
