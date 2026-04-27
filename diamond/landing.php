<?php

declare(strict_types=1);

require __DIR__ . '/lib/bootstrap.php';

$site = $config['site'];
$title = 'Campaign';

$ok = (string)($_GET['ok'] ?? '');
$err = (string)($_GET['err'] ?? '');

ob_start();
?>
<section class="hero">
  <div class="container hero__grid">
    <div>
      <div class="section__kicker">Campaign</div>
      <h1 class="hero__headline">
        Promo yang<br />
        <span class="accent">terukur</span> hasilnya.
      </h1>
      <p class="hero__sub">
        Landing page campaign (Diamond). Lead masuk ke database admin untuk follow-up.
      </p>
      <div class="hero__actions">
        <a class="btn btn--primary" href="/Bisinis/diamond/services.php">Pilih layanan</a>
        <a class="btn" href="/Bisinis/diamond/booking.php">Booking</a>
      </div>
    </div>

    <aside class="panel" aria-label="Lead form">
      <div class="panel__body">
        <h2 class="panel__title">Request info promo</h2>
        <p class="panel__muted">Isi data Anda. Tim kami akan menghubungi via WhatsApp.</p>

        <?php if ($ok === '1'): ?>
          <div class="divider"></div>
          <div class="alert alert--ok" role="status">Terima kasih! Data Anda sudah masuk.</div>
        <?php elseif ($ok === '0' && $err !== ''): ?>
          <div class="divider"></div>
          <div class="alert alert--bad" role="alert"><?= h($err) ?></div>
        <?php endif; ?>

        <div class="divider"></div>

        <form class="form" method="post" action="/Bisinis/diamond/actions/submit-lead.php">
          <input type="hidden" name="campaign" value="Weekend Shine Campaign" />
          <div class="field">
            <label class="label" for="name">Nama</label>
            <input class="input" id="name" name="name" autocomplete="name" required />
          </div>
          <div class="field">
            <label class="label" for="phone">No. WhatsApp</label>
            <input class="input" id="phone" name="phone" inputmode="tel" autocomplete="tel" required />
          </div>
          <div class="field">
            <label class="label" for="message">Kebutuhan</label>
            <textarea class="textarea" id="message" name="message" required placeholder="Jenis mobil, layanan yang diminati, dll"></textarea>
          </div>
          <button class="btn btn--gold" type="submit">Kirim</button>
        </form>
      </div>
    </aside>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/partials/layout.php';
