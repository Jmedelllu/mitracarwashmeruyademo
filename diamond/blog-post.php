<?php

declare(strict_types=1);

require __DIR__ . '/lib/bootstrap.php';

$site = $config['site'];
$slug = (string)($_GET['slug'] ?? '');

$posts = require __DIR__ . '/data/posts.php';
if (!is_array($posts)) {
    $posts = [];
}

$post = null;
foreach ($posts as $p) {
    if ((string)($p['slug'] ?? '') === $slug) {
        $post = $p;
        break;
    }
}

if (!$post) {
    http_response_code(404);
    $title = 'Tidak ditemukan';
    ob_start();
    ?>
    <section class="section">
      <div class="container--wide">
        <h1 class="section__title">Artikel tidak ditemukan</h1>
        <p class="section__lead"><a class="btn" href="/Bisinis/diamond/blog.php">Kembali ke blog</a></p>
      </div>
    </section>
    <?php
    $content = ob_get_clean();
    require __DIR__ . '/partials/layout.php';
    exit;
}

$title = (string)$post['title'];
$date = (string)($post['date'] ?? '');

ob_start();
?>
<section class="section section--tight">
  <div class="container--wide">
    <div class="section__kicker">Blog</div>
    <h1 class="section__title"><?= h($title) ?></h1>
    <p class="section__lead"><?= h($date) ?></p>
  </div>
</section>

<section class="section">
  <div class="container--wide">
    <div class="panel card--big">
      <div class="panel__body">
        <p class="panel__muted" style="white-space:pre-wrap"><?= h((string)($post['body'] ?? '')) ?></p>
        <div class="divider"></div>
        <a class="btn" href="/Bisinis/diamond/blog.php">Kembali</a>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/partials/layout.php';
