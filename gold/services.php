<?php

declare(strict_types=1);

require __DIR__ . '/lib/bootstrap.php';

$site = $config['site'];
$title = 'Services';
$catalog = $site['services_catalog'] ?? [];
$waHref = wa_link($site['whatsapp_number'], "Halo {$site['name']}, saya ingin order layanan.");

ob_start();
?>
<section class="section">
  <div class="container">
    <div class="section__kicker">Services</div>
    <h1 class="section__title">Layanan & Harga</h1>
    <p class="section__lead">Daftar layanan dan harga mulai. Untuk estimasi detail, kirim inquiry.</p>

    <div class="divider"></div>

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

    <div style="margin-top:14px;display:flex;gap:12px;flex-wrap:wrap">
      <a class="btn btn--primary" href="/Bisinis/gold/contact.php">Kirim Inquiry</a>
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
<?php
$content = ob_get_clean();
require __DIR__ . '/partials/layout.php';

