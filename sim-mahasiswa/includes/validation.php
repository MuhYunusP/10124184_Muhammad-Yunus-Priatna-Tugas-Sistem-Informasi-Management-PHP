<?php
function validateStudent(array $data, mysqli $conn, ?int $excludeId = null): array {
    $errors = [];

    if ($data['nim'] === '') {
        $errors['nim'] = t('err_nim_required');
    } elseif (!preg_match('/^\d{8,15}$/', $data['nim'])) {
        $errors['nim'] = t('err_nim_format');
    } else {
        if ($excludeId !== null) {
            $stmt = $conn->prepare("SELECT id FROM mahasiswa WHERE nim = ? AND id <> ?");
            $stmt->bind_param('si', $data['nim'], $excludeId);
        } else {
            $stmt = $conn->prepare("SELECT id FROM mahasiswa WHERE nim = ?");
            $stmt->bind_param('s', $data['nim']);
        }
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors['nim'] = t('err_nim_exists');
        }
        $stmt->close();
    }

    if ($data['nama'] === '') {
        $errors['nama'] = t('err_name_required');
    }

    if ($data['jurusan'] === '') {
        $errors['jurusan'] = t('err_major_required');
    }

    if ($data['angkatan'] === '') {
        $errors['angkatan'] = t('err_year_required');
    } else {
        $tahun = filter_var($data['angkatan'], FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1900, 'max_range' => 2100]
        ]);
        if ($tahun === false) {
            $errors['angkatan'] = t('err_year_invalid');
        }
    }

    if ($data['email'] === '') {
        $errors['email'] = t('err_email_required');
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = t('err_email_invalid');
    }

    return $errors;
}