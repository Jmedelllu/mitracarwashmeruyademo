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
$service = trim((string)($_POST['service'] ?? ''));
$message = trim((string)($_POST['message'] ?? ''));

$errors = [];
if ($name === '') $errors[] = 'Nama wajib diisi.';
if ($phone === '') $errors[] = 'Nomor WhatsApp wajib diisi.';
if ($message === '') $errors[] = 'Pesan wajib diisi.';

if ($errors) {
    $q = http_build_query(['ok' => 0, 'err' => implode(' ', $errors)]);
    redirect('/Bisinis/gold/contact.php?' . $q);
}

$item = [
    'id' => bin2hex(random_bytes(8)),
    'created_at' => date('c'),
    'name' => $name,
    'phone' => $phone,
    'service' => $service,
    'message' => $message,
    'source' => 'contact_form',
];

storage_add_inquiry($config, $item);

$site = $config['site'];
$adminText = "INQUIRY BARU\n"
    . "Nama: {$name}\n"
    . "WA: {$phone}\n"
    . ($service !== '' ? "Layanan: {$service}\n" : '')
    . "Pesan: {$message}\n";

// Basic forwarding: redirect to WhatsApp click-to-chat (acts as "Lite" flow)
$waHref = wa_link($site['whatsapp_number'], $adminText);

// Let the user choose: either show success page or open WhatsApp.
$mode = (string)($_POST['mode'] ?? 'thanks');
if ($mode === 'wa') {
    redirect($waHref);
}

redirect('/Bisinis/gold/contact.php?ok=1');

