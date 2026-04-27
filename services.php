<?php

declare(strict_types=1);

require __DIR__ . '/lib/bootstrap.php';

$site = $config['site'];
$title = 'Services';

ob_start();
?>
<section class="section">
  <div class="container">
    <div class="section__kicker">Services</div>
    <h1 class="section__title">Layanan</h1>
    <p class="section__lead">Daftar layanan inti. Untuk estimasi biaya yang akurat, kirim detail mobil dan kebutuhan Anda.</p>

    <div class="divider"></div>

    <div class="grid">
      <div class="card col-4 reveal" data-reveal>
        <div class="card__kicker">Exterior</div>
        <div class="card__title">Cuci Eksterior</div>
        <p class="card__text">Body wash, velg/ban, quick finishing.</p>
      </div>
      <div class="card col-4 reveal" data-reveal>
        <div class="card__kicker">Interior</div>
        <div class="card__title">Pembersihan Interior</div>
        <p class="card__text">Vacuum, dashboard wipe, interior refresh.</p>
      </div>
      <div class="card col-4 reveal" data-reveal>
        <div class="card__kicker">Detail</div>
        <div class="card__title">Detailing</div>
        <p class="card__text">Deep clean dengan fokus area detail (sesuai paket).</p>
      </div>

      <div class="card col-6 reveal" data-reveal>
        <div class="card__kicker">Protection</div>
        <div class="card__title">Coating / Protection</div>
        <p class="card__text">Perlindungan tambahan untuk menjaga kilap dan memudahkan perawatan harian.</p>
      </div>
      <div class="card col-6 reveal" data-reveal>
        <div class="card__kicker">Add-on</div>
        <div class="card__title">Add-on Treatment</div>
        <p class="card__text">Polish ringan, pembersihan jamur kaca, dan add-on lain (on request).</p>
      </div>
    </div>

    <div style="margin-top:18px;display:flex;gap:12px;flex-wrap:wrap">
      <a class="btn btn--primary" href="/Bisinis/contact.php">Kirim Inquiry</a>
      <a class="btn" href="/Bisinis/packages.php">Lihat Paket</a>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/partials/layout.php';

