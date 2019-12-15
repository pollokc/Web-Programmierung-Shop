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
    <script src="js/sha512Encrypt.js" type="text/javascript"></script> 
</head>
<body>
    <script type="text/javascript">
        function passEncrypt() {
            var hashedPassword = SHA512(document.getElementById("passwort").value);
            document.getElementById("hashedPass").value = hashedPassword;
        }   
    </script>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-l-45 p-r-45 p-t-40 p-b-40">
                <form class="login100-form validate-form" onsubmit="passEncrypt()" action="?login=1" method="post">
                    <span class="login100-form-title p-b-20">
                        Anmelden
                    </span>
                    <span>
                        <?php 
                            if(isset($message)) {
                                echo $message;}
                        ?>
                    </span>
                    <div class="wrap-input100 validate-input" data-validate="E-Mail Adresse benötigt! (ab@c.xyz)">
                        <input class="input100" type="email"  name="email" placeholder="E-Mail">
                        <span class="focus-input100-1"></span>
                        <span class="focus-input100-2"></span>
                    </div>
                    <div class="wrap-input100 rs1 validate-input" data-validate="Passwort benötigt!">
                        <input class="input100" type="password" id="passwort" placeholder="Passwort">
                        <span class="focus-input100-1"></span>
                        <span class="focus-input100-2"></span>
                    </div>
                    <div class="container-login100-form-btn m-t-15">
                        <input type="submit" class="login100-form-btn" value="Einloggen">
                    </div>
                    <div class="text-center">
                        <span class="txt1">
                            Account erstellen?
                        </span>
                        <a href="register.php" class="txt2 hov1">
                            Registrierung
                        </a>
                    </div>
                    <input name="hashedPass" id="hashedPass" type="hidden" value="0"/>
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
<?php 
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=thejuicebox', 'root', '');
 
if(isset($_GET['login'])) {
    $email = $_POST['email'];
    $hashedPass = $_REQUEST['hashedPass'];
    
    $statement = $pdo->prepare("SELECT * FROM benutzer WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();
        
    //Überprüfung des Passworts
    $salz =  $user['salz'];
    $passwort_saltedhash = hash('sha512',$hashedPass.$salz);
    debug_to_console($hashedPass);
    debug_to_console($salz);
    debug_to_console($passwort_saltedhash);
    if ($user !== false && $user['passwort']==$passwort_saltedhash) {
        $_SESSION['userid'] = $user['id'];
        die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
    } else {
        $message = "E-Mail oder Passwort war ungültig<br>";
    }
    
}
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
?>