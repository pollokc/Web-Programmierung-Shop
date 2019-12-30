<?php
//print_r($_POST);
session_start();
if(empty($_SESSION["userid"]))
{
    header("Location: http://localhost/Web-Programmierung-Shop/index.php");
}

if(isset($_POST) && !empty($_POST)){
    $_SESSION["basket"] = $_POST;
    
    if(!empty($_SESSION["basket"]["action"])) 
    {
        if($_SESSION["basket"]["action"]=="2")
        {
            header("Location: http://localhost/Web-Programmierung-Shop/bestaetigung.php");
            exit();
        }
    }
}


$pdo = new PDO('mysql:host=localhost;dbname=thejuicebox', 'root', '');
$statement = $pdo->prepare("SELECT * FROM produkt");
    $result = $statement->execute();
    $products = $statement->fetchAll();

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

    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">The Juice Box</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <ul class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <ul class="navbar-nav  mr-auto mt-2 mt-lg-0">
      <a class="nav-item nav-link" href="main.php">Home</a>
      <a class="nav-item nav-link active" href="warenkorb.php">Warenkorb<span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="meineBestellungen.php">Meine Bestellungen</a>         
    </ul>
    <div class="form-inline my-2 my-lg-0">
      Aktuell sind &nbsp; <span id="logged_in"></span> &nbsp; Benutzer online &nbsp;
      <a class="btn btn-outline-danger my-2 my-sm-0" href="logout.php" role="button">Logout</a>
    </div>
  </div>
</nav>
<form action="" method="post">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Smoothie</th>
      <th scope="col">Einzelpreis</th>
      <th scope="col">Anzahl</th>
      <th scope="col">Gesamtpreis</th>
    </tr>
  </thead>
  <tbody>
      <?php $summe = 0;  ?>
  <?php foreach ($products as $product): ?>
    <tr>
      <th scope="row"><?php echo $product["produktname"]?></th>
      <td><?php echo $product["preis"]?></td>
      <td><input type="number" min="0" max="100" class="form-control mb-2 mr-sm-2" value="<?php echo $_SESSION["basket"][$product["id"]]?>" name="<?php echo $product["id"]?>"></td>
      <td>
          <?php

          if(empty($_SESSION["basket"][$product["id"]]))
          {
              echo "0.00 €";
          } else {
              $summe += $product["preis"] * $_SESSION["basket"][$product["id"]];
              echo $product["preis"] * $_SESSION["basket"][$product["id"]] . " €";
          }
          ?>
          </td>
    </tr>
    <?php endforeach; ?> 
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="form-check">
        <input class="form-check-input" type="checkbox" name="express" <?php if(!empty($_SESSION["basket"]["express"])): ?>checked <?php endif; ?>> 
        <label class="form-check-label" for="defaultCheck1">
            Express-Versand (zzgl. 5 €)
        </label>
        </div>
        <small>Ist Express nicht angekreuzt, <br> wird die Bestellung normal veschickt</small>
    </td>
    </tr>

    <tr>
        <td></td>
        <td></td>
        <td>Total: </td>
        <td><?php 
        if(!empty($_SESSION["basket"]["express"]))
        {
            if($_SESSION["basket"]["express"]== "on")
            {
                $summe += 5;
            }
        }
            echo $summe . "€"?>
        </td>
    </tr>

    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td><button type="submit" class="btn btn-secondary" name="action" value="1">Aktualisieren</button></td>
    </tr>

    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td><button type="submit" class="btn btn-danger"name="action" value="2">Jetzt bestellen</button></td>
    </tr>
    
  </tbody>

</table>
    
</form>

    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <script src="js/main.js"></script>
    <script src="js/probe.js"></script>
    <script src="js/logged_in.js"></script>
    <script src="js/scrolldown.js"></script>


</body>
</html>