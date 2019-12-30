<?php
//print_r($_POST);
session_start();
if(empty($_SESSION["userid"]))
{
    header("Location: index.php");
}

if(isset($_POST) && !empty($_POST)){
    $_SESSION["basket"] = $_POST;
    
    if(!empty($_SESSION["basket"]["action"])) 
    {
        if($_SESSION["basket"]["action"]=="2")
        {
            header("Location: bestaetigung.php");
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
  <!-- Sonstige Settings -->
  <script src="js/logged_in.js"></script>
  <link rel="stylesheet" href="css/warenkorb.css">
</head>
<body>
<header>
  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <a class="navbar-brand" href="main.php"><img src="images/icon/smoothie512.png" width="35" height="35" alt=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="warenkorb.php">Warenkorb</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="bestellungen.php">Meine Bestellungen</a>
      </li>
    </ul>
    
    <a class="btn btn-outline-primary" href="logout.php" role="button">Logout</a>     
  </span>
  </nav>
</header> <!-- Ende der Navigation und Willkomens-Label  -->
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
<footer>
  <div class="logged-in-text">
    <span id="logged_in"></span>&nbsp;<br>
  </div>
</footer>
</body>
</html>