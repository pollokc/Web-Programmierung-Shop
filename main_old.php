<body>



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




    

</body>
</hmtl>
