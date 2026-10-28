<form method="post" action="<?= e($action) ?>" class="card form-card" novalidate>
    <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">

    <p class="hint"><?= e(t('required_hint')) ?></p>

    <?php if (!empty($errors['general'])): ?>
        <div class="alert alert-danger"><?= e($errors['general']) ?></div>
    <?php endif; ?>

    <div class="form-group">
        <label for="nim"><?= e(t('nim')) ?> <span class="required">*</span></label>
        <input type="text" id="nim" name="nim" maxlength="15" value="<?= e($values['nim']) ?>" required>
        <?php if (!empty($errors['nim'])): ?><small class="error-text"><?= e($errors['nim']) ?></small><?php endif; ?>
    </div>

    <div class="form-group">
        <label for="nama"><?= e(t('name')) ?> <span class="required">*</span></label>
        <input type="text" id="nama" name="nama" maxlength="100" value="<?= e($values['nama']) ?>" required>
        <?php if (!empty($errors['nama'])): ?><small class="error-text"><?= e($errors['nama']) ?></small><?php endif; ?>
    </div>

    <div class="form-group">
        <label for="jurusan"><?= e(t('major')) ?> <span class="required">*</span></label>
        <input type="text" id="jurusan" name="jurusan" maxlength="100" value="<?= e($values['jurusan']) ?>" required>
        <?php if (!empty($errors['jurusan'])): ?><small class="error-text"><?= e($errors['jurusan']) ?></small><?php endif; ?>
    </div>

            <div class="form-group">
        <label for="angkatan"><?= e(t('year')) ?> <span class="required">*</span></label>
        <select id="angkatan" name="angkatan" required style="width: 100%; padding: .6rem .75rem; font-size: .9rem; border: 1px solid #cbd5e1; border-radius: 7px; background-color: #fff;">
            <option value=""><?= e(t('select_year')) ?></option>
            <?php
            $currentYear = (int)date('Y');
            $startYear = 1900; // Batas tahun paling lama
            // Looping dari 5 tahun ke depan sampai 1900
            for ($y = $currentYear + 5; $y >= $startYear; $y--) {
                $selected = ($values['angkatan'] == $y) ? 'selected' : '';
                echo "<option value=\"$y\" $selected>$y</option>";
            }
            ?>
        </select>
        <?php if (!empty($errors['angkatan'])): ?>
            <small class="error-text"><?= e($errors['angkatan']) ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="email"><?= e(t('email')) ?> <span class="required">*</span></label>
        <input type="email" id="email" name="email" maxlength="100" value="<?= e($values['email']) ?>" required>
        <?php if (!empty($errors['email'])): ?><small class="error-text"><?= e($errors['email']) ?></small><?php endif; ?>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= e($submitLabel) ?></button>
        <a href="index.php" class="btn btn-secondary"><?= e(t('cancel')) ?></a>
    </div>
</form>