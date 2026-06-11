<?php
/**
 * Advanced Bot Protection System - Module 2
 * Geographic & Behavioral Analysis
 * Version: 2.1
 */

// استخدام الدوال من anti1.php بدلاً من التكرار
if (!function_exists('blockSuspiciousRequest')) {
    function blockSuspiciousRequest($ip, $reason) {
        logSecurityEvent($ip, $reason);
        showAccessDenied();
    }
}

if (!function_exists('logSecurityEvent')) {
    function logSecurityEvent($ip, $reason) {
        $timestamp = date('Y-m-d H:i:s');
        $log_entry = "[{$timestamp}] GEO_BLOCK - IP: {$ip} | Reason: {$reason}" . PHP_EOL;
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
                <h1>🌍 Geographic Restriction</h1>
                <p>Access from your location is not permitted.</p>
                <p>This service is restricted in certain geographic regions.</p>
            </div>
        </body>
        </html>';
        exit;
    }
}

// جمع البيانات الجغرافية المتقدمة
$client_geo = [
    'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
    'hostname' => @gethostbyaddr($_SERVER['REMOTE_ADDR']) ?: 'Unknown',
    'country' => 'Unknown',
    'asn' => 'Unknown',
    'provider' => 'Unknown'
];

// الحصول على المعلومات الجغرافية بدون مكتبات خارجية
function getGeographicInfo($ip) {
    $geo_info = [
        'country' => 'Unknown',
        'asn' => 'Unknown', 
        'provider' => 'Unknown'
    ];
    
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        return $geo_info;
    }
    
    try {
        // محاولة الحصول على المعلومات من hostname
        $hostname = @gethostbyaddr($ip);
        if ($hostname && $hostname !== $ip) {
            $geo_info['provider'] = extractProviderFromHostname($hostname);
            
            // كشف الدولة من نطاق المستوى الأعلى (TLD)
            $geo_info['country'] = detectCountryFromHostname($hostname);
        }
        
        // كشف ASN من معلومات الشبكة
        $geo_info['asn'] = detectASNFromIP($ip);
        
    } catch (Exception $e) {
        // تجاهل الأخطاء في الكشف الجغرافي
    }
    
    return $geo_info;
}

// استخراج معلومات المزود من اسم النطاق
function extractProviderFromHostname($hostname) {
    $provider_patterns = [
        'amazonaws' => 'Amazon AWS',
        'digitalocean' => 'DigitalOcean',
        'googlecloud' => 'Google Cloud',
        'azure' => 'Microsoft Azure',
        'cloudflare' => 'CloudFlare',
        'linode' => 'Linode',
        'vultr' => 'Vultr',
        'ovh' => 'OVH',
        'hetzner' => 'Hetzner',
        'alibaba' => 'Alibaba Cloud'
    ];
    
    $hostname_lower = strtolower($hostname);
    foreach ($provider_patterns as $pattern => $provider) {
        if (strpos($hostname_lower, $pattern) !== false) {
            return $provider;
        }
    }
    
    return 'Unknown Provider';
}

// كشف الدولة من نطاق المستوى الأعلى
function detectCountryFromHostname($hostname) {
    $country_tlds = [
        '.us' => 'United States', '.uk' => 'United Kingdom', '.de' => 'Germany',
        '.fr' => 'France', '.ca' => 'Canada', '.au' => 'Australia',
        '.nl' => 'Netherlands', '.ru' => 'Russia', '.br' => 'Brazil',
        '.in' => 'India', '.cn' => 'China', '.jp' => 'Japan',
        '.sg' => 'Singapore', '.ae' => 'UAE', '.sa' => 'Saudi Arabia',
        '.eg' => 'Egypt', '.za' => 'South Africa', '.tr' => 'Turkey'
    ];
    
    foreach ($country_tlds as $tld => $country) {
        if (substr($hostname, -strlen($tld)) === $tld) {
            return $country;
        }
    }
    
    return 'Unknown';
}

// كشف ASN من عنوان IP
function detectASNFromIP($ip) {
    $asn_patterns = [
        '15169' => 'Google',
        '16509' => 'Amazon',
        '14618' => 'Amazon AWS',
        '8075' => 'Microsoft',
        '13335' => 'CloudFlare',
        '14061' => 'DigitalOcean',
        '16276' => 'OVH',
        '24940' => 'Hetzner',
        '20473' => 'Choopa',
        '19281' => 'Vultr'
    ];
    
    // في الإصدار الحقيقي، يمكن استخدام API خارجي
    // هنا نعود قيمة افتراضية
    return 'AS' . rand(1000, 60000);
}

// قوائم الحظر الجغرافية
$geo_restrictions = [
    'blocked_countries' => [
        'Russia', 'China', 'North Korea', 'Iran', 'Syria',
        'Sudan', 'Cuba', 'Ukraine', 'Belarus'
    ],
    
    'high_risk_regions' => [
        'Eastern Europe', 'Middle East', 'Southeast Asia'
    ],
    
    'suspicious_asn' => [
        'AS12345', 'AS67890', 'AS15169', 'AS16509'
    ],
    
    'vpn_providers' => [
        'NordVPN', 'ExpressVPN', 'CyberGhost', 'Private Internet Access',
        'Hotspot Shield', 'Windscribe', 'Surfshark', 'VyprVPN'
    ]
];

// التحليل الجغرافي المتقدم
try {
    // الحصول على المعلومات الجغرافية
    $geo_data = getGeographicInfo($client_geo['ip_address']);
    $client_geo = array_merge($client_geo, $geo_data);
    
    // الفحص 1: الدول الممنوعة
    if (in_array($client_geo['country'], $geo_restrictions['blocked_countries'])) {
        blockSuspiciousRequest($client_geo['ip_address'], "Blocked country: {$client_geo['country']}");
    }
    
    // الفحص 2: مزودي VPN ومعروفين
    $provider_lower = strtolower($client_geo['provider']);
    foreach ($geo_restrictions['vpn_providers'] as $vpn_provider) {
        if (strpos($provider_lower, strtolower($vpn_provider)) !== false) {
            blockSuspiciousRequest($client_geo['ip_address'], "VPN/Proxy detected: {$client_geo['provider']}");
        }
    }
    
    // الفحص 3: ASN مشبوه
    if (in_array($client_geo['asn'], $geo_restrictions['suspicious_asn'])) {
        blockSuspiciousRequest($client_geo['ip_address'], "Suspicious ASN: {$client_geo['asn']}");
    }
    
    // الفحص 4: عناوين IP من مناطق عالية الخطورة
    if (in_array($client_geo['country'], ['Russia', 'China', 'Iran'])) {
        // فحوصات إضافية للمناطق عالية الخطورة
        blockSuspiciousRequest($client_geo['ip_address'], "High-risk country: {$client_geo['country']}");
    }
    
} catch (Exception $e) {
    // تسجيل الخطأ بدون إيقاف التنفيذ
    error_log("Geo analysis error: " . $e->getMessage());
}

// تسجيل البيانات الجغرافية للتحليل
logSecurityEvent($client_geo['ip_address'], 
    "Geo data - Country: {$client_geo['country']}, Provider: {$client_geo['provider']}, ASN: {$client_geo['asn']}");

?>