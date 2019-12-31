<?php
  session_start();
  if(empty($_SESSION["userid"]))
  {
    header("Location: index.php");
    die();
  }
  $sessionID = $_SESSION['userid'];
  $pdo = new PDO('mysql:host=localhost;dbname=thejuicebox', 'root', '');
  $bestellungStatement = $pdo->prepare("SELECT * FROM `bestellung` WHERE benutzerid = :id;");
  $bestellungStatement->execute(array('id' => $sessionID));
  $userBestellung = $bestellungStatement->fetchAll();

  if(!empty($userBestellung))  //Überprüfen ob user überhaupt Waren gekauft hat
  {
    $produktStatement = $pdo->prepare("SELECT * FROM `produkt`");
    $produktStatement->execute();
    $products = $produktStatement->fetchAll();
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
  <link rel="stylesheet" href="css/bestellungen.css">
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
<?php
  if(!empty($userBestellung)):
    foreach($userBestellung as $bestellung):
    
      $bestellid = $bestellung["id"];
      $bestellsumme = $bestellung["summe"];
      $bestelldatum = $bestellung["bestelldatum"];
      $bestellungPositionenStatement = $pdo->prepare("SELECT * FROM `bestellung_hat_produkte` WHERE bestellungid = :id;");
      $bestellungPositionenStatement->execute(array('id' => $bestellid));
      $bestellPositionen = $bestellungPositionenStatement->fetchAll();
      //."<br>";
      ?>
      <div class="order-container">
        <table class="table">
          <tr>
            <th>Bestellung aufgegeben<br><?php echo $bestelldatum?><br><br><button type="button" class="btn btn-outline-primary">Nochmals kaufen</button></th>
            <th>Summe:<br><?php echo $bestellsumme?> €</th>
            <th>Bestellnr.:<br><?php echo $bestellid?></th>
            <th>
              Lieferadresse:<br>
              <?php
                echo $bestellung["vornachname"]."<br>";
                echo $bestellung["zusatzinfo"]."<br>";
                echo $bestellung["strasse"]."<br>";
                echo $bestellung["plz"]." ".$bestellung["ort"];
              ?>
            </th>
          </tr>
          <tr>
            <th>Produkt</th>
            <th></th>
            <th>Einzelpreis</th>
            <th>Menge</th>
          </tr>
          <?php foreach($bestellPositionen as $position): ?>
            <tr>
              <td class="table-cell-10"><center><img src="images/products/product<?php echo $position["produktid"]?>.png" alt ="" class="produkt-img"></center></td>
              <td class="table-cell-20"><?php echo $products[$position["produktid"]]["hersteller"]." ".$products[$position["produktid"]]["produktname"]?></td>
              <td class="table-cell-10"><?php echo $products[$position["produktid"]]["preis"] ?> €</td>
              <td class="table-cell-10"><?php echo $position["menge"] ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
      <?php endforeach; endif; ?>
        
      
</main>
<footer>
  <div class="logged-in-text">
    <span id="logged_in"></span>&nbsp;<br>
  </div>
</footer>
</body>
</html>