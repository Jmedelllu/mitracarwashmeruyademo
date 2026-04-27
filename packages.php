<?php

declare(strict_types=1);

require __DIR__ . '/lib/bootstrap.php';

$site = $config['site'];
$title = 'Paket';

ob_start();
?>
<section class="section">
  <div class="container">
    <div class="section__kicker">Packages</div>
    <h1 class="section__title">Paket Website</h1>
    <p class="section__lead">
      Ini halaman paket sesuai spesifikasi yang Anda berikan (Premium/Gold/Diamond), lengkap dengan detail website, WhatsApp automation, support, dan maintenance.
    </p>

    <div class="divider"></div>

    <div class="grid">
      <div class="card col-4 reveal" data-reveal>
        <div class="card__kicker">Premium</div>
        <div class="card__title">Rp 4.400.000 / tahun</div>
        <p class="card__text">Rp 425.000 / bulan</p>
        <div class="divider"></div>
        <p class="card__text"><strong>Website</strong>: 3–4 halaman, responsive, Maps, form kontak, tombol WhatsApp, domain+hosting.</p>
        <p class="card__text" style="margin-top:10px"><strong>WA Automation</strong>: notifikasi pesan masuk, auto forward inquiry, integrasi basic (WA Lite), 1.000 messages.</p>
        <p class="card__text" style="margin-top:10px"><strong>Support</strong>: 2x revisi (paket tahun), support 7 hari.</p>
        <p class="card__text" style="margin-top:10px"><strong>Maintenance</strong>: bulanan 1x ringan; tahunan 8x ringan + 1x berat.</p>
      </div>

      <div class="card col-4 reveal" data-reveal style="border-color:rgba(215,255,47,.26);background:rgba(215,255,47,.06)">
        <div class="card__kicker">Gold</div>
        <div class="card__title">Rp 6.620.000 / tahun</div>
        <p class="card__text">Rp 635.000 / bulan</p>
        <div class="divider"></div>
        <p class="card__text"><strong>Website</strong>: semua fitur Premium + hingga 6 halaman, booking appointment online, dashboard admin sederhana, halaman promo treatment.</p>
        <p class="card__text" style="margin-top:10px"><strong>WA Automation</strong>: auto reply, reminder appointment, follow-up inquiry otomatis, integrasi WA Regular, 10.000 messages.</p>
        <p class="card__text" style="margin-top:10px"><strong>Support</strong>: 5x revisi (paket tahun), support 14 hari.</p>
        <p class="card__text" style="margin-top:10px"><strong>Maintenance</strong>: bulanan 2x ringan; tahunan 11x ringan + 2x berat.</p>
      </div>

      <div class="card col-4 reveal" data-reveal>
        <div class="card__kicker">Diamond</div>
        <div class="card__title">Rp 11.650.000 / tahun</div>
        <p class="card__text">Rp 1.095.000 / bulan</p>
        <div class="divider"></div>
        <p class="card__text"><strong>Website</strong>: semua fitur Gold + unlimited halaman, landing campaign, SEO basic, blog/artikel, dashboard management lanjutan.</p>
        <p class="card__text" style="margin-top:10px"><strong>WA Automation</strong>: full workflow, broadcast promo, mass reminder, kirim file/gambar otomatis, integrasi WA Ultra, 25.000 messages.</p>
        <p class="card__text" style="margin-top:10px"><strong>Support</strong>: 8x revisi (paket tahun), support 20 hari.</p>
        <p class="card__text" style="margin-top:10px"><strong>Maintenance</strong>: bulanan 3x ringan; tahunan 16x ringan + 5x berat.</p>
      </div>
    </div>

    <div class="divider"></div>

    <div class="grid">
      <div class="card col-6 reveal" data-reveal>
        <div class="card__kicker">Maintenance Tambahan</div>
        <div class="card__title">Maintenance berat (di luar paket)</div>
        <p class="card__text">Mulai dari <strong>Rp 615.000</strong> / request. Contoh: penambahan fitur baru, redesign besar, integrasi sistem tambahan.</p>
      </div>
      <div class="card col-6 reveal" data-reveal>
        <div class="card__kicker">Ketentuan Domain</div>
        <div class="card__title">Aturan domain</div>
        <p class="card__text">Domain termasuk 1 tahun pertama. Nama domain ditentukan di awal project dan tidak bisa diganti selama masa aktif.</p>
        <p class="card__text" style="margin-top:10px">Jika ingin ganti nama domain setelah registrasi aktif, dikenakan biaya tambahan <strong>Rp 300.000</strong>.</p>
      </div>
    </div>

    <div style="margin-top:18px;display:flex;gap:12px;flex-wrap:wrap">
      <a class="btn btn--primary" href="/Bisinis/contact.php">Konsultasi & Inquiry</a>
      <a class="btn" href="/Bisinis/admin/">Buka Admin</a>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/partials/layout.php';

