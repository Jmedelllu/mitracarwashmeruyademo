<?php

declare(strict_types=1);

$config = require __DIR__ . '/../config.php';

date_default_timezone_set('Asia/Jakarta');

require_once __DIR__ . '/storage.php';
require_once __DIR__ . '/brands.php';

function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function json_read_array(string $path): array
{
    if (!file_exists($path)) {
        return [];
    }
    $raw = file_get_contents($path);
    if ($raw === false || trim($raw) === '') {
        return [];
    }
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : [];
}

function json_write_array(string $path, array $data): void
{
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    file_put_contents($path, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

function redirect(string $to): never
{
    header('Location: ' . $to);
    exit;
}

function wa_link(string $number, string $message): string
{
    $text = rawurlencode($message);
    return "https://wa.me/{$number}?text={$text}";
}

