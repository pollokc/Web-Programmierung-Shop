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
  $userBestellung = array_reverse($userBestellung);
  if(!empty($userBestellung))  //Überprüfen ob user überhaupt Waren gekauft hat
  {
    $produktStatement = $pdo->prepare("SELECT * FROM `produkt`");
    $produktStatement->execute();
    $products = $produktStatement->fetchAll();
  }
  if (isset($_GET['action']) and $_GET['action']=='reorder') {
    $orderid = $_GET['id'];
    $count = count($userBestellung);
    $reorder;
    foreach($userBestellung as $bestellung){
      if($bestellung["id"] == $orderid){
        $reorder = $bestellung;
      }
    }
    $insertOrder = $pdo->prepare("INSERT INTO `bestellung`(`benutzerid`, `expresslieferung`, `bestelldatum`, `summe`, `vornachname`, `zusatzinfo`, `strasse`, `plz`, `ort`) VALUES (:id,:express,:datum,:summe,:vornachname,:info,:strasse,:plz,:ort);");
        $insertOrder->execute(array(
            'id' => $reorder["benutzerid"],
            'express' => $reorder["expresslieferung"],
            'datum' => date("Y-m-d H:i:s"),
            'summe' => $reorder["summe"],
            'vornachname' => $reorder["vornachname"],
            'info' => $reorder["zusatzinfo"],
            'strasse' => $reorder["strasse"],
            'plz' => $reorder["plz"],
            'ort' => $reorder["ort"]
            ));
    $newid = $pdo->lastInsertId();
    $oldorderStatement = $pdo->prepare("SELECT * FROM `bestellung_hat_produkte` WHERE bestellungid = :id;");
    $oldorderStatement->execute(array('id' => $reorder["id"]));
    $oldorderProducts = $oldorderStatement->fetchAll();
    foreach($oldorderProducts as $orderProduct){
      $inserOrderProducts = $pdo->prepare("INSERT INTO `bestellung_hat_produkte`(`bestellungid`, `produktid`, `menge`) VALUES (:bestellungid,:produktid,:menge);");
      $inserOrderProducts->execute(array(
          'bestellungid' => $newid,
          'produktid' => $orderProduct["produktid"],
          'menge' => $orderProduct["menge"]
      ));
    }
    header("Location: bestellungen.php?action=ordersuccess");
    die();
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
    if (isset($_GET['action']) and $_GET['action']=='ordersuccess')
    {
      echo "<div class='alert alert-success' role='alert'>
      Ihre Bestellung wurde erfolgreich erneut aufgegeben!
      </div>";
    }
  if(!empty($userBestellung)):
    foreach($userBestellung as $bestellung):
    
      $bestellid = $bestellung["id"];
      $bestellsumme = $bestellung["summe"];
      $bestelldatum = $bestellung["bestelldatum"];
      $lieferArt = "Standardlieferung";
      if($bestellung["expresslieferung"] == 1) 
      { 
        $lieferArt = "Expresslieferung";
      }
      $bestellungPositionenStatement = $pdo->prepare("SELECT * FROM `bestellung_hat_produkte` WHERE bestellungid = :id;");
      $bestellungPositionenStatement->execute(array('id' => $bestellid));
      $bestellPositionen = $bestellungPositionenStatement->fetchAll();
      //."<br>";
      ?>
      <div class="order-container">
        <table class="table">
          <tr>
            <th>Bestellung aufgegeben<br><?php echo date('d.m.Y', strtotime($bestelldatum)) ?><br><br><a class="btn btn-outline-primary" href="?action=reorder&id=<?php echo $bestellid ?>">Nochmals kaufen</a></th>
            <th>Summe:<br><?php echo $bestellsumme?> €</th>
            <th>Bestellnr.:<br><?php echo $bestellid."<br><br>"."Versandart:<br>".$lieferArt?></th>
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
              <td class="table-cell-20"><?php echo $products[$position["produktid"]-1]["hersteller"]." ".$products[$position["produktid"]-1]["produktname"]?></td>
              <td class="table-cell-10"><?php echo $products[$position["produktid"]-1]["preis"] ?> €</td>
              <td class="table-cell-10"><?php echo $position["menge"] ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
      <?php endforeach; else: ?>
          <center>
            <p class="mt-5">Sie haben noch keine Bestellungen aufgegeben!</p>
            <a class="btn btn-primary mb-5 mt-3" href="main.php">Zu den Produkten</a>
          </center>
      <?php endif; ?>
        
      
</main>
<footer>
  <div class="logged-in-text">
    <span id="logged_in"></span>&nbsp;<br>
  </div>
</footer>
</body>
</html>