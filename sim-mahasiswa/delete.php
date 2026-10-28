<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

verifyCsrf();
$id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);
if (!$id) {
    setFlash('danger', t('msg_not_found'));
    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    setFlash('success', t('msg_deleted'));
} else {
    setFlash('danger', t('msg_not_found'));
}

$stmt->close();
header('Location: index.php');
exit;