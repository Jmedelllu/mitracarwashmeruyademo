<?php

declare(strict_types=1);

require __DIR__ . '/../_auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method Not Allowed';
    exit;
}

$type = (string)($_POST['type'] ?? '');
$id = (string)($_POST['id'] ?? '');

if ($id === '') {
    redirect('/Bisinis/diamond/admin/dashboard.php');
}

if ($type === 'appointment_status') {
    $status = (string)($_POST['status'] ?? 'new');
    storage_update_appointment_status($config, $id, $status);
    redirect('/Bisinis/diamond/admin/dashboard.php');
}

if ($type === 'inquiry_state') {
    $state = (string)($_POST['state'] ?? 'open');
    storage_update_inquiry_state($config, $id, $state);
    redirect('/Bisinis/diamond/admin/dashboard.php');
}

redirect('/Bisinis/diamond/admin/dashboard.php');
