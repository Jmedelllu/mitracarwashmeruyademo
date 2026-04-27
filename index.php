<?php

declare(strict_types=1);

require __DIR__ . '/lib/bootstrap.php';

$site = $config['site'];
$title = 'Home';

$waHref = wa_link($site['whatsapp_number'], "Halo {$site['name']}, saya mau booking cuci mobil. Bisa dibantu?");
$catalog = $site['services_catalog'] ?? [];
$brands = $site['brands'] ?? [];

ob_start();
?>
<section class="hero">
  <div class="container hero__grid">
    <div>
      <div class="section__kicker">Meruya / Car Wash</div>
      <h1 class="hero__headline">
        Clean look.<br />
        <span class="accent">Serius</span> hasilnya.
      </h1>
      <p class="hero__sub">
        <?= h($site['description'] ?? '') ?>
      </p>
      <div class="hero__actions">
        <a class="btn btn--primary" href="/Bisinis/booking.php">Booking Service</a>
        <a class="btn" href="<?= h($waHref) ?>" target="_blank" rel="noopener noreferrer">Chat WhatsApp</a>
        <a class="btn" href="/Bisinis/services.php">Lihat Services</a>
        <a class="btn btn--ghost" href="/Bisinis/contact.php">Kontak & Lokasi</a>
      </div>
    </div>

    <aside class="panel" aria-label="Info cepat">
      <div class="panel__body">
        <h2 class="panel__title">Info cepat</h2>
        <p class="panel__muted"><?= h($site['address']) ?></p>
        <div class="panel__meta">
          <span class="chip">Mobile friendly</span>
          <span class="chip">Google Maps</span>
          <span class="chip">WhatsApp button</span>
        </div>
        <div class="divider"></div>
        <p class="panel__muted">
          Mau promo atau paket langganan? Lihat halaman <a href="/Bisinis/packages.php" style="text-decoration:underline">Paket</a>.
        </p>
        <?php if (!empty($site['hours'])): ?>
          <div class="divider"></div>
          <div class="kv" aria-label="Jam operasional">
            <div class="kv__k">Jam operasional</div>
            <div class="kv__v">Setiap hari <?= h((string)($site['hours']['Senin'] ?? '')) ?></div>
          </div>
        <?php endif; ?>
      </div>
    </aside>
  </div>

</section>

<div class="marquee" aria-hidden="true">
  <div class="container">
    <div class="marquee__track">
      <?php for ($i = 0; $i < 2; $i++): ?>
        <div class="marquee__item">Exterior Wash <span class="dot">·</span> Interior Cleaning <span class="dot">·</span> Detailing <span class="dot">·</span> Coating</div>
      <?php endfor; ?>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="section__kicker">Layanan</div>
    <h2 class="section__title">Servis yang paling dicari</h2>
    <p class="section__lead">Pilih layanan sesuai kebutuhan. Untuk estimasi cepat, kirim inquiry lewat form atau WhatsApp.</p>

    <div class="divider"></div>

    <div class="grid">
      <div class="col-7">
        <div class="table reveal" data-reveal>
          <div class="row row--head">
            <div class="row__k">Layanan</div>
            <div class="row__v">Harga mulai</div>
          </div>
          <?php foreach ($catalog as $item): ?>
            <?php
              $name = (string)($item['name'] ?? '');
              $price = (int)($item['price'] ?? 0);
            ?>
            <div class="row">
              <div class="row__k"><?= h($name) ?></div>
              <div class="row__v">Rp <?= h(number_format($price, 0, ',', '.')) ?></div>
            </div>
          <?php endforeach; ?>
        </div>
        <div style="margin-top:14px;display:flex;gap:12px;flex-wrap:wrap">
          <a class="btn btn--primary" href="/Bisinis/booking.php">Booking Service</a>
          <a class="btn" href="/Bisinis/contact.php">Kirim Inquiry</a>
          <a class="btn btn--ghost" href="/Bisinis/services.php">Semua Services</a>
        </div>
      </div>

      <div class="col-5">
        <div class="panel reveal" data-reveal>
          <div class="panel__body">
            <div class="section__kicker">Fasilitas</div>
            <h3 class="panel__title" style="margin-top:10px">Nyaman saat menunggu</h3>
            <ul class="list" style="margin-top:12px">
              <?php foreach (($site['facilities'] ?? []) as $f): ?>
                <li><?= h((string)$f) ?></li>
              <?php endforeach; ?>
            </ul>
            <div class="divider"></div>
            <div class="section__kicker">Operasional</div>
            <div class="kv" style="margin-top:10px">
              <div class="kv__k">Setiap hari</div>
              <div class="kv__v"><?= h((string)($site['hours']['Senin'] ?? '07.30 - 20.00')) ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section section--tight">
  <div class="container">
    <div class="section__kicker">Brand</div>
    <h2 class="section__title" style="font-size:clamp(26px, 3.4vw, 40px)">Merk mobil yang dilayani</h2>
    <p class="section__lead">Berbagai merk kendaraan—jika merk Anda tidak ada di daftar, tetap bisa tanya via inquiry.</p>

    <div class="divider"></div>

    <?php require __DIR__ . '/partials/brand-chips.php'; ?>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/partials/layout.php';

