<?php

declare(strict_types=1);

require __DIR__ . '/lib/bootstrap.php';

$site = $config['site'];
$title = 'Home';

$catalog = $site['services_catalog'] ?? [];
$brands = $site['brands'] ?? [];
$waHref = wa_link($site['whatsapp_number'], "Halo {$site['name']}, saya ingin tanya layanan & harga.");

ob_start();
?>
<section class="hero">
  <div class="container hero__grid">
    <div>
      <div class="section__kicker">Gold Package</div>
      <h1 class="hero__headline">
        Black &amp; Gold.<br />
        <span class="accent">Elegan</span> untuk brand Anda.
      </h1>
      <p class="hero__sub"><?= h($site['description'] ?? '') ?></p>
      <div class="hero__actions">
        <a class="btn btn--primary" href="/Bisinis/gold/contact.php">Kirim Inquiry</a>
        <a class="btn" href="<?= h($waHref) ?>" target="_blank" rel="noopener noreferrer">Chat WhatsApp</a>
        <a class="btn btn--ghost" href="/Bisinis/gold/services.php">Lihat Layanan</a>
      </div>
    </div>

    <aside class="panel" aria-label="Ringkasan">
      <div class="panel__body">
        <h2 class="panel__title">Ringkasan</h2>
        <p class="panel__muted"><?= h($site['address']) ?></p>
        <div class="divider"></div>
        <div class="kv">
          <div class="kv__k">Operasional</div>
          <div class="kv__v">Senin–Minggu <?= h((string)($site['hours']['Senin'] ?? '07.30 - 20.00')) ?></div>
        </div>
        <div class="divider"></div>
        <div class="panel__meta">
          <span class="chip">6 halaman</span>
          <span class="chip">Booking</span>
          <span class="chip">Promo</span>
          <span class="chip">Admin</span>
        </div>
      </div>
    </aside>
  </div>
</section>

<section class="section surface">
  <div class="container--wide">
    <div class="section__kicker">Layanan</div>
    <h2 class="section__title">Harga mulai</h2>
    <p class="section__lead">Daftar layanan dan harga mulai. Untuk estimasi detail, kirim inquiry.</p>
    <div class="divider"></div>

    <div class="split">
      <div>
        <div class="table reveal" data-reveal data-cart-table>
          <div class="row row--head">
            <div class="row__k">Layanan</div>
            <div class="row__v">Harga mulai</div>
            <div class="row__a"></div>
          </div>
          <?php foreach ($catalog as $item): ?>
            <?php
              $name = (string)($item['name'] ?? '');
              $price = (int)($item['price'] ?? 0);
              $id = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));
              $id = trim($id, '-');
            ?>
            <div class="row">
              <div class="row__k"><?= h($name) ?></div>
              <div class="row__v">Rp <?= h(number_format($price, 0, ',', '.')) ?></div>
              <div class="row__a">
                <button
                  class="btn btn--gold btn--mini"
                  type="button"
                  data-add-to-cart
                  data-id="<?= h($id) ?>"
                  data-name="<?= h($name) ?>"
                  data-price="<?= h((string)$price) ?>"
                >Tambah</button>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div>
        <div class="panel card--big reveal" data-reveal>
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
              <div class="kv__k">Senin–Minggu</div>
              <div class="kv__v"><?= h((string)($site['hours']['Senin'] ?? '07.30 - 20.00')) ?></div>
            </div>
            <div class="divider"></div>
            <div style="display:flex;gap:12px;flex-wrap:wrap">
              <a class="btn btn--primary" href="/Bisinis/gold/contact.php">Kirim Inquiry</a>
              <a class="btn" href="<?= h($waHref) ?>" target="_blank" rel="noopener noreferrer">Chat WhatsApp</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<button class="cart-float" type="button" data-cart-open aria-label="Buka keranjang">
  <span class="cart-float__badge" data-cart-count>0</span>
  <span class="cart-float__label">Keranjang</span>
</button>

<aside class="drawer" data-cart-drawer aria-label="Keranjang layanan">
  <div class="drawer__head">
    <div class="drawer__title">Checkout</div>
    <button class="drawer__close" type="button" data-cart-close aria-label="Tutup">✕</button>
  </div>
  <div class="drawer__body" data-cart-items></div>
  <div class="drawer__foot">
    <div class="total">
      <span>Total estimasi</span>
      <span data-cart-total>Rp 0</span>
    </div>
    <div class="checkout">
      <a class="btn btn--gold" data-cart-wa href="<?= h($waHref) ?>" target="_blank" rel="noopener noreferrer">Checkout via WA</a>
      <a class="btn" href="/Bisinis/gold/contact.php">Kirim Inquiry</a>
      <button class="btn btn--ghost" type="button" data-cart-clear>Clear</button>
    </div>
    <div class="help" style="margin-top:10px">*Total bersifat estimasi “mulai dari”. Admin konfirmasi final.</div>
  </div>
</aside>

<section class="section section--tight">
  <div class="container">
    <div class="section__kicker">Brand</div>
    <h2 class="section__title" style="font-size:clamp(26px, 3.4vw, 40px)">Merk mobil yang dilayani</h2>
    <div class="divider"></div>
    <?php require __DIR__ . '/../partials/brand-chips.php'; ?>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/partials/layout.php';

