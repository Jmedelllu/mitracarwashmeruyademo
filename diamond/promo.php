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
      Versi Diamond: promo bisa dihubungkan ke landing campaign untuk tracking lead (lihat menu Campaign).
    </p>
  </div>
</section>

<section class="section surface">
  <div class="container--wide">
    <div class="grid">
      <div class="card card--big col-6 reveal" data-reveal>
        <div class="card__kicker">Weekend Deal</div>
        <div class="card__title">Bundling cuci + poles ringan</div>
        <p class="card__text">Contoh promo bundling untuk meningkatkan repeat order.</p>
        <div style="margin-top:14px;display:flex;gap:12px;flex-wrap:wrap">
          <a class="btn btn--primary" href="/Bisinis/diamond/landing.php">Buka Campaign</a>
          <a class="btn" href="/Bisinis/diamond/services.php">Checkout layanan</a>
        </div>
      </div>

      <div class="card card--big col-6 reveal" data-reveal>
        <div class="card__kicker">Member</div>
        <div class="card__title">Langganan perawatan</div>
        <p class="card__text">Contoh halaman promo untuk program membership (copy &amp; rules bisa disesuaikan).</p>
        <div style="margin-top:14px;display:flex;gap:12px;flex-wrap:wrap">
          <a class="btn btn--primary" href="/Bisinis/diamond/booking.php">Booking</a>
          <a class="btn" href="/Bisinis/diamond/blog.php">Baca tips perawatan</a>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/partials/layout.php';
