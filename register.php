<!-- Überprüfung ob Passwort 1 und 2 gleich sind. -->
<?php
    session_start();
    if(!empty($_SESSION["userid"]))
    {
        header("Location: main.php");
    }
    $pdo = new PDO('mysql:host=localhost;dbname=thejuicebox', 'root', '');
    if(isset($_GET['register'])) {
        //Post Daten auslesen
        $email = $_POST['email'];
        $vorname = $_POST['vorname'];
        $nachname = $_POST['nachname'];
        $hashedPass = $_POST['hashedPass'];
        $error = false;
        //SQL get benutzer mit übergegebener Email
        $statement = $pdo->prepare("SELECT * FROM benutzer WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();
        //Überprüfen ob Nutzer bereits angemeldet ist
        if($user !== false) {
            $errorMessage = 'Diese E-Mail-Adresse ist bereits vergeben!';
            $error = true;
        }    
        if(!$error) {
            //Passwort mit Salz hashen
            $salz =  uniqid(mt_rand(),true);
            $passwort_saltedhash = hash('sha512',$hashedPass.$salz);
            //Variablen erstellen für Datum
            $created_at = $last_login = date('Y-m-d H:i:s', time());

            //SQL insert neuer Benutzer
            $statement = $pdo->prepare("INSERT INTO benutzer (email, passwort, salz, vorname, nachname, last_login, created_at) VALUES (:email, :passwort, :salz, :vorname, :nachname, :last_login, :created_at)");
            $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_saltedhash, 'salz' => $salz, 'vorname' => $vorname, 'nachname' => $nachname, 'last_login' => $last_login, 'created_at' => $created_at));
            //Nutzer über Status benachrichtigen
            if($result) {        
                $message = 'Sie wurden erfolgreich registriert. <br><a style="color: #000000;" href="http://localhost/Web-Programmierung-Shop/index.php">Zum Login</a>';
                include "emailsenden.php";
                senden($email, "Registrierungsbestätigung", $message);

            } else {
                $errorMessage = 'Beim Abspeichern ist leider ein Fehler aufgetreten!';
            }
        } 
    }
?>
<!DOCTYPE html>
<html lang="en">
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
</head>
<body>
    <!-- Clientside Hashing -->
    <script type="text/javascript">
        function passEncrypt() {
            var hashedPassword = SHA512(document.getElementById("passwort").value);
            document.getElementById("hashedPass").value = hashedPassword;
        } 
    </script>
    <div class="loginBody">
        <div class="modal-dialog text-center">
            <div class="col-sm-8 main-section">
                <div class="modal-content">
                    <div class="col-12 icon-img ">
                        <img src="images/icon/smoothie512.png">
                    </div>
                    <form class="col-12" onsubmit="passEncrypt()" action="?register=1" method="post">
                        <div class="form-group error">
                                <?php 
                                    if(isset($errorMessage)) {
                                        echo $errorMessage;}
                                ?>
                        </div>
                        <div class="form-group success">
                            <?php 
                                if(isset($message)) {
                                    echo $message;}
                            ?>
                        </div>
                        <div class="form-group">
                            <input type="email"  class="form-control" name="email" placeholder="E-Mail eintragen" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="vorname" placeholder="Vorname eintragen" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="nachname" placeholder="Nachname eintragen" required>
                        </div>
                        <div class="form-group">
                            <input type="password"  class="form-control" id="passwort" placeholder="Passwort eintragen" required oninput="checkPasswort()">
                        </div>
                        <div class="form-group">
                            <input type="password"  class="form-control" id="passwort2" placeholder="Passwort wiederholen" required oninput="checkPasswort()">
                        </div>
                        <script type='text/javascript'>
                            function checkPasswort() {
                                try{
                                    var passwort = document.getElementById('passwort');
                                    var passwort2 = document.getElementById('passwort2')
                                    if (passwort.value != passwort2.value) {
                                        passwort2.setCustomValidity('Passwörter stimmen nicht überein!');
                                    } else {
                                        passwort2.setCustomValidity('');
                                    }
                                }
                                catch(e){
                                    console.log(e);
                                }
                                
                            }
                        </script>
                        <button type="submit" class="btn">Registrieren</button>
                        <div class="col-12 register-login">
                            <a href="index.php">Bereits registriert? Login</a>
                        </div>
                        <input name="hashedPass" id="hashedPass" type="hidden" value="0"/>
                    </form>
                </div> <!-- Ende von Content -->
            </div>
        </div>
    </div>
</body>
</html>