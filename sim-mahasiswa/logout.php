<?php
require_once __DIR__ . '/config/config.php';


$pesan_logout = t('logout_success');


unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['nama_lengkap']);


setFlash('success', $pesan_logout);

header('Location: login.php');
exit;