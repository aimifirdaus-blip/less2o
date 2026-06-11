<?php

header('Content-Type: text/plain');

$headers = [
    'REMOTE_ADDR',
    'HTTP_X_FORWARDED_FOR',
    'HTTP_X_REAL_IP',
    'HTTP_CF_CONNECTING_IP',
    'HTTP_TRUE_CLIENT_IP',
    'HTTP_FORWARDED',
];

foreach ($headers as $h) {
    echo $h . ' = ' . ($_SERVER[$h] ?? 'NOT SET') . PHP_EOL;
}