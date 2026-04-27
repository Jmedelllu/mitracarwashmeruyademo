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
$date = trim((string)($_POST['date'] ?? ''));
$time = trim((string)($_POST['time'] ?? ''));
$notes = trim((string)($_POST['notes'] ?? ''));

$errors = [];
if ($name === '') $errors[] = 'Nama wajib diisi.';
if ($phone === '') $errors[] = 'Nomor WhatsApp wajib diisi.';
if ($service === '') $errors[] = 'Layanan wajib dipilih.';
if ($date === '') $errors[] = 'Tanggal wajib dipilih.';
if ($time === '') $errors[] = 'Jam wajib dipilih.';

if ($errors) {
    $q = http_build_query(['ok' => 0, 'err' => implode(' ', $errors)]);
    redirect('/Bisinis/booking.php?' . $q);
}

$item = [
    'id' => bin2hex(random_bytes(8)),
    'created_at' => date('c'),
    'name' => $name,
    'phone' => $phone,
    'service' => $service,
    'date' => $date,
    'time' => $time,
    'notes' => $notes,
    'status' => 'new',
];

storage_add_appointment($config, $item);

$site = $config['site'];
$adminText = "BOOKING BARU\n"
    . "Nama: {$name}\n"
    . "WA: {$phone}\n"
    . "Layanan: {$service}\n"
    . "Jadwal: {$date} {$time}\n"
    . ($notes !== '' ? "Catatan: {$notes}\n" : '');

$waHref = wa_link($site['whatsapp_number'], $adminText);

$mode = (string)($_POST['mode'] ?? 'thanks');
if ($mode === 'wa') {
    redirect($waHref);
}

redirect('/Bisinis/booking.php?ok=1');

