<?php
session_start();
if(empty($_SESSION["userid"]))
{
    header("Location: http://localhost/Web-Programmierung-Shop/index.php");
}

$pdo = new PDO('mysql:host=localhost;dbname=thejuicebox', 'root', '');
$statement = $pdo->prepare("SELECT * FROM produkt");
    //$result = $statement->execute();
    $statement->execute();
    $products = $statement->fetchAll();

    $statement = $pdo->prepare("SELECT * FROM benutzer WHERE id = :id");
    $statement->execute(array('id' => $_SESSION['userid']));
    $user = $statement->fetch();
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
      <a class="nav-item nav-link active" href="geheim.php">Home <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="warenkorb.php">Warenkorb</a>
      <a class="nav-item nav-link" href="meineBestellungen.php">Meine Bestellungen</a>         
    </ul>
    <div class="form-inline my-2 my-lg-0">
      Aktuell sind &nbsp; <span id="logged_in"></span> &nbsp; Benutzer online &nbsp;
      <a class="btn btn-outline-danger my-2 my-sm-0" href="logout.php" role="button">Logout</a>
    </div>
  </div>
</nav>


<div class="alert alert-dark mb-0" role="alert" >
  <p>Herzlich Willlkommen <?php echo $user['vorname'].' '.$user['nachname'] ?>! Zuletzt online <?php echo date('d.m.Y', strtotime($user['last_login'])) ?></p>
</div>

    <div class="bd-example">
    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
        <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="3"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="4"></li>
        </ol>
        <div class="carousel-inner">
        
        <?php foreach ($products as $product): ?>
        <div class="carousel-item <?php if ($product["id"] == 1): ?> active <?php endif; ?>">
            <img src="images/carousel/smoothie<?php echo $product["id"]?>.jpg" height="80%" class="d-block w-100">
            <div class="carousel-caption d-none d-md-block">
            
            <h5 style="color:#000"><?php echo $product["produktname"]?></h5>
            <!-- <p><//?php echo $product["preis"]?></p> -->
            </div>
        </div>
        <?php endforeach; ?>

        
        </div>
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
        </a>
    </div>
    </div>


    <center>
    <a class="btn btn-danger m-4" id="PollyistderBeste" href="#produktuebersicht">
        Zu den Produkten
    </a>
    </center>

<?php $i=1 ?>
    <div class="container" id="produktuebersicht">
      <div class="row">
        <?php foreach ($products as $product): ?>
        <div class="col-sm mb-5">
            <div class="card">
        <img src="images/carousel/smoothie<?php echo $product["id"]?>.jpg" class="card-img-top">
      <div class="card-body">
          <h5 class="card-title"><?php echo $product["produktname"]?></h5>
          <p class="card-text"><?php echo $product["beschreibung"]?></p>
          <button type="button" class="btn btn-danger mt-3" data-toggle="modal" data-target="#exampleModal"> Jetzt bestellen </button>
        </div>
      </div>
        </div>
        <?php if($i%3 == 0): ?>
      </div>
      <div class="row">
        <?php endif; ?>
        <?php $i++ ?>
        <?php endforeach; ?>
  </div>
</div>


<form action="warenkorb.php" method="post">
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ihre Bestellung</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <div class="row">
  <div class="col-3">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <?php foreach ($products as $product): ?>
    <a class="nav-link<?php if ($product["id"] == 1): ?> active <?php endif; ?>" id="v-pills-<?php echo $product["id"]?>-tab" data-toggle="pill" href="#v-pills-<?php echo $product["id"]?>" role="tab" aria-controls="v-pills-<?php echo $product["id"]?>" aria-selected="<?php if ($product["id"] == 1): ?> true <?php else: ?> false <?php endif ?>"><?php echo $product["produktname"]?></a>
    <?php endforeach; ?>
    </div>
  </div>
  <div class="col-9">
    <div class="tab-content" id="v-pills-tabContent">
    <?php foreach ($products as $product): ?>
        <div class="tab-pane fade<?php if ($product["id"] == 1): ?> show active <?php endif; ?>" id="v-pills-<?php echo $product["id"]?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $product["id"]?>-tab">
        <img src="images/carousel/smoothie<?php echo $product["id"]?>.jpg" height="80%" class="w-100">
        <p class="mt-3"><?php echo $product["beschreibung"]?></p>
        <p class="mt-3">Preis: <?php echo $product["preis"]?> € </p>
        <p class="mt-3">
        <input type="number" min="0" max="100" class="form-control mb-2 mr-sm-2" placeholder="Anzahl" name="<?php echo $product["id"]?>">
        </p>
        </div>
        <?php endforeach; ?>


    </div>
  </div>
</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
        <button type="submit" class="btn btn-danger">Jetzt bestellen</button>
      </div>
    </div>
  </div>
</div>
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
</hmtl>
