<?php
$maxFileSize = 5 * 1024 * 1024;
$allowedTypes = [
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'pdf' => 'application/pdf'
];
$uploadDirectory = __DIR__ . DIRECTORY_SEPARATOR . 'uploads';
$message = '';
$messageType = '';

if (!is_dir($uploadDirectory)) {
    if (!mkdir($uploadDirectory, 0750, true)) {
        die('Error: Could not create the upload directory.');
    }
}

$htaccessPath = $uploadDirectory . DIRECTORY_SEPARATOR . '.htaccess';
if (!file_exists($htaccessPath)) {
    $htaccessContent = "Options -Indexes\nRequire all denied\n";
    file_put_contents($htaccessPath, $htaccessContent);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['uploaded_file'])) {
        $message = 'No file was received.';
        $messageType = 'error';
    } else {
        $file = $_FILES['uploaded_file'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $message = 'The upload failed. Error code: ' . $file['error'];
            $messageType = 'error';
        } elseif (!is_uploaded_file($file['tmp_name'])) {
            $message = 'The submitted file is not a valid uploaded file.';
            $messageType = 'error';
        } elseif ($file['size'] <= 0 || $file['size'] > $maxFileSize) {
            $message = 'File size is invalid. Maximum allowed size is 5 MB.';
            $messageType = 'error';
        } else {
            $originalName = $file['name'];
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            if (!array_key_exists($extension, $allowedTypes)) {
                $message = 'File extension is not allowed. Only JPG, PNG, and PDF files are accepted.';
                $messageType = 'error';
            } else {
                $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
                $actualMimeType = finfo_file($fileInfo, $file['tmp_name']);
                finfo_close($fileInfo);

                if ($actualMimeType !== $allowedTypes[$extension]) {
                    $message = 'File content does not match its extension. The file was rejected.';
                    $messageType = 'error';
                } else {
                    try {
                        $safeFileName = bin2hex(random_bytes(16)) . '.' . $extension;
                        $destination = $uploadDirectory . DIRECTORY_SEPARATOR . $safeFileName;

                        if (move_uploaded_file($file['tmp_name'], $destination)) {
                            chmod($destination, 0640);
                            $message = 'File uploaded successfully. Safe file name: ' . $safeFileName;
                            $messageType = 'success';
                        } else {
                            $message = 'Could not move the uploaded file to the storage directory.';
                            $messageType = 'error';
                        }
                    } catch (Exception $exception) {
                        $message = 'Could not generate a secure file name.';
                        $messageType = 'error';
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure File Upload</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        form { border: 1px solid #ccc; padding: 20px; border-radius: 8px; }
        button { margin-top: 15px; padding: 10px 18px; cursor: pointer; }
        .success { color: green; }
        .error { color: #b00020; }
    </style>
</head>
<body>
    <h2>Secure File Upload System</h2>
    <p>Allowed formats: JPG, PNG, PDF. Maximum size: 5 MB.</p>

    <?php if ($message !== ''): ?>
        <p class="<?php echo htmlspecialchars($messageType, ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
        </p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="uploaded_file" accept=".jpg,.jpeg,.png,.pdf" required>
        <br>
        <button type="submit">Upload File</button>
    </form>
</body>
</html>
