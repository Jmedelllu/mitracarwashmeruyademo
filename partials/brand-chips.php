<?php

declare(strict_types=1);

/** @var array<int, string> $brands */
?>
<ul class="list list--brands reveal" data-reveal style="margin-top:14px">
  <?php foreach ($brands as $b): ?>
    <?php $label = (string) $b; ?>
    <?php $logoSrc = brand_logo_public_path($label); ?>
    <li class="brand-chip">
      <?php if ($logoSrc !== null): ?>
        <img
          class="brand-chip__logo"
          src="<?= h($logoSrc) ?>"
          alt="<?= h($label) ?>"
          loading="lazy"
          decoding="async"
          width="96"
          height="32"
        />
      <?php else: ?>
        <span class="brand-chip__text"><?= h($label) ?></span>
      <?php endif; ?>
    </li>
  <?php endforeach; ?>
</ul>
