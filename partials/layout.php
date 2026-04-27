<?php
/** @var array $config */
/** @var string $title */
/** @var string $content */
$site = $config['site'];
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= h($title) ?> | <?= h($site['name']) ?></title>
    <meta name="description" content="<?= h($site['tagline']) ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/Bisinis/assets/css/styles.css" />
    <script defer src="/Bisinis/assets/js/main.js"></script>
  </head>
  <body>
    <a class="skip" href="#main">Lewati ke konten</a>

    <header class="header header--clean">
      <div class="container--wide header__inner">
        <a class="brand brand--clean" href="/Bisinis/">
          <span class="brand__mark" aria-hidden="true">MC</span>
          <span class="brand__text">
            <span class="brand__name"><?= h($site['name']) ?></span>
            <span class="brand__tagline"><?= h($site['tagline']) ?></span>
          </span>
        </a>

        <button class="nav__toggle" type="button" data-nav-toggle aria-label="Buka menu">
          <span></span><span></span><span></span>
        </button>

        <nav class="nav nav--clean" data-nav>
          <a class="nav__link" href="/Bisinis/">Home</a>
          <a class="nav__link" href="/Bisinis/about.php">About</a>
          <a class="nav__link" href="/Bisinis/services.php">Services</a>
          <a class="nav__link" href="/Bisinis/booking.php">Booking</a>
          <a class="nav__link" href="/Bisinis/packages.php">Paket</a>
          <button class="nav__link nav__link--btn" type="button" data-wa-open>WhatsApp</button>
          <a class="nav__link nav__link--cta" href="/Bisinis/contact.php">Contact</a>
        </nav>
      </div>
    </header>

    <main id="main">
      <?= $content ?>
    </main>

    <?php
      $waNumber = $site['whatsapp_number'];
      $waMessage = "Halo {$site['name']}, saya ingin tanya layanan dan harga.";
      $waHref = wa_link($waNumber, $waMessage);
    ?>
    <a class="wa-float" href="<?= h($waHref) ?>" target="_blank" rel="noopener noreferrer" aria-label="Chat WhatsApp">
      <span class="wa-float__icon" aria-hidden="true">WA</span>
      <span class="wa-float__text">WhatsApp</span>
    </a>

    <div class="modal" data-wa-modal aria-hidden="true">
      <div class="modal__backdrop" data-wa-close></div>
      <div class="modal__panel" role="dialog" aria-modal="true" aria-label="WhatsApp">
        <div class="modal__head">
          <div class="modal__title">WhatsApp us</div>
          <button class="modal__close" type="button" data-wa-close aria-label="Close">✕</button>
        </div>
        <div class="modal__body">
          <p class="modal__text">Klik tombol di bawah untuk chat dengan admin.</p>
          <a class="btn btn--gold" href="<?= h($waHref) ?>" target="_blank" rel="noopener noreferrer">Chat via WhatsApp</a>
          <div class="help" style="margin-top:10px">Jika Anda membuka dari desktop, WhatsApp Web akan terbuka.</div>
        </div>
      </div>
    </div>

    <footer class="footer footer--clean">
      <div class="container--wide footer__inner">
        <div>
          <div class="footer__brand"><?= h($site['name']) ?></div>
          <div class="footer__muted"><?= h($site['address']) ?></div>
        </div>
        <div class="footer__links">
          <a href="/Bisinis/contact.php">Kontak</a>
          <a href="/Bisinis/admin/">Admin</a>
        </div>
      </div>
    </footer>
  </body>
</html>

