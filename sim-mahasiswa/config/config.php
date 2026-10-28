<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$allowedLangs = ['id', 'en'];

if (isset($_GET['lang']) && in_array($_GET['lang'], $allowedLangs, true)) {
    $_SESSION['lang'] = $_GET['lang'];
}

if (!isset($_SESSION['lang']) || !in_array($_SESSION['lang'], $allowedLangs, true)) {
    $_SESSION['lang'] = 'id';
}

$langFile = __DIR__ . '/../lang/' . $_SESSION['lang'] . '.php';
if (!file_exists($langFile)) {
    $langFile = __DIR__ . '/../lang/id.php';
    $_SESSION['lang'] = 'id';
}
$lang = require $langFile;

function t(string $key): string {
    global $lang;
    return $lang[$key] ?? $key;
}

function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function sanitize($data): string {
    return trim(strip_tags((string)$data));
}

function setFlash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash(): ?array {
    if (!empty($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        setFlash('warning', t('login_required'));
        header('Location: login.php');
        exit;
    }
}

function csrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrf(): void {
    $token = $_POST['csrf_token'] ?? '';
    if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        http_response_code(403);
        die('403 - Invalid CSRF token.');
    }
}

function langUrl(string $lang): string {
    $params = $_GET; // Ambil semua parameter URL yang ada (termasuk ?id=)
    $params['lang'] = $lang; // Ganti/set bahasa
    return '?' . http_build_query($params); // Buat URL baru
}