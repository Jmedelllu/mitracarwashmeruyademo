<?php

declare(strict_types=1);

require __DIR__ . '/../lib/bootstrap.php';

$adminCfg = $config['admin'];
session_name($adminCfg['session_name']);
session_start();

if (isset($_GET['logout'])) {
    $_SESSION = [];
    session_destroy();
    redirect('/Bisinis/gold/admin/');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = (string)($_POST['username'] ?? '');
    $p = (string)($_POST['password'] ?? '');
    if (hash_equals($adminCfg['username'], $u) && hash_equals($adminCfg['password'], $p)) {
        $_SESSION['authed'] = true;
        redirect('/Bisinis/gold/admin/dashboard.php');
    }
    $error = 'Username atau password salah.';
}

$title = 'Admin Login';
ob_start();
?>
<section class="section">
  <div class="container">
    <div class="section__kicker">Admin</div>
    <h1 class="section__title">Login</h1>
    <p class="section__lead">Dashboard sederhana untuk melihat inquiry dan booking.</p>

    <div class="divider"></div>

    <?php if ($error !== ''): ?>
      <div class="alert alert--bad" role="alert"><?= h($error) ?></div>
      <div class="divider"></div>
    <?php endif; ?>

    <div class="panel" style="max-width:520px">
      <div class="panel__body">
        <form class="form" method="post">
          <div class="field">
            <label class="label" for="username">Username</label>
            <input class="input" id="username" name="username" autocomplete="username" required />
          </div>
          <div class="field">
            <label class="label" for="password">Password</label>
            <input class="input" id="password" name="password" type="password" autocomplete="current-password" required />
          </div>
          <button class="btn btn--primary" type="submit">Masuk</button>
        </form>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../partials/layout.php';

