<?php
require_once __DIR__ . '/../config/config.php';
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="<?= e($_SESSION['lang']) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(t('app_title')) ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php if (isLoggedIn()): ?>
<nav class="navbar">
    <div class="nav-brand">🎓 <?= e(t('app_title')) ?></div>
    <div class="nav-menu">
        <a href="index.php" class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">
            <?= e(t('menu_students')) ?>
        </a>
        <a href="create.php" class="<?= $currentPage === 'create.php' ? 'active' : '' ?>">
            <?= e(t('menu_add')) ?>
        </a>
    </div>
    <div class="nav-user">
        <div class="lang-switch">
            <a href="<?= e(langUrl('id')) ?>" class="<?= $_SESSION['lang'] === 'id' ? 'active' : '' ?>">ID</a>
            <a href="<?= e(langUrl('en')) ?>" class="<?= $_SESSION['lang'] === 'en' ? 'active' : '' ?>">EN</a>
        </div>
        <span class="username">👤 <?= e($_SESSION['nama_lengkap'] ?? $_SESSION['username'] ?? '') ?></span>
        <a href="logout.php" class="btn btn-danger btn-sm" 
            onclick="return confirm('<?= e(t('confirm_logout')) ?>');">
            <?= e(t('logout')) ?>
        </a>
    </div>
</nav>
<?php endif; ?>

<main class="container">
<?php if ($flash = getFlash()): ?>
    <div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
<?php endif; ?>