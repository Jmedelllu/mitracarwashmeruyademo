<?php

declare(strict_types=1);

require __DIR__ . '/../lib/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method Not Allowed';
    exit;
}

$name = trim((string)($_POST['name'] ?? ''));
$phone = trim((string)($_POST['phone'] ?? ''));
$message = trim((string)($_POST['message'] ?? ''));
$campaign = trim((string)($_POST['campaign'] ?? 'Campaign'));

$errors = [];
if ($name === '') $errors[] = 'Nama wajib diisi.';
if ($phone === '') $errors[] = 'Nomor WhatsApp wajib diisi.';
if ($message === '') $errors[] = 'Kebutuhan wajib diisi.';

if ($errors) {
    $q = http_build_query(['ok' => 0, 'err' => implode(' ', $errors)]);
    redirect('/Bisinis/diamond/landing.php?' . $q);
}

$item = [
    'id' => bin2hex(random_bytes(8)),
    'created_at' => date('c'),
    'name' => $name,
    'phone' => $phone,
    'campaign' => $campaign,
    'message' => $message,
    'source' => 'campaign:' . $campaign,
];

storage_add_lead($config, $item);

redirect('/Bisinis/diamond/landing.php?ok=1');
