<?php

declare(strict_types=1);

/**
 * Resolve optional OEM logo files under /assets/brands/.
 * Filename = slug dari nama merk + ekstensi (.svg|.png|.webp|.jpg).
 * Contoh: Toyota -> assets/brands/toyota.svg
 */
function brand_slug(string $name): string
{
    $s = strtolower(trim($name));
    $s = preg_replace('/[^a-z0-9]+/', '-', $s) ?? '';
    $s = trim($s, '-');
    return $s !== '' ? $s : 'brand';
}

function brand_logo_public_path(string $name): ?string
{
    $slug = brand_slug($name);
    $dir = dirname(__DIR__) . '/assets/brands';
    foreach (['svg', 'png', 'webp', 'jpg'] as $ext) {
        $fs = $dir . '/' . $slug . '.' . $ext;
        if (is_file($fs)) {
            return '/Bisinis/assets/brands/' . $slug . '.' . $ext;
        }
    }

    return null;
}
