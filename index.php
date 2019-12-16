<?php 
    session_start();
    $pdo = new PDO('mysql:host=localhost;dbname=thejuicebox', 'root', '');
    if(isset($_GET['login'])) {
        //Post Daten auslesen
        $email = $_POST['email'];
        $hashedPass = $_POST['hashedPass'];
        debug_to_console($hashedPass);
        //SQL get benutzer mit übergegebener Email
        $statement = $pdo->prepare("SELECT * FROM benutzer WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();
        //Passwort hashen
        $salz =  $user['salz'];
        $passwort_saltedhash = hash('sha512',$hashedPass.$salz);
        //Username und Passwort abgleichen
        if ($user !== false && $user['passwort'] == $passwort_saltedhash) {
            $_SESSION['userid'] = $user['id'];
        die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
        } else {
            $error = "E-Mail oder Passwort war ungültig<br>";
        }
    }
    function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <!-- Bootstrap Abhängikeiten -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/jquery.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Default Settings -->
    <title>The Juice Box</title>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="images/icon/smoothie64.png">
    <link rel="stylesheet" href="css/default.css">
    <!-- Restliche Settings -->
    <link rel="stylesheet" href="css/indexregister.css">
    <script src="js/sha512Encrypt.js" type="text/javascript"></script>
    <!-- Clientside Hashing -->
    <script type="text/javascript">
        function passEncrypt() {
            var hashedPassword = SHA512(document.getElementById("passwort").value);
            document.getElementById("hashedPass").value = hashedPassword;
        }   
    </script>
</head>
<body>
    <div class="loginBody">
        <div class="modal-dialog text-center">
            <div class="col-sm-8 main-section">
                <div class="modal-content">
                    <div class="col-12 icon-img ">
                        <img src="images/icon/smoothie512.png">
                    </div>
                    <form class="col-12" onsubmit="passEncrypt()" action="?login=1" method="post">
                        <div class="form-group error">
                            <?php 
                                if(isset($error)) {
                                    echo $error;}
                            ?>
                        </div>
                        <div class="form-group">
                            <input type="email"  class="form-control" name="email" placeholder="E-Mail eintragen" required>
                        </div>
                        <div class="form-group">
                            <input type="password"  class="form-control" id="passwort" placeholder="Passwort eintragen" required>
                        </div>
                        <button type="submit" class="btn">Einloggen</button>
                        <div class="col-12 register-login">
                            <a href="register.php">Account erstellen? Registrierung</a>
                        </div>
                        <input name="hashedPass" id="hashedPass" type="hidden" value="0"/>
                    </form>
                </div> <!-- Ende von Content -->
            </div>
        </div>
    </div>
</body>
</html>