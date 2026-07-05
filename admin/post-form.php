<?php
require __DIR__ . '/auth.php';
require __DIR__ . '/../includes/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$post = ['title' => '', 'excerpt' => '', 'body' => '', 'image' => ''];
$errors = [];

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
    $stmt->execute([$id]);
    $found = $stmt->fetch();
    if (!$found) { header('Location: index.php'); exit; }
    $post = $found;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postTitle = trim($_POST['title'] ?? '');
    $excerpt   = trim($_POST['excerpt'] ?? '');
    $body      = trim($_POST['body'] ?? '');
    $image     = $post['image'] ?? '';

    if ($postTitle === '') $errors[] = 'Title is required.';
    if ($excerpt === '')   $errors[] = 'Excerpt is required.';
    if ($body === '')      $errors[] = 'Body is required.';

    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($ext, $allowed, true)) {
            $errors[] = 'Image must be a JPG, PNG or WEBP file.';
        } elseif ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $newName = 'post_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../images/' . $newName)) {
                $image = $newName;
            } else {
                $errors[] = 'Could not save the uploaded image.';
            }
        }
    }

    if (!$id && $image === '') {
        $errors[] = 'Please choose an image for the post.';
    }

    if (!$errors) {
        $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $postTitle), '-'));
        if ($id) {
            $stmt = $pdo->prepare('UPDATE posts SET title = ?, slug = ?, excerpt = ?, body = ?, image = ? WHERE id = ?');
            $stmt->execute([$postTitle, $slug, $excerpt, $body, $image, $id]);
        } else {
            $stmt = $pdo->prepare('INSERT INTO posts (title, slug, excerpt, body, image) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$postTitle, $slug, $excerpt, $body, $image]);
        }
        header('Location: index.php');
        exit;
    }

    $post = ['title' => $postTitle, 'excerpt' => $excerpt, 'body' => $body, 'image' => $image];
}

$heading = $id ? 'Edit Post' : 'New Post';
$title = $heading . ' — Karibu Admin';
require __DIR__ . '/_header.php';
?>
<div class="admin-head">
  <h1><?= $heading ?></h1>
  <a href="index.php">← Back to posts</a>
</div>

<?php if ($errors): ?>
  <div class="errors"><?php foreach ($errors as $e): ?><p><?= htmlspecialchars($e) ?></p><?php endforeach; ?></div>
<?php endif; ?>

<form class="post-form" method="post" enctype="multipart/form-data">
  <label>Title
    <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
  </label>
  <label>Excerpt (short summary shown on the homepage)
    <input type="text" name="excerpt" value="<?= htmlspecialchars($post['excerpt']) ?>" required>
  </label>
  <label>Body
    <textarea name="body" rows="10" required><?= htmlspecialchars($post['body']) ?></textarea>
  </label>
  <label>Image<?= $id ? ' (leave empty to keep the current one)' : '' ?>
    <input type="file" name="image" accept="image/*">
  </label>
  <?php if (!empty($post['image'])): ?>
    <p class="current-img">Current image: <?= htmlspecialchars($post['image']) ?></p>
  <?php endif; ?>
  <button type="submit" class="btn"><?= $id ? 'Update Post' : 'Publish Post' ?></button>
</form>
<?php require __DIR__ . '/_footer.php'; ?>
