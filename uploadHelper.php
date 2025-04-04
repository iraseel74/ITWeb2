<?php
function uploadDoctorImage($file, $prefix = 'doc_', $uploadDir = 'images/') {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    if (!in_array($file['type'], $allowedTypes)) {
        return false;
    }

    $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
    $uniqueFileName = uniqid($prefix, true) . '.' . $fileExt;
    $targetPath = $uploadDir . $uniqueFileName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $uniqueFileName;
    } else {
        return false;
    }
}
?>
