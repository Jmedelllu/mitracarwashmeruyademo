<?php

declare(strict_types=1);

require __DIR__ . '/lib/bootstrap.php';

$site = $config['site'];
$title = 'Blog';

$posts = require __DIR__ . '/data/posts.php';
if (!is_array($posts)) {
    $posts = [];
}

ob_start();
?>
<section class="section section--tight">
  <div class="container--wide">
    <div class="section__kicker">Blog</div>
    <h1 class="section__title">Artikel otomotif</h1>
    <p class="section__lead">Contoh blog untuk paket Diamond (SEO basic + konten edukasi pelanggan).</p>
  </div>
</section>

<section class="section">
  <div class="container--wide">
    <div class="grid">
      <?php foreach ($posts as $p): ?>
        <?php
          $slug = (string)($p['slug'] ?? '');
          $ptitle = (string)($p['title'] ?? '');
          $excerpt = (string)($p['excerpt'] ?? '');
          $date = (string)($p['date'] ?? '');
        ?>
        <div class="card card--big col-6 reveal" data-reveal>
          <div class="card__kicker"><?= h($date) ?></div>
          <div class="card__title"><?= h($ptitle) ?></div>
          <p class="card__text"><?= h($excerpt) ?></p>
          <div style="margin-top:14px">
            <a class="btn btn--primary" href="/Bisinis/diamond/blog-post.php?slug=<?= h(rawurlencode($slug)) ?>">Baca</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/partials/layout.php';
