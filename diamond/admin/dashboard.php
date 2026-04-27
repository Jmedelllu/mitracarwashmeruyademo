<?php

declare(strict_types=1);

require __DIR__ . '/_auth.php';

$site = $config['site'];
$title = 'Admin Dashboard';

$inquiries = storage_list_inquiries($config, 60);
$appointments = storage_list_appointments($config, 60);
$leads = storage_list_leads($config, 60);

ob_start();
?>
<section class="section section--tight">
  <div class="container--wide">
    <div class="section__kicker">Admin</div>
    <h1 class="section__title">Dashboard</h1>
    <p class="section__lead">Dashboard manajemen lanjutan (Diamond): booking, inquiry, campaign lead, dan status.</p>
    <div style="margin-top:14px;display:flex;gap:12px;flex-wrap:wrap">
      <a class="btn" href="/Bisinis/diamond/admin/?logout=1">Logout</a>
      <a class="btn btn--primary" href="/Bisinis/diamond/contact.php">Buka Contact Page</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container--wide">
    <div class="grid">
      <div class="card col-4 reveal" data-reveal>
        <div class="card__kicker">Ringkasan</div>
        <div class="card__title">Booking</div>
        <p class="card__text"><strong><?= count($appointments) ?></strong> record</p>
      </div>
      <div class="card col-4 reveal" data-reveal>
        <div class="card__kicker">Ringkasan</div>
        <div class="card__title">Inquiry</div>
        <p class="card__text"><strong><?= count($inquiries) ?></strong> record</p>
      </div>
      <div class="card col-4 reveal" data-reveal>
        <div class="card__kicker">Ringkasan</div>
        <div class="card__title">Campaign</div>
        <p class="card__text"><strong><?= count($leads) ?></strong> lead</p>
      </div>
    </div>

    <div class="divider"></div>

    <div class="section__kicker">Campaign</div>
    <h2 class="section__title" style="font-size:clamp(26px, 3.4vw, 38px)">Leads</h2>
    <p class="section__lead">Total: <?= count($leads) ?>.</p>

    <div class="divider"></div>

    <div class="grid">
      <?php if (!$leads): ?>
        <div class="card col-12">
          <div class="card__kicker">Kosong</div>
          <div class="card__title">Belum ada lead campaign</div>
          <p class="card__text">Coba submit form di halaman Campaign.</p>
        </div>
      <?php else: ?>
        <?php foreach (array_slice($leads, 0, 30) as $lead): ?>
          <?php $waToCustomer = wa_link((string)($lead['phone'] ?? ''), "Halo {$lead['name']}, terima kasih sudah tertarik dengan promo campaign. Ada yang bisa kami bantu?"); ?>
          <div class="card col-6 reveal" data-reveal>
            <div class="card__kicker"><?= h(date('d M Y H:i', strtotime((string)($lead['created_at'] ?? 'now')))) ?></div>
            <div class="card__title"><?= h((string)($lead['name'] ?? '-')) ?></div>
            <p class="card__text">
              <strong>WA:</strong> <?= h((string)($lead['phone'] ?? '-')) ?><br />
              <strong>Campaign:</strong> <?= h((string)($lead['campaign'] ?? '-')) ?><br />
              <strong>Pesan:</strong> <?= h((string)($lead['message'] ?? '')) ?>
            </p>
            <div style="margin-top:12px;display:flex;gap:10px;flex-wrap:wrap">
              <a class="btn btn--primary" href="<?= h($waToCustomer) ?>" target="_blank" rel="noopener noreferrer">Follow-up WA</a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <div class="divider"></div>
    <div class="section__kicker">Booking</div>
    <h2 class="section__title" style="font-size:clamp(26px, 3.4vw, 38px)">Appointment</h2>
    <p class="section__lead">Total: <?= count($appointments) ?>.</p>

    <div class="divider"></div>

    <div class="grid">
      <?php if (!$appointments): ?>
        <div class="card col-12">
          <div class="card__kicker">Kosong</div>
          <div class="card__title">Belum ada booking</div>
          <p class="card__text">Coba isi booking lewat halaman Booking untuk testing.</p>
        </div>
      <?php else: ?>
        <?php foreach (array_slice($appointments, 0, 30) as $apt): ?>
          <?php
            $when = trim(((string)($apt['date'] ?? '')) . ' ' . ((string)($apt['time'] ?? '')));
            $waToCustomer = wa_link((string)($apt['phone'] ?? ''), "Halo {$apt['name']}, booking Anda di {$site['name']} untuk {$when} sudah kami terima. Kami konfirmasi ya.");
          ?>
          <div class="card col-6 reveal" data-reveal>
            <div class="card__kicker"><?= h(date('d M Y H:i', strtotime((string)($apt['created_at'] ?? 'now')))) ?></div>
            <div class="card__title"><?= h((string)($apt['name'] ?? '-')) ?></div>
            <p class="card__text">
              <strong>WA:</strong> <?= h((string)($apt['phone'] ?? '-')) ?><br />
              <strong>Layanan:</strong> <?= h((string)($apt['service'] ?? '-')) ?><br />
              <strong>Jadwal:</strong> <?= h($when !== '' ? $when : '-') ?><br />
              <?php if (!empty($apt['notes'])): ?>
                <strong>Catatan:</strong> <?= h((string)$apt['notes']) ?><br />
              <?php endif; ?>
              <strong>Status:</strong> <?= h((string)($apt['status'] ?? 'new')) ?>
            </p>
            <div style="margin-top:12px;display:flex;gap:10px;flex-wrap:wrap;align-items:center">
              <a class="btn btn--primary" href="<?= h($waToCustomer) ?>" target="_blank" rel="noopener noreferrer">Konfirmasi via WA</a>
              <form method="post" action="/Bisinis/diamond/admin/actions/update.php" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
                <input type="hidden" name="type" value="appointment_status" />
                <input type="hidden" name="id" value="<?= h((string)($apt['id'] ?? '')) ?>" />
                <select class="input" name="status" style="width:auto;min-width:170px">
                  <?php $st = (string)($apt['status'] ?? 'new'); ?>
                  <option value="new" <?= $st === 'new' ? 'selected' : '' ?>>new</option>
                  <option value="confirmed" <?= $st === 'confirmed' ? 'selected' : '' ?>>confirmed</option>
                  <option value="done" <?= $st === 'done' ? 'selected' : '' ?>>done</option>
                  <option value="cancelled" <?= $st === 'cancelled' ? 'selected' : '' ?>>cancelled</option>
                </select>
                <button class="btn" type="submit">Update</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <div class="divider"></div>

    <div class="section__kicker">Inquiry</div>
    <h2 class="section__title" style="font-size:clamp(26px, 3.4vw, 38px)">Pesan masuk</h2>
    <p class="section__lead">Total: <?= count($inquiries) ?>.</p>

    <div class="divider"></div>

    <div class="grid">
      <?php if (!$inquiries): ?>
        <div class="card col-12">
          <div class="card__kicker">Kosong</div>
          <div class="card__title">Belum ada inquiry</div>
          <p class="card__text">Coba isi form di halaman Contact untuk testing.</p>
        </div>
      <?php else: ?>
        <?php foreach (array_slice($inquiries, 0, 30) as $inq): ?>
          <?php
            $waToCustomer = wa_link($inq['phone'], "Halo {$inq['name']}, terima kasih sudah menghubungi {$site['name']}. Ada yang bisa kami bantu?");
          ?>
          <div class="card col-6 reveal" data-reveal>
            <div class="card__kicker"><?= h(date('d M Y H:i', strtotime((string)($inq['created_at'] ?? 'now')))) ?></div>
            <div class="card__title"><?= h((string)($inq['name'] ?? '-')) ?></div>
            <p class="card__text">
              <strong>WA:</strong> <?= h((string)($inq['phone'] ?? '-')) ?><br />
              <?php if (!empty($inq['service'])): ?>
                <strong>Layanan:</strong> <?= h((string)$inq['service']) ?><br />
              <?php endif; ?>
              <strong>Pesan:</strong> <?= h((string)($inq['message'] ?? '')) ?>
            </p>
            <div style="margin-top:12px;display:flex;gap:10px;flex-wrap:wrap;align-items:center">
              <a class="btn btn--primary" href="<?= h($waToCustomer) ?>" target="_blank" rel="noopener noreferrer">Balas via WA</a>
              <form method="post" action="/Bisinis/diamond/admin/actions/update.php" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
                <input type="hidden" name="type" value="inquiry_state" />
                <input type="hidden" name="id" value="<?= h((string)($inq['id'] ?? '')) ?>" />
                <?php $st = (string)($inq['state'] ?? 'open'); ?>
                <select class="input" name="state" style="width:auto;min-width:170px">
                  <option value="open" <?= $st === 'open' ? 'selected' : '' ?>>open</option>
                  <option value="in_progress" <?= $st === 'in_progress' ? 'selected' : '' ?>>in_progress</option>
                  <option value="closed" <?= $st === 'closed' ? 'selected' : '' ?>>closed</option>
                </select>
                <button class="btn" type="submit">Update</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../partials/layout.php';

