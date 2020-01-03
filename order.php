<?php
    session_start();
    if(empty($_SESSION["userid"]))
    {
        header("Location: index.php");
    }

    if (isset($_GET['action']))
    {
        $pdo = new PDO('mysql:host=localhost;dbname=thejuicebox', 'root', '');
        $userid = $_SESSION["userid"];
        $produktStatement = $pdo->prepare("SELECT * FROM `produkt`");
        $produktStatement->execute();
        $products = $produktStatement->fetchAll();
        if ($_GET['action']=='order') 
        {
            $name = $_POST["name"];
            $anschrift = $_POST["anschrift"];
            $plz = $_POST["plz"];
            $stadt = $_POST["stadt"];
            $strasse = $_POST["strasse"];
            $express = 0;
            if(!empty($_POST["expressCheck"])) 
            { 
                $express = 1;
            }
            $warenkorb = $pdo->prepare("SELECT * FROM `warenkorb` WHERE benutzerid = :id;");
            $warenkorb->execute(array('id' => $_SESSION['userid']));
            $userWarenkorb = $warenkorb->fetchAll();
            if(!empty($userWarenkorb) and !empty($products))
            {
                $summe = 0;
                foreach($userWarenkorb as $warenkorbProduct)
                {
                    $summe = $summe + $warenkorbProduct["menge"]*$products[$warenkorbProduct["produktid"]-1]["preis"];
                }
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
                foreach($userWarenkorb as $warenkorbProduct)
                {
                    $inserOrderProducts = $pdo->prepare("INSERT INTO `bestellung_hat_produkte`(`bestellungid`, `produktid`, `menge`) VALUES (:bestellungid,:produktid,:menge);");
                    $inserOrderProducts->execute(array(
                        'bestellungid' => $bestellungid,
                        'produktid' => $warenkorbProduct["produktid"],
                        'menge' => $warenkorbProduct["menge"]
                ));
                }
                $deleteWarenkorb = $pdo->prepare("DELETE FROM `warenkorb` WHERE benutzerid = :id;");
                $deleteWarenkorb->execute(array('id' => $_SESSION['userid']));
                include "emailsenden.php";
                bestellBestätigungSenden($userid,$bestellungid);
                header("Location: warenkorb.php?action=ordersuccess");
                die();
            }
        }
        if ($_GET['action']=='reorder') {
            $bestellungStatement = $pdo->prepare("SELECT * FROM `bestellung` WHERE benutzerid = :id;");
            $bestellungStatement->execute(array('id' => $userid));
            $userBestellung = $bestellungStatement->fetchAll();
            $userBestellung = array_reverse($userBestellung);
            if(!empty($userBestellung))  //Überprüfen ob user überhaupt Waren gekauft hat
            {
                $orderid = $_GET['id'];
                $count = count($userBestellung);
                $reorder;
                foreach($userBestellung as $bestellung)
                {
                  if($bestellung["id"] == $orderid)
                  {
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
                foreach($oldorderProducts as $orderProduct)
                {
                  $inserOrderProducts = $pdo->prepare("INSERT INTO `bestellung_hat_produkte`(`bestellungid`, `produktid`, `menge`) VALUES (:bestellungid,:produktid,:menge);");
                  $inserOrderProducts->execute(array(
                    'bestellungid' => $newid,
                    'produktid' => $orderProduct["produktid"],
                    'menge' => $orderProduct["menge"]
                ));
                }
                include "emailsenden.php";
                bestellBestätigungSenden($reorder["benutzerid"],$newid);
                header("Location: bestellungen.php?action=ordersuccess");
                die();
            }
        }
    }
?>