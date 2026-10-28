<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$errors = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $errors[] = t('login_empty');
    } else {
        $stmt = $conn->prepare("SELECT id, username, nama_lengkap, password FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id']      = $user['id'];
            $_SESSION['username']     = $user['username'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            setFlash('success', t('login_success'));
            header('Location: index.php');
            exit;
        } else {
            $errors[] = t('login_failed');
        }
    }
}
include __DIR__ . '/includes/header.php';
?>

<div class="login-wrapper">
    <div class="card login-card">
        <h1 class="login-title"><?= e(t('login_title')) ?></h1>
        <p class="login-subtitle"><?= e(t('login_subtitle')) ?></p>

        <?php foreach ($errors as $err): ?>
            <div class="alert alert-danger"><?= e($err) ?></div>
        <?php endforeach; ?>

        <form method="post" action="login.php" novalidate>
            <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
            <div class="form-group">
                <label for="username"><?= e(t('username')) ?></label>
                <input type="text" id="username" name="username" value="<?= e($username) ?>" autocomplete="username" required>
            </div>
            <div class="form-group">
                <label for="password"><?= e(t('password')) ?></label>
                <input type="password" id="password" name="password" autocomplete="current-password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block"><?= e(t('sign_in')) ?></button>
        </form>

        <div class="lang-switch lang-switch-dark mt-1">
            <a href="<?= e(langUrl('id')) ?>" class="<?= $_SESSION['lang'] === 'id' ? 'active' : '' ?>">🇮🇩 Indonesia</a>
            <a href="<?= e(langUrl('en')) ?>" class="<?= $_SESSION['lang'] === 'en' ? 'active' : '' ?>">🇬🇧 English</a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>