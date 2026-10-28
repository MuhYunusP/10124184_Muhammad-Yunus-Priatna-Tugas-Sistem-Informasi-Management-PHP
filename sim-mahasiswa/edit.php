<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/validation.php';
requireLogin();

$id = filter_var($_GET['id'] ?? '', FILTER_VALIDATE_INT);
if (!$id) {
    setFlash('danger', t('msg_not_found'));
    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$row) {
    setFlash('danger', t('msg_not_found'));
    header('Location: index.php');
    exit;
}

$errors = [];
$values = ['nim' => $row['nim'], 'nama' => $row['nama'], 'jurusan' => $row['jurusan'], 'angkatan' => $row['angkatan'], 'email' => $row['email']];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    foreach (['nim', 'nama', 'jurusan', 'angkatan', 'email'] as $field) {
        $values[$field] = sanitize($_POST[$field] ?? '');
    }
    $errors = validateStudent($values, $conn, $id);

    if (empty($errors)) {
        $angkatanInt = (int)$values['angkatan'];
        $stmt = $conn->prepare("UPDATE mahasiswa SET nim = ?, nama = ?, jurusan = ?, angkatan = ?, email = ? WHERE id = ?");
        $stmt->bind_param('sssisi', $values['nim'], $values['nama'], $values['jurusan'], $angkatanInt, $values['email'], $id);
        if ($stmt->execute()) {
            $stmt->close();
            setFlash('success', t('msg_updated'));
            header('Location: index.php');
            exit;
        }
        $errors['general'] = t('msg_error') . ' (' . $stmt->error . ')';
        $stmt->close();
    }
}
$action      = 'edit.php?id=' . $id;
$submitLabel = t('update');
include __DIR__ . '/includes/header.php';
?>

<h1 class="page-title"><?= e(t('edit_title')) ?></h1>
<?php include __DIR__ . '/includes/student_form.php'; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>