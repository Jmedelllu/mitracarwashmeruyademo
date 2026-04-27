<?php

declare(strict_types=1);

require __DIR__ . '/../lib/bootstrap.php';

$adminCfg = $config['admin'];
session_name($adminCfg['session_name']);
session_start();

if (!($_SESSION['authed'] ?? false)) {
    redirect('/Bisinis/diamond/admin/');
}

