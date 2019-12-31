<?php
    if(empty($_SESSION["userid"]))
    {
        header("Location: index.php");
    }
    include 'warenkorb.php';
    $userid = $_SESSION["userid"];
    $name = $_POST["name"];
    $anschrift = $_POST["anschrift"];
    $plz = $_POST["plz"];
    $stadt = $_POST["stadt"];
    $strasse = $_POST["strasse"];
    $express = 0;
    $summe = $gesamtSumme;
    if(!empty($_POST["expressCheck"])) 
    { 
        $express = 1;
    }

    $pdo = new PDO('mysql:host=localhost;dbname=thejuicebox', 'root', '');
    $produktStatement = $pdo->prepare("SELECT * FROM `produkt`");
    $produktStatement->execute();
    $products = $produktStatement->fetchAll();
    $warenkorb = $pdo->prepare("SELECT * FROM `warenkorb` WHERE benutzerid = :id;");
    $warenkorb->execute(array('id' => $_SESSION['userid']));
    $userWarenkorb = $warenkorb->fetchAll();

    if(!empty($userWarenkorb) and !empty($products)){
        $insertOrder = $pdo->prepare("INSERT INTO `bestellung`(`benutzerid`, `expresslieferung`, `bestelldatum`, `summe`, `vornachname`, `zusatzinfo`, `strasse`, `plz`, `ort`) VALUES (:id,:express,:datum,:summe,:vornachname,:info,:strasse,:plz,:ort);");
        $insertOrder->execute(array(
            'id' => $userid,
            'express' => $express,
            'datum' => date("Y-m-d H:i:s"),
            'summe' => $summe,
            'vornachname' => $name,
            'info' => $anschrift,
            'strasse' => $strasse,
            'plz' => $plz,
            'ort' => $stadt
            ));
        $bestellungid = $pdo->lastInsertId();
        foreach($userWarenkorb as $warenkorbProduct){
            $inserOrderProducts = $pdo->prepare("INSERT INTO `bestellung_hat_produkte`(`bestellungid`, `produktid`, `menge`) VALUES (:bestellungid,:produktid,:menge);");
            $inserOrderProducts->execute(array(
                'bestellungid' => $bestellungid,
                'produktid' => $warenkorbProduct["produktid"],
                'menge' => $warenkorbProduct["menge"]
            ));
        }
        $deleteWarenkorb = $pdo->prepare("DELETE FROM `warenkorb` WHERE benutzerid = :id;");
        $deleteWarenkorb->execute(array('id' => $_SESSION['userid']));

        header("Location: main.php");
        die();
    }
    else{
        header("Location: warenkorb.php");
        die();
    }
?>