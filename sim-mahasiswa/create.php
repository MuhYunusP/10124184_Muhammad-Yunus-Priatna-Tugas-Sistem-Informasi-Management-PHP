<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/validation.php';
requireLogin();

$errors = [];
$values = ['nim' => '', 'nama' => '', 'jurusan' => '', 'angkatan' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    foreach (['nim', 'nama', 'jurusan', 'angkatan', 'email'] as $field) {
        $values[$field] = sanitize($_POST[$field] ?? '');
    }

    $errors = validateStudent($values, $conn);

    if (empty($errors)) {
        $angkatanInt = (int)$values['angkatan'];
        $stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama, jurusan, angkatan, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssis', $values['nim'], $values['nama'], $values['jurusan'], $angkatanInt, $values['email']);
        if ($stmt->execute()) {
            $stmt->close();
            setFlash('success', t('msg_created'));
            header('Location: index.php');
            exit;
        }
        $errors['general'] = t('msg_error') . ' (' . $stmt->error . ')';
        $stmt->close();
    }
}
$action      = 'create.php';
$submitLabel = t('save');
include __DIR__ . '/includes/header.php';
?>

<h1 class="page-title"><?= e(t('add_title')) ?></h1>
<?php include __DIR__ . '/includes/student_form.php'; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>