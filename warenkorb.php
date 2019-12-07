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
$statement = $pdo->prepare("SELECT * FROM products");
    $result = $statement->execute();
    $products = $statement->fetchAll();

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
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">The Juice Box</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="#">Home</a>
      <a class="nav-item nav-link active" href="#">Warenkorb<span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="#">Penisse</a>
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
      <th scope="row"><?php echo $product["name"]?></th>
      <td><?php echo $product["preis"]?></td>
      <td><input type="number" class="form-control mb-2 mr-sm-2" value="<?php echo $_SESSION["basket"][$product["id"]]?>" name="<?php echo $product["id"]?>"></td>
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




</body>
</html>