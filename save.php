<?php

require 'db.php';
require 'functions.php';

$url = trim($_POST['url']);

if (empty($url)) {
    die("URL cannot be empty");
}

if (!isValidURL($url)) {
    die("Invalid URL format");
}

$ip = getClientIP();

$stmt = $conn->prepare("
    SELECT COUNT(*) as total FROM requests 
    WHERE ip = ? 
    AND TIMESTAMPDIFF(SECOND, request_time, NOW()) <= 60
");

$stmt->bind_param("s", $ip);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($data['total'] >= 4) {
    die("Too many requests. Try later.");
}

$stmt = $conn->prepare("INSERT INTO requests (ip, request_time) VALUES (?, NOW())");
$stmt->bind_param("s", $ip);
$stmt->execute();

$custom = trim($_POST['custom']);
$days = $_POST['expiry'];


$existing = $conn->prepare("SELECT short_code FROM urls WHERE long_url=?");
$existing->bind_param("s", $url);
$existing->execute();

$result = $existing->get_result();
$existing_row = $result->fetch_assoc();

if ($existing_row && empty($custom)) {
    echo "Short URL: " . $existing_row['short_code'];
    exit;
}

if (!empty($custom)) {

    if (!preg_match('/^[a-zA-Z0-9]{3,10}$/', $custom)) {
        die("Invalid custom code (only letters & numbers, 3-10 chars)");
    }

    $custom = strtolower($custom);

    $check = $conn->prepare("SELECT long_url FROM urls WHERE short_code=?");
    $check->bind_param("s", $custom);
    $check->execute();

    $result = $check->get_result();
    $row = $result->fetch_assoc();

    if ($row) {

        if ($row['long_url'] == $url) {
            $short_code = $custom;
        } else {
            die("Custom code already in use");
        }
    } else {
        $short_code = $custom;
    }
} else {

    do {
        $short_code = generateCode();

        $check = $conn->prepare("SELECT id FROM urls WHERE short_code=?");
        $check->bind_param("s", $short_code);
        $check->execute();

        $result = $check->get_result();

    } while ($result->fetch_assoc());
}

if (!empty($days) && $days > 0) {
    $expiry_date = date("Y-m-d H:i:s", strtotime("+$days days"));
} else {
    $expiry_date = NULL;
}


$stmt = $conn->prepare("
    INSERT INTO urls (long_url, short_code, expires_at) 
    VALUES (?, ?, ?)
");

$stmt->bind_param("sss", $url, $short_code, $expiry_date);
$stmt->execute();

echo "Short URL: <a href='redirect.php?code=$short_code'>$short_code</a>";