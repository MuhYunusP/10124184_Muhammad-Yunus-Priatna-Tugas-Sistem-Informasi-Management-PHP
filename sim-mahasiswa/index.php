<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
requireLogin();

$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$rows   = [];

if ($search !== '') {
    $like  = '%' . $search . '%';
    $stmt  = $conn->prepare("SELECT * FROM mahasiswa WHERE nim LIKE ? OR nama LIKE ? OR jurusan LIKE ? OR email LIKE ? ORDER BY id DESC");
    $stmt->bind_param('ssss', $like, $like, $like, $like);
} else {
    $stmt = $conn->prepare("SELECT * FROM mahasiswa ORDER BY id DESC");
}

$stmt->execute();
$rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

include __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <h1 class="page-title"><?= e(t('list_title')) ?></h1>
    <a href="create.php" class="btn btn-primary">+ <?= e(t('menu_add')) ?></a>
</div>

<form method="get" action="index.php" class="search-bar">
    <input type="text" name="q" value="<?= e($search) ?>" placeholder="<?= e(t('search_placeholder')) ?>">
    <button type="submit" class="btn btn-secondary"><?= e(t('search')) ?></button>
    <?php if ($search !== ''): ?><a href="index.php" class="btn btn-secondary"><?= e(t('reset')) ?></a><?php endif; ?>
</form>

<p class="record-count"><?= e(t('total_records')) ?>: <strong><?= count($rows) ?></strong></p>

<div class="table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:60px">No</th>
                <th><?= e(t('nim')) ?></th>
                <th><?= e(t('name')) ?></th>
                <th><?= e(t('major')) ?></th>
                <th><?= e(t('year')) ?></th>
                <th><?= e(t('email')) ?></th>
                <th style="width:170px"><?= e(t('action')) ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($rows)): ?>
            <tr><td colspan="7" class="empty-row"><?= e($search === '' ? t('no_data') : t('no_result')) ?></td></tr>
        <?php else: ?>
            <?php $no = 1; foreach ($rows as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= e($row['nim']) ?></td>
                <td><?= e($row['nama']) ?></td>
                <td><?= e($row['jurusan']) ?></td>
                <td><?= e($row['angkatan']) ?></td>
                <td><?= e($row['email']) ?></td>
                <td class="action-cell">
                    <a href="edit.php?id=<?= (int)$row['id'] ?>" class="btn btn-warning btn-sm"><?= e(t('edit')) ?></a>
                    <form method="post" action="delete.php" class="inline-form" onsubmit="return confirm('<?= e(t('confirm_delete')) ?>');">
                        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
                        <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm"><?= e(t('delete')) ?></button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>