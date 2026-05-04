<?php

require 'db.php';


if (!isset($_GET['code']) || empty($_GET['code'])) {
    die("Invalid request");
}

$code = $_GET['code'];

if (!preg_match('/^[a-zA-Z0-9]{3,10}$/', $code)) {
    die("Invalid code");
}

$cache_file = "cache/" . $code . ".json";
$cache_time = 300;

if (file_exists($cache_file)) {

    $file_time = filemtime($cache_file);

    if (time() - $file_time < $cache_time) {

        $content = file_get_contents($cache_file);
        $data = json_decode($content, true);

        if ($data && isset($data['long_url'])) {

            if ($data['expires_at'] && strtotime($data['expires_at']) < time()) {
                unlink($cache_file);
                die("Link expired");
            }

            $stmt = $conn->prepare("UPDATE urls SET clicks = clicks + 1, last_clicked_at = NOW() WHERE short_code=?");
            $stmt->bind_param("s",$code);
            $stmt->execute();

            header("Location: " . $data['long_url']);
            exit;
        }
    } else {
        unlink($cache_file);
    }
}

$stmt = $conn->prepare("SELECT * FROM urls WHERE short_code = ?");
$stmt->bind_param("s", $code);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {

    if ($row['expires_at'] && strtotime($row['expires_at']) < time()) {
        die("Link expired");
    }
    file_put_contents($cache_file, json_encode($row));

    $stmt = $conn->prepare("UPDATE urls SET clicks = clicks + 1, last_clicked_at = NOW() WHERE short_code = ?");
    $stmt->bind_param("s", $code);
    $stmt->execute();

    header("Location: " . $row['long_url']);
    exit;
} else {
    echo "Invalid short URL";
    exit;
}
