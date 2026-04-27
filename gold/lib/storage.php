<?php

declare(strict_types=1);

/**
 * Storage abstraction:
 * - JSON (existing behavior)
 * - SQLite (optional, still within "website" scope)
 */

function storage_mode(array $config): string
{
    $mode = (string)($config['storage']['mode'] ?? 'json');
    return in_array($mode, ['json', 'sqlite'], true) ? $mode : 'json';
}

function sqlite_pdo(array $config): PDO
{
    $path = (string)($config['storage']['sqlite_path'] ?? (__DIR__ . '/../storage/app.sqlite'));
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $pdo = new PDO('sqlite:' . $path, null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // migrations (idempotent)
    $pdo->exec('CREATE TABLE IF NOT EXISTS inquiries (
        id TEXT PRIMARY KEY,
        created_at TEXT NOT NULL,
        name TEXT NOT NULL,
        phone TEXT NOT NULL,
        service TEXT,
        message TEXT NOT NULL,
        source TEXT
    )');

    $pdo->exec('CREATE TABLE IF NOT EXISTS appointments (
        id TEXT PRIMARY KEY,
        created_at TEXT NOT NULL,
        name TEXT NOT NULL,
        phone TEXT NOT NULL,
        service TEXT NOT NULL,
        date TEXT NOT NULL,
        time TEXT NOT NULL,
        notes TEXT,
        status TEXT NOT NULL
    )');

    $pdo->exec('CREATE TABLE IF NOT EXISTS leads (
        id TEXT PRIMARY KEY,
        created_at TEXT NOT NULL,
        name TEXT NOT NULL,
        phone TEXT NOT NULL,
        campaign TEXT NOT NULL,
        message TEXT NOT NULL,
        source TEXT
    )');

    // lightweight migrations for older sqlite files
    try {
        $pdo->exec('ALTER TABLE inquiries ADD COLUMN state TEXT DEFAULT \'open\'');
    } catch (Exception) {
        // ignore if exists
    }

    return $pdo;
}

function storage_add_inquiry(array $config, array $item): void
{
    $mode = storage_mode($config);
    if ($mode === 'sqlite') {
        $pdo = sqlite_pdo($config);
        try {
            $stmt = $pdo->prepare('INSERT INTO inquiries (id, created_at, name, phone, service, message, source, state)
                VALUES (:id, :created_at, :name, :phone, :service, :message, :source, :state)');
            $stmt->execute([
                ':id' => (string)$item['id'],
                ':created_at' => (string)$item['created_at'],
                ':name' => (string)$item['name'],
                ':phone' => (string)$item['phone'],
                ':service' => (string)($item['service'] ?? ''),
                ':message' => (string)$item['message'],
                ':source' => (string)($item['source'] ?? ''),
                ':state' => (string)($item['state'] ?? 'open'),
            ]);
        } catch (Exception) {
            $stmt = $pdo->prepare('INSERT INTO inquiries (id, created_at, name, phone, service, message, source)
                VALUES (:id, :created_at, :name, :phone, :service, :message, :source)');
            $stmt->execute([
                ':id' => (string)$item['id'],
                ':created_at' => (string)$item['created_at'],
                ':name' => (string)$item['name'],
                ':phone' => (string)$item['phone'],
                ':service' => (string)($item['service'] ?? ''),
                ':message' => (string)$item['message'],
                ':source' => (string)($item['source'] ?? ''),
            ]);
        }
        return;
    }

    $path = (string)$config['storage']['inquiries_path'];
    $items = json_read_array($path);
    if (!isset($item['state'])) {
        $item['state'] = 'open';
    }
    array_unshift($items, $item);
    json_write_array($path, $items);
}

function storage_list_inquiries(array $config, int $limit = 30): array
{
    $mode = storage_mode($config);
    if ($mode === 'sqlite') {
        $pdo = sqlite_pdo($config);
        $stmt = $pdo->prepare('SELECT * FROM inquiries ORDER BY created_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll() ?: [];
    }

    $path = (string)$config['storage']['inquiries_path'];
    return array_slice(json_read_array($path), 0, $limit);
}

function storage_add_appointment(array $config, array $item): void
{
    $mode = storage_mode($config);
    if ($mode === 'sqlite') {
        $pdo = sqlite_pdo($config);
        $stmt = $pdo->prepare('INSERT INTO appointments (id, created_at, name, phone, service, date, time, notes, status)
            VALUES (:id, :created_at, :name, :phone, :service, :date, :time, :notes, :status)');
        $stmt->execute([
            ':id' => (string)$item['id'],
            ':created_at' => (string)$item['created_at'],
            ':name' => (string)$item['name'],
            ':phone' => (string)$item['phone'],
            ':service' => (string)$item['service'],
            ':date' => (string)$item['date'],
            ':time' => (string)$item['time'],
            ':notes' => (string)($item['notes'] ?? ''),
            ':status' => (string)($item['status'] ?? 'new'),
        ]);
        return;
    }

    $path = (string)$config['storage']['appointments_path'];
    $items = json_read_array($path);
    array_unshift($items, $item);
    json_write_array($path, $items);
}

function storage_list_appointments(array $config, int $limit = 30): array
{
    $mode = storage_mode($config);
    if ($mode === 'sqlite') {
        $pdo = sqlite_pdo($config);
        $stmt = $pdo->prepare('SELECT * FROM appointments ORDER BY created_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll() ?: [];
    }

    $path = (string)$config['storage']['appointments_path'];
    return array_slice(json_read_array($path), 0, $limit);
}

function storage_add_lead(array $config, array $item): void
{
    $mode = storage_mode($config);
    if ($mode === 'sqlite') {
        $pdo = sqlite_pdo($config);
        $stmt = $pdo->prepare('INSERT INTO leads (id, created_at, name, phone, campaign, message, source)
            VALUES (:id, :created_at, :name, :phone, :campaign, :message, :source)');
        $stmt->execute([
            ':id' => (string)$item['id'],
            ':created_at' => (string)$item['created_at'],
            ':name' => (string)$item['name'],
            ':phone' => (string)$item['phone'],
            ':campaign' => (string)$item['campaign'],
            ':message' => (string)$item['message'],
            ':source' => (string)($item['source'] ?? ''),
        ]);
        return;
    }

    // JSON fallback: reuse inquiries list
    $path = (string)$config['storage']['inquiries_path'];
    $items = json_read_array($path);
    $inq = [
        'id' => (string)$item['id'],
        'created_at' => (string)$item['created_at'],
        'name' => (string)$item['name'],
        'phone' => (string)$item['phone'],
        'service' => (string)$item['campaign'],
        'message' => (string)$item['message'],
        'source' => (string)($item['source'] ?? 'campaign'),
        'state' => 'open',
    ];
    array_unshift($items, $inq);
    json_write_array($path, $items);
}

function storage_list_leads(array $config, int $limit = 30): array
{
    $mode = storage_mode($config);
    if ($mode === 'sqlite') {
        $pdo = sqlite_pdo($config);
        $stmt = $pdo->prepare('SELECT * FROM leads ORDER BY created_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll() ?: [];
    }

    $path = (string)$config['storage']['inquiries_path'];
    $items = json_read_array($path);
    $filtered = array_values(array_filter($items, static function ($row) {
        $src = (string)($row['source'] ?? '');
        return str_contains($src, 'campaign');
    }));
    return array_slice($filtered, 0, $limit);
}

function storage_update_appointment_status(array $config, string $id, string $status): void
{
    $mode = storage_mode($config);
    if ($mode === 'sqlite') {
        $pdo = sqlite_pdo($config);
        $stmt = $pdo->prepare('UPDATE appointments SET status = :status WHERE id = :id');
        $stmt->execute([':status' => $status, ':id' => $id]);
        return;
    }

    $path = (string)$config['storage']['appointments_path'];
    $items = json_read_array($path);
    foreach ($items as &$row) {
        if (($row['id'] ?? '') === $id) {
            $row['status'] = $status;
        }
    }
    unset($row);
    json_write_array($path, $items);
}

function storage_update_inquiry_state(array $config, string $id, string $state): void
{
    $mode = storage_mode($config);
    if ($mode === 'sqlite') {
        $pdo = sqlite_pdo($config);
        $stmt = $pdo->prepare('UPDATE inquiries SET state = :state WHERE id = :id');
        $stmt->execute([':state' => $state, ':id' => $id]);
        return;
    }

    $path = (string)$config['storage']['inquiries_path'];
    $items = json_read_array($path);
    foreach ($items as &$row) {
        if (($row['id'] ?? '') === $id) {
            $row['state'] = $state;
        }
    }
    unset($row);
    json_write_array($path, $items);
}

