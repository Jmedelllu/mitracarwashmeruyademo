<?php

declare(strict_types=1);

require __DIR__ . '/lib/bootstrap.php';

$site = $config['site'];
$title = 'About Us';
$cover = $site['images']['montiro_2'] ?? '';

ob_start();
?>
<section class="section">
  <div class="container">
    <div class="section__kicker">About</div>
    <h1 class="section__title">Tentang <?= h($site['name']) ?></h1>
    <p class="section__lead">
      <?= h($site['description'] ?? '') ?>
    </p>

    <div class="divider"></div>

    <div class="grid">
      <div class="card col-6 reveal" data-reveal>
        <div class="card__kicker">Prinsip</div>
        <div class="card__title">Rapi, bersih, dan terukur</div>
        <p class="card__text">Kami mengutamakan standar proses kerja yang jelas supaya hasilnya konsisten di setiap kunjungan.</p>
      </div>
      <div class="card col-6 reveal" data-reveal>
        <div class="card__kicker">Experience</div>
        <div class="card__title">Ngga ribet</div>
        <p class="card__text">Pelanggan bisa langsung chat WhatsApp atau isi form inquiry untuk respon cepat.</p>
      </div>
      <div class="card col-12 reveal" data-reveal>
        <div class="card__kicker">Lokasi</div>
        <div class="card__title">Meruya, Jakarta Barat</div>
        <p class="card__text"><?= h($site['address']) ?></p>
        <div style="margin-top:14px;display:flex;gap:12px;flex-wrap:wrap">
          <a class="btn btn--primary" href="/Bisinis/contact.php">Lihat Maps</a>
          <a class="btn" href="/Bisinis/booking.php">Booking Service</a>
          <a class="btn" href="/Bisinis/services.php">Services</a>
        </div>
      </div>

      <div class="card col-6 reveal" data-reveal>
        <div class="card__kicker">Waktu Operasional</div>
        <div class="card__title">Senin–Minggu</div>
        <p class="card__text">
          <?php foreach (($site['hours'] ?? []) as $day => $hours): ?>
            <strong><?= h($day) ?>:</strong> <?= h($hours) ?><br />
          <?php endforeach; ?>
        </p>
      </div>

      <div class="card col-6 reveal" data-reveal>
        <div class="card__kicker">Fasilitas</div>
        <div class="card__title">Nyaman saat menunggu</div>
        <ul class="list" style="margin-top:12px">
          <?php foreach (($site['facilities'] ?? []) as $f): ?>
            <li><?= h((string)$f) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <?php if ($cover): ?>
      <div style="margin-top:18px">
        <div class="media reveal" data-reveal>
          <img src="<?= h($cover) ?>" alt="Mitra Car Wash (Meruya) - info profil" />
          <div class="media__caption">Referensi tambahan: brand/merk mobil yang dilayani.</div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/partials/layout.php';

