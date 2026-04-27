<?php

declare(strict_types=1);

require __DIR__ . '/lib/bootstrap.php';

$site = $config['site'];
$title = 'Contact';

$ok = (string)($_GET['ok'] ?? '');
$err = (string)($_GET['err'] ?? '');

ob_start();
?>
<section class="section section--tight">
  <div class="container">
    <div class="section__kicker">Contact</div>
    <h1 class="section__title">Kontak & Lokasi</h1>
    <p class="section__lead"><?= h($site['description'] ?? 'Isi form untuk inquiry. Anda juga bisa langsung klik tombol WhatsApp di kanan bawah.') ?></p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="grid">
      <div class="col-6">
        <?php if ($ok === '1'): ?>
          <div class="alert alert--ok" role="status">Terima kasih! Inquiry Anda sudah terkirim.</div>
          <div class="divider"></div>
        <?php elseif ($ok === '0' && $err !== ''): ?>
          <div class="alert alert--bad" role="alert"><?= h($err) ?></div>
          <div class="divider"></div>
        <?php endif; ?>

        <div class="panel">
          <div class="panel__body">
            <div class="section__kicker">Inquiry</div>
            <h2 class="panel__title" style="margin-top:10px">Form kontak</h2>
            <p class="panel__muted">Kami balas secepatnya. Mohon isi nomor WhatsApp yang aktif.</p>

            <div class="divider"></div>

            <form class="form" method="post" action="/Bisinis/actions/submit-inquiry.php">
              <div class="field">
                <label class="label" for="name">Nama</label>
                <input class="input" id="name" name="name" autocomplete="name" required />
              </div>

              <div class="field">
                <label class="label" for="phone">No. WhatsApp</label>
                <input class="input" id="phone" name="phone" inputmode="tel" autocomplete="tel" placeholder="contoh: 08xxxxxxxxxx" required />
                <div class="help">Tip: pakai format lokal (08xxx) atau internasional (62xxx).</div>
              </div>

              <div class="field">
                <label class="label" for="service">Layanan (opsional)</label>
                <select id="service" name="service">
                  <option value="">Pilih layanan…</option>
                  <option value="Cuci Eksterior">Cuci Eksterior</option>
                  <option value="Interior Cleaning">Interior Cleaning</option>
                  <option value="Detailing">Detailing</option>
                  <option value="Coating / Protection">Coating / Protection</option>
                  <option value="Lainnya">Lainnya</option>
                </select>
              </div>

              <div class="field">
                <label class="label" for="message">Pesan</label>
                <textarea class="textarea" id="message" name="message" required placeholder="Tulis kebutuhan Anda (jenis mobil, keluhan, request jadwal, dll)"></textarea>
              </div>

              <div class="field">
                <label class="label" for="mode">Kirim lewat</label>
                <select id="mode" name="mode">
                  <option value="thanks">Simpan inquiry (recommended)</option>
                  <option value="wa">Buka WhatsApp (Lite)</option>
                </select>
                <div class="help">Mode WhatsApp akan membuka chat dengan pesan template berisi detail inquiry.</div>
              </div>

              <button class="btn btn--primary" type="submit">Kirim inquiry</button>
            </form>
          </div>
        </div>
      </div>

      <div class="col-6">
        <div class="panel">
          <div class="panel__body">
            <div class="section__kicker">Alamat</div>
            <h2 class="panel__title" style="margin-top:10px"><?= h($site['name']) ?></h2>
            <p class="panel__muted"><?= h($site['address']) ?></p>

            <div class="divider"></div>
            <?php if (!empty($site['hours'])): ?>
              <div class="kv" aria-label="Waktu operasional">
                <div class="kv__k">Operasional</div>
                <div class="kv__v">Senin–Minggu <?= h((string)($site['hours']['Senin'] ?? '')) ?></div>
              </div>
              <div class="divider"></div>
            <?php endif; ?>

            <?php if (!empty($site['facilities'])): ?>
              <div class="section__kicker">Fasilitas</div>
              <ul class="list" style="margin-top:12px">
                <?php foreach (($site['facilities'] ?? []) as $f): ?>
                  <li><?= h((string)$f) ?></li>
                <?php endforeach; ?>
              </ul>
              <div class="divider"></div>
            <?php endif; ?>

            <div style="display:flex;gap:12px;flex-wrap:wrap">
              <a class="btn btn--primary" href="/Bisinis/booking.php">Booking Service</a>
              <a class="btn" href="/Bisinis/services.php">Services</a>
            </div>

            <div class="divider"></div>

            <div class="map" aria-label="Google Maps">
              <iframe
                src="<?= h($site['maps_embed_url']) ?>"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                allowfullscreen
              ></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/partials/layout.php';

