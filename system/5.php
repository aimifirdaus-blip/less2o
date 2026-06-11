<?php
/**
 * Advanced Bot Protection System - Module 5
 * Advanced IP Analysis & Range Blocking
 * Version: 2.1
 */

// استخدام الدوال من الملفات السابقة
if (!function_exists('blockSuspiciousRequest')) {
    function blockSuspiciousRequest($ip, $reason) {
        logSecurityEvent($ip, $reason);
        showAccessDenied();
    }
}

if (!function_exists('logSecurityEvent')) {
    function logSecurityEvent($ip, $reason) {
        $timestamp = date('Y-m-d H:i:s');
        $log_entry = "[{$timestamp}] IP_BLOCK - IP: {$ip} | Reason: {$reason}" . PHP_EOL;
        @file_put_contents('security_audit.log', $log_entry, FILE_APPEND | LOCK_EX);
    }
}

if (!function_exists('showAccessDenied')) {
    function showAccessDenied() {
        header('HTTP/1.1 403 Forbidden');
        header('Content-Type: text/html; charset=utf-8');
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Access Restricted</title>
            <style>
                body { font-family: Arial, sans-serif; background: #f8f9fa; color: #333; text-align: center; padding: 50px; }
                .container { max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
                h1 { color: #dc3545; margin-bottom: 20px; }
                p { margin-bottom: 20px; line-height: 1.6; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>🛡️ IP Blocked</h1>
                <p>Your IP address has been blocked by our security system.</p>
                <p>This may be due to suspicious activity from your network.</p>
            </div>
        </body>
        </html>';
        exit;
    }
}

// دالة للتحقق من نطاقات IP (CIDR) - يجب أن تكون موجودة
if (!function_exists('ipInRange')) {
    function ipInRange($ip, $cidr) {
        if (strpos($cidr, '/') === false) {
            // إذا كان عنوان IP فردي بدون mask
            return $ip === $cidr;
        }
        
        list($subnet, $mask) = explode('/', $cidr);
        $mask = intval($mask);
        
        if ($mask < 0 || $mask > 32) {
            return false;
        }
        
        $ip_long = ip2long($ip);
        $subnet_long = ip2long($subnet);
        
        if ($ip_long === false || $subnet_long === false) {
            return false;
        }
        
        $mask_long = -1 << (32 - $mask);
        return ($ip_long & $mask_long) === ($subnet_long & $mask_long);
    }
}

// دالة للتحقق من IP في قائمة CIDR
if (!function_exists('checkIPInRanges')) {
    function checkIPInRanges($ip, $ranges) {
        foreach ($ranges as $range) {
            if (ipInRange($ip, $range)) {
                return $range;
            }
        }
        return false;
    }
}

// بيانات العميل
$client_info = [
    'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
    'hostname' => @gethostbyaddr($_SERVER['REMOTE_ADDR']) ?: 'Unknown'
];

// قوائم الحظر المتقدمة لنطاقات IP
$advanced_ip_blocks = [
    // نطاقات Tor
    'tor_ranges' => [
        '176.10.99.200/32', '185.220.100.0/24', '185.220.101.0/24',
        '195.176.3.0/24', '199.249.230.0/24', '204.13.164.0/24'
    ],
    
    // نطاقات VPN مشهورة
    'vpn_ranges' => [
        '185.159.157.0/24', '185.159.156.0/24', '103.245.182.0/24',
        '45.95.147.0/24', '185.104.184.0/24', '192.42.116.0/24'
    ],
    
    // نطاقات سحابية خطيرة
    'malicious_cloud' => [
        '45.95.0.0/16', '185.104.0.0/16', '192.36.0.0/16',
        '62.210.0.0/16', '195.154.0.0/16', '51.158.0.0/16'
    ],
    
    // نطاقات معروفة للهجمات
    'attack_ranges' => [
        '5.188.0.0/16', '5.189.0.0/16', '23.129.64.0/24',
        '45.9.0.0/16', '91.240.0.0/16', '185.142.0.0/16'
    ],
    
    // عناوين IP فردية خطيرة
    'single_malicious_ips' => [
        '62.210.13.58', '185.104.186.168', '192.36.27.7',
        '45.95.147.200', '185.104.184.68', '5.188.206.10'
    ]
];

// فحوصات IP المتقدمة
try {
    $client_ip = $client_info['ip_address'];
    
    // الفحص 1: نطاقات Tor
    $tor_range = checkIPInRanges($client_ip, $advanced_ip_blocks['tor_ranges']);
    if ($tor_range) {
        blockSuspiciousRequest($client_ip, "Tor network detected: {$tor_range}");
    }
    
    // الفحص 2: نطاقات VPN
    $vpn_range = checkIPInRanges($client_ip, $advanced_ip_blocks['vpn_ranges']);
    if ($vpn_range) {
        blockSuspiciousRequest($client_ip, "VPN network detected: {$vpn_range}");
    }
    
    // الفحص 3: نطاقات سحابية خبيثة
    $cloud_range = checkIPInRanges($client_ip, $advanced_ip_blocks['malicious_cloud']);
    if ($cloud_range) {
        blockSuspiciousRequest($client_ip, "Malicious cloud range: {$cloud_range}");
    }
    
    // الفحص 4: نطاقات هجومية معروفة
    $attack_range = checkIPInRanges($client_ip, $advanced_ip_blocks['attack_ranges']);
    if ($attack_range) {
        blockSuspiciousRequest($client_ip, "Known attack range: {$attack_range}");
    }
    
    // الفحص 5: عناوين IP فردية خطيرة
    if (in_array($client_ip, $advanced_ip_blocks['single_malicious_ips'])) {
        blockSuspiciousRequest($client_ip, "Known malicious IP: {$client_ip}");
    }
    
    // الفحص 6: IPs محجوزة ومحلية
    if (filter_var($client_ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE) === false) {
        blockSuspiciousRequest($client_ip, "Private/reserved IP range: {$client_ip}");
    }
    
    // الفحص 7: IPs غير صالحة
    if (!filter_var($client_ip, FILTER_VALIDATE_IP)) {
        blockSuspiciousRequest($client_ip, "Invalid IP address: {$client_ip}");
    }
    
} catch (Exception $e) {
    error_log("Advanced IP analysis error: " . $e->getMessage());
}

// دالة مساعدة للتحقق من نوع IP
if (!function_exists('getIPType')) {
    function getIPType($ip) {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return 'Invalid';
        }
        
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return 'IPv4';
        }
        
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return 'IPv6';
        }
        
        return 'Unknown';
    }
}

// تسجيل معلومات IP للتحليل
$ip_type = getIPType($client_info['ip_address']);
logSecurityEvent($client_info['ip_address'], 
    "IP analysis - Type: {$ip_type}, Hostname: {$client_info['hostname']}");

?>