<?php
session_start();
if(empty($_SESSION["userid"]))
{
    header("Location: index.php");
}

$pdo = new PDO('mysql:host=localhost;dbname=thejuicebox', 'root', '');
    $warenkorb = $pdo->prepare("SELECT * FROM `warenkorb` WHERE benutzerid = :id;");
    $warenkorb->execute(array('id' => $_SESSION['userid']));
    $userWarenkorb = $warenkorb->fetchAll();

    $produktStatement = $pdo->prepare("SELECT * FROM `produkt`");
    $produktStatement->execute(array('id' => $_SESSION['userid']));
    $products = $produktStatement->fetchAll();
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
</header> <!-- Ende der Navigation  -->
<main>
  <div class="row">

    <div class="leftcolumn">
      <div class="product-table">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Smoothies</th>
              <th scope="col"></th>
              <th scope="col">Einzelpreis</th>
              <th scope="col">Anzahl</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($userWarenkorb as $product): ?>
            <tr>
              <td class="image-tablecell"><center><img src="images/products/product<?php echo $product["produktid"]?>.png" alt ="" class="produkt-img"></center></td>
              <th scope="row"><?php echo $products[$product["produktid"]-1]["hersteller"]." ".$products[$product["produktid"]-1]["produktname"]?></th>
              <td><?php echo $products[$product["produktid"]-1]["preis"]." €"?></td>
              <td><input type="number" min="0" max="100" class="form-control mb-2 mr-sm-2 number-tablecell" value="<?php echo $product["menge"]?>" name="<?php echo $product["id"]?>"></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="rightcolumn">
      <div class="checkout-form">
        <form action="" method="post">
          <div class="form-group">
            <label for="name">Vorname und Nachname</label>
            <input type="text" class="form-control" id="name">
          </div>
          <div class="form-group">
            <label for="anschrift">Anschrift</label>
            <input type="text" class="form-control" id="anschrift" placeholder="Firma, c/o, Gebäude, Zusatzinfo">
            <input type="text" class="form-control mt-1" id="straße" placeholder="Straße und Hausnummer">
          </div>
          <div class="form-group">
            <label for="plz">Postleitzahl</label>
            <input type="text" class="form-control" id="plz">
          </div>
          <div class="form-group">
            <label for="stadt">Stadt</label>
            <input type="text" class="form-control" id="stadt">
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="expressCheck">
            <label class="form-check-label" for="expressCheck">Express-Versand (zzgl. 5 €)</label>
          </div>
          <button type="submit" class="btn btn-outline-primary"name="action" value="2">Jetzt kostenpflichtig bestellen</button>
        </form> 
      </div>
    </div>

  </div>
  
  
</main>

<footer>
  <div class="logged-in-text">
    <span id="logged_in"></span>&nbsp;<br>
  </div>
</footer>
</body>
</html>