<?php 
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=thejuicebox', 'root', '');
 
if(isset($_GET['login'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    
    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();
        
    //Überprüfung des Passworts
    $salt =  $user['salt'];
    $passwort_hash = hash('sha512',$passwort.$salt);
    if ($user !== false && $user['passwort']==$passwort_hash) {
        $_SESSION['userid'] = $user['id'];
        die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>The Juice Box</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/smoothie64.png">
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-l-45 p-r-45 p-t-40 p-b-40">
                <form class="login100-form validate-form" action="?login=1" method="post">
                    <span class="login100-form-title p-b-20">
                        Anmelden
                    </span>
                    <span>
                        <?php 
                            if(isset($errorMessage)) {
                                echo $errorMessage;}
                        ?>
                    </span>
                    <div class="wrap-input100 validate-input" data-validate="E-Mail Adresse benötigt! (ab@c.xyz)">
                        <input class="input100" type="email" name="email" placeholder="E-Mail">
                        <span class="focus-input100-1"></span>
                        <span class="focus-input100-2"></span>
                    </div>

                    <div class="wrap-input100 rs1 validate-input" data-validate="Passwort benötigt!">
                        <input class="input100" type="password" name="passwort" placeholder="Passwort">
                        <span class="focus-input100-1"></span>
                        <span class="focus-input100-2"></span>
                    </div>

                    <div class="container-login100-form-btn m-t-15">
                        <span class="txt1">
                            <input type="checkbox">
                            Angemeldet bleiben
                        </span>
                    </div>

                    <div class="container-login100-form-btn m-t-15">
                        <input type="submit" class="login100-form-btn" value="Einloggen">

                    </div>

                    <div class="text-center p-t-10 p-b-1">
                        <a href="#" class="txt2 hov1">
                            Passwort vergessen?
                        </a>
                    </div>

                    <div class="text-center">
                        <span class="txt1">
                            Account erstellen?
                        </span>

                        <a href="register.php" class="txt2 hov1">
                            Registrierung
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <script src="js/main.js"></script>
</body>

</html>