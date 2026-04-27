<?php

declare(strict_types=1);

require __DIR__ . '/lib/bootstrap.php';

$site = $config['site'];
$title = 'About Us';

ob_start();
?>
<section class="section surface">
  <div class="container--wide">
    <div class="section__kicker">About</div>
    <h1 class="section__title">Tentang <?= h($site['name']) ?></h1>
    <p class="section__lead"><?= h($site['description'] ?? '') ?></p>

    <div class="divider"></div>

    <div class="grid">
      <div class="card card--big col-6 reveal" data-reveal>
        <div class="card__kicker">Waktu Operasional</div>
        <div class="card__title">Senin–Minggu</div>
        <p class="card__text">
          <?php foreach (($site['hours'] ?? []) as $day => $hours): ?>
            <strong><?= h($day) ?>:</strong> <?= h($hours) ?><br />
          <?php endforeach; ?>
        </p>
      </div>

      <div class="card card--big col-6 reveal" data-reveal>
        <div class="card__kicker">Fasilitas</div>
        <div class="card__title">Nyaman saat menunggu</div>
        <ul class="list" style="margin-top:12px">
          <?php foreach (($site['facilities'] ?? []) as $f): ?>
            <li><?= h((string)$f) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="card card--big col-12 reveal" data-reveal>
        <div class="card__kicker">Alamat</div>
        <div class="card__title">Meruya, Jakarta Barat</div>
        <p class="card__text"><?= h($site['address']) ?></p>
        <div style="margin-top:14px;display:flex;gap:12px;flex-wrap:wrap">
          <a class="btn btn--primary" href="/Bisinis/premium/contact.php">Lihat Maps</a>
          <a class="btn" href="/Bisinis/premium/services.php">Services</a>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/partials/layout.php';

