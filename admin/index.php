<?php
require __DIR__ . '/auth.php';
require __DIR__ . '/../includes/db.php';

$posts = $pdo->query('SELECT id, title, created_at FROM posts ORDER BY created_at DESC')->fetchAll();

$title = 'Dashboard — Karibu Admin';
require __DIR__ . '/_header.php';
?>
<div class="admin-head">
  <h1>Posts</h1>
  <a class="btn" href="post-form.php">+ New Post</a>
</div>

<table class="admin-table">
  <thead>
    <tr><th>Title</th><th>Date</th><th>Actions</th></tr>
  </thead>
  <tbody>
    <?php foreach ($posts as $p): ?>
      <tr>
        <td><?= htmlspecialchars($p['title']) ?></td>
        <td><?= date('M j, Y', strtotime($p['created_at'])) ?></td>
        <td class="actions">
          <a href="post-form.php?id=<?= (int) $p['id'] ?>">Edit</a>
          <form action="delete.php" method="post" onsubmit="return confirm('Delete this post?');">
            <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
            <button type="submit" class="link-danger">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$posts): ?>
      <tr><td colspan="3">No posts yet. Create your first one.</td></tr>
    <?php endif; ?>
  </tbody>
</table>
<?php require __DIR__ . '/_footer.php'; ?>
