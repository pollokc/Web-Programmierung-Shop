<?php
  session_start();
  if(empty($_SESSION["userid"]))
  {
    header("Location: index.php");
    die();
  }
  $pdo = new PDO('mysql:host=localhost;dbname=thejuicebox', 'root', '');
  $statement = $pdo->prepare("SELECT * FROM produkt");
  $statement->execute();
  $products = $statement->fetchAll();
  $statement = $pdo->prepare("SELECT * FROM benutzer WHERE id = :id");
  $statement->execute(array('id' => $_SESSION['userid']));
  $user = $statement->fetch();
  if (isset($_GET['action']) and $_GET['action']=='addCart') {
    $userid = $_SESSION["userid"];
    $productid = $_GET['id'];
    $getWarenkorb = $pdo->prepare("SELECT * FROM warenkorb WHERE benutzerid = :user AND produktid = :product");
    $getWarenkorb->execute(array('user' => $userid, 'product' => $productid));
    $warenkorb = $getWarenkorb->fetch();
    if(!empty($warenkorb)){
      $menge = $warenkorb['menge'];
      $menge++;
      $insertProduct = $pdo->prepare("UPDATE `warenkorb` SET `menge`= :menge WHERE benutzerid = :user AND produktid = :product");
      $insertProduct->execute(array('menge' => $menge, 'user' => $userid, 'product' => $productid));
    }
    else{
      $insertProduct = $pdo->prepare("INSERT INTO `warenkorb`(`benutzerid`, `produktid`, `menge`) VALUES (:user,:product,1)");
      $insertProduct->execute(array('user' => $userid, 'product' => $productid));
    }
    if(isset($_GET['fast'])){
      header("Location: warenkorb.php");
      die();
    }
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
    <!-- Sonstige Settings -->
    <script src="js/logged_in.js"></script>
    <link rel="stylesheet" href="css/main.css">
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
        </div>     
      </nav>
      <div class="welcome-Text">
        Herzlich Willlkommen <?php echo $user['vorname'].' '.$user['nachname'] ?>! Zuletzt online <?php echo date('d.m.Y', strtotime($user['last_login'])) ?> 
      </div>
    </header> <!-- Ende der Navigation und Willkomens-Label  -->
    <main>
      <div id="carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="images/carousel/smoothie1.jpg">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="images/carousel/smoothie2.jpg">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="images/carousel/smoothie3.jpg">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="images/carousel/smoothie4.jpg">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="images/carousel/smoothie5.jpg">
          </div>
        </div>
      </div>
      <center>
        <a class="btn btn-primary m-5" id="scrolldownAction" href="#produktuebersicht">
          <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
          Zu den Produkten
        </a>
        <script src="js/scrolldown.js"></script>
        <div class="container-fluid" id="produktuebersicht">
          <div class= "row d-inline-flex">
            <?php foreach ($products as $product): ?>
              <div class="col-sm mb-5">
                <div class="card">
                  <div class="card-image">
                    <img src="images/products/product<?php echo $product["id"]?>.png" class="card-img-top">
                  </div>
                  <div class="card-body">
                    <h5 class="card-title"><?php echo $product["hersteller"].' '.$product["produktname"]?></h5>
                    <p class="card-text"><?php echo $product["beschreibung"]?></p>
                    <p class="card-text price-text"><?php echo $product["preis"] ?>€</p>
                    <div class="card-buttons">
                      <a class="btn btn-outline-primary mt-3" href="?action=addCart&id=<?php echo $product["id"] ?>&fast=true">Jetzt bestellen!</a>
                      <a class="btn btn-outline-secondary mt-3" href="?action=addCart&id=<?php echo $product["id"] ?>">Warenkorb hinzufügen!</a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </center>
    </main>
    <footer>
      <div class="logged-in-text">
        <span id="logged_in"></span>&nbsp;<br>
      </div>
    </footer>
  </body>
</html>