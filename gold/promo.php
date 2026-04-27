<?php

declare(strict_types=1);

require __DIR__ . '/lib/bootstrap.php';

$site = $config['site'];
$title = 'Promo Treatment';

ob_start();
?>
<section class="section section--tight">
  <div class="container--wide">
    <div class="section__kicker">Promo</div>
    <h1 class="section__title">Promo Treatment</h1>
    <p class="section__lead">
      Halaman promo untuk highlight treatment unggulan (contoh paket Gold). CTA mengarah ke booking & keranjang layanan.
    </p>
  </div>
</section>

<section class="section surface">
  <div class="container--wide">
    <div class="grid">
      <div class="card card--big col-6 reveal" data-reveal>
        <div class="card__kicker">Coating</div>
        <div class="card__title">Kilap lebih tahan lama</div>
        <p class="card__text">Paket promo coating untuk proteksi eksterior (detail final mengikuti kondisi kendaraan).</p>
        <div style="margin-top:14px;display:flex;gap:12px;flex-wrap:wrap">
          <a class="btn btn--primary" href="/Bisinis/gold/booking.php">Booking</a>
          <a class="btn" href="/Bisinis/gold/services.php">Pilih layanan</a>
        </div>
      </div>

      <div class="card card--big col-6 reveal" data-reveal>
        <div class="card__kicker">Detailing</div>
        <div class="card__title">Interior &amp; eksterior lebih fresh</div>
        <p class="card__text">Promo detailing untuk “reset” tampilan mobil sebelum event atau setelah musim hujan.</p>
        <div style="margin-top:14px;display:flex;gap:12px;flex-wrap:wrap">
          <a class="btn btn--primary" href="/Bisinis/gold/contact.php">Konsultasi</a>
          <a class="btn" href="/Bisinis/gold/services.php">Lihat harga mulai</a>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/partials/layout.php';
