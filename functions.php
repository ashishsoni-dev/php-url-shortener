<?php

function generateCode() {
    return substr(md5(uniqid()), 0, 6);
}

function isValidURL($url) {
    return filter_var($url, FILTER_VALIDATE_URL);
}

function getClientIP() {
    return $_SERVER['REMOTE_ADDR'];
}

?>