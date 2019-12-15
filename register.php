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
                <form class="login100-form validate-form" onsubmit="passEncrypt()" action="?register=1" method="post">
                    <span class="login100-form-title p-b-20">
                        Registrierung
                    </span>
                    <span>
                        <?php 
                            if(isset($message)) {
                                echo $message;}
                        ?>
                    </span>
                    <div class="wrap-input100 validate-input" data-validate="E-Mail Adresse benötigt! (ab@c.xyz)">
                        <input class="input100" type="email" name="email" placeholder="E-Mail">
                        <span class="focus-input100-1"></span>
                        <span class="focus-input100-2"></span>
                    </div>
                    <div class="wrap-input100 validate-input m-t-5" data-validate="Vorname benötigt!">
                        <input class="input100" type="text" name="vorname" placeholder="Vorname">
                        <span class="focus-input100-1"></span>
                        <span class="focus-input100-2"></span>
                    </div>
                    <div class="wrap-input100 validate-input m-t-5" data-validate="Nachname benötigt!">
                        <input class="input100" type="text" name="nachname" placeholder="Nachname">
                        <span class="focus-input100-1"></span>
                        <span class="focus-input100-2"></span>
                    </div>
                    <div class="wrap-input100 rs1 validate-input m-t-5" data-validate="Passwort benötigt!">
                        <input class="input100" id="passwort" type="password" placeholder="Passwort">
                        <span class="focus-input100-1"></span>
                        <span class="focus-input100-2"></span>
                    </div>
                    <div class="wrap-input100 rs1 validate-input m-t-5" data-validate="Passwort wiederholen!">
                        <input class="input100" id="passwort2" type="password" placeholder="Passwort wiederholen">
                        <span class="focus-input100-1"></span>
                        <span class="focus-input100-2"></span>
                    </div>
                    <div class="container-login100-form-btn m-t-15">
                        <input class="login100-form-btn" type="submit" value="Registrieren">
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
    if(isset($_GET['register'])) {
        $error = false;
        $email = $_POST['email'];
        $vorname = $_POST['vorname'];
        $nachname = $_POST['nachname'];
        $hashedPass = $_REQUEST['hashedPass'];
        if(!$error) { 
            $statement = $pdo->prepare("SELECT * FROM benutzer WHERE email = :email");
            $result = $statement->execute(array('email' => $email));
            $user = $statement->fetch();
            
            if($user !== false) {
                $message = 'Diese E-Mail-Adresse ist bereits vergeben';
                $error = true;
            }    
        }
    
        if(!$error) {
            $salz =  uniqid(mt_rand(),true);
            $passwort_saltedhash = hash('sha512',$hashedPass.$salz);
            $statement = $pdo->prepare("INSERT INTO benutzer (email, passwort, salz, vorname, nachname) VALUES (:email, :passwort, :salz, :vorname, :nachname)");
            $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_saltedhash, 'salz' => $salz, 'vorname' => $vorname, 'nachname' => $nachname));
            debug_to_console($hashedPass);
            debug_to_console($salz);
            debug_to_console($passwort_saltedhash);
            if($result) {        
                $message = 'Sie wurden erfolgreich registriert. <a class="txt2 hov1" href="index.php"><br>Zum Login</a>';
                $betreff = "Registrierung TheJuiceBox";
                $from = "From: TheJuiceBox <noreply@thejuicebox.de>";
                $text = "Sie wurden erfolgreich registriert.";
                // $email = "ohb75688@eveav.com";
                mail($email, $betreff, $text, $from);
            } else {
                $message = 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
            }
        } 
    }
    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
?>