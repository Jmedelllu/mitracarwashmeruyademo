<?php

declare(strict_types=1);

require __DIR__ . '/lib/bootstrap.php';

$site = $config['site'];
$title = 'Booking Service';

$ok = (string)($_GET['ok'] ?? '');
$err = (string)($_GET['err'] ?? '');

$today = date('Y-m-d');

ob_start();
?>
<section class="section section--tight">
  <div class="container">
    <div class="section__kicker">Booking</div>
    <h1 class="section__title">Booking Service</h1>
    <p class="section__lead">Jadwalkan kedatangan Anda agar terbebas dari antrian.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="grid">
      <div class="col-7">
        <?php if ($ok === '1'): ?>
          <div class="alert alert--ok" role="status">Booking Anda sudah tercatat. Kami akan konfirmasi via WhatsApp.</div>
          <div class="divider"></div>
        <?php elseif ($ok === '0' && $err !== ''): ?>
          <div class="alert alert--bad" role="alert"><?= h($err) ?></div>
          <div class="divider"></div>
        <?php endif; ?>

        <div class="panel">
          <div class="panel__body">
            <div class="section__kicker">Form</div>
            <h2 class="panel__title" style="margin-top:10px">Isi detail booking</h2>
            <p class="panel__muted">Pilih layanan dan jam kedatangan. Admin akan konfirmasi.</p>

            <div class="divider"></div>

            <form class="form" method="post" action="/Bisinis/actions/submit-booking.php">
              <div class="grid" style="gap:12px">
                <div class="field col-6">
                  <label class="label" for="name">Nama</label>
                  <input class="input" id="name" name="name" autocomplete="name" required />
                </div>
                <div class="field col-6">
                  <label class="label" for="phone">No. WhatsApp</label>
                  <input class="input" id="phone" name="phone" inputmode="tel" autocomplete="tel" required />
                </div>
              </div>

              <div class="field">
                <label class="label" for="service">Layanan</label>
                <select id="service" name="service" required>
                  <option value="">Pilih layanan…</option>
                  <option value="Car Wash">Car Wash</option>
                  <option value="Detailing">Detailing</option>
                  <option value="Salon Mobil">Salon Mobil</option>
                  <option value="Jasa Coating">Jasa Coating</option>
                  <option value="Jasa Pemasangan Anti Karat">Jasa Pemasangan Anti Karat</option>
                  <option value="Cuci Mobil Kecil">Cuci Mobil Kecil</option>
                  <option value="Poles Body">Poles Body</option>
                  <option value="Lainnya">Lainnya</option>
                </select>
              </div>

              <div class="grid" style="gap:12px">
                <div class="field col-6">
                  <label class="label" for="date">Tanggal</label>
                  <input class="input" id="date" name="date" type="date" min="<?= h($today) ?>" required />
                </div>
                <div class="field col-6">
                  <label class="label" for="time">Jam</label>
                  <input class="input" id="time" name="time" type="time" required />
                  <div class="help">Jam operasional: 07.30 - 20.00.</div>
                </div>
              </div>

              <div class="field">
                <label class="label" for="notes">Catatan (opsional)</label>
                <textarea class="textarea" id="notes" name="notes" placeholder="Contoh: jenis mobil, request khusus, estimasi durasi, dll"></textarea>
              </div>

              <div class="field">
                <label class="label" for="mode">Kirim lewat</label>
                <select id="mode" name="mode">
                  <option value="thanks">Simpan booking</option>
                  <option value="wa">Buka WhatsApp (Lite)</option>
                </select>
              </div>

              <button class="btn btn--primary" type="submit">Kirim booking</button>
            </form>
          </div>
        </div>
      </div>

      <div class="col-5">
        <div class="panel">
          <div class="panel__body">
            <div class="section__kicker">Info</div>
            <h2 class="panel__title" style="margin-top:10px"><?= h($site['name']) ?></h2>
            <p class="panel__muted"><?= h($site['address']) ?></p>

            <div class="divider"></div>

            <div class="kv" aria-label="Waktu operasional">
              <div class="kv__k">Operasional</div>
              <div class="kv__v">Senin–Minggu <?= h((string)($site['hours']['Senin'] ?? '07.30 - 20.00')) ?></div>
            </div>

            <?php if (!empty($site['facilities'])): ?>
              <div class="divider"></div>
              <div class="section__kicker">Fasilitas</div>
              <ul class="list" style="margin-top:12px">
                <?php foreach (($site['facilities'] ?? []) as $f): ?>
                  <li><?= h((string)$f) ?></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>

            <div class="divider"></div>
            <a class="btn" href="/Bisinis/contact.php">Maps & Kontak</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/partials/layout.php';

