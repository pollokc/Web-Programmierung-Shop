<?php
    require 'vendor/autoload.php'; 
    function senden($empfaenger, $betreff, $nachricht)
    {
        $API_KEY = "";
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("thejuiceboxwi3@gmail.com", "TheJuiceBox-WebShop");
        $email->setSubject($betreff);
        $email->addTo($empfaenger);
        $email->addContent(
            "text/html", $nachricht
        );
        $sendgrid = new \SendGrid($API_KEY);
        $response = $sendgrid->send($email);
    }

    function bestellBestätigungSenden($userid,$bestellungid)
    {
        $pdo = new PDO('mysql:host=localhost;dbname=thejuicebox', 'root', '');
        $produktStatement = $pdo->prepare("SELECT * FROM `produkt`");
        $produktStatement->execute();
        $products = $produktStatement->fetchAll();
        $userStatement = $pdo->prepare("SELECT * FROM `benutzer` WHERE id = :id;");
        $userStatement->execute(array('id' => $userid));
        $user = $userStatement->fetch();
        $bestellungStatement = $pdo->prepare("SELECT * FROM `bestellung` WHERE id = :id;");
        $bestellungStatement->execute(array('id' => $bestellungid));
        $bestellung = $bestellungStatement->fetch();
        $bestellungProdukteStatement = $pdo->prepare("SELECT * FROM `bestellung_hat_produkte` WHERE bestellungid = :id;");
        $bestellungProdukteStatement->execute(array('id' => $bestellungid));
        $bestellungProdukte = $bestellungProdukteStatement->fetchAll();
        $message = "Vielen Dank für Ihre Bestellung bei TheJuiceBox.<br>    
        <br>Bestellnr.: ".$bestellung["id"].
        "<br>Artikelkosten: ".$bestellung["summe"]." €";
        if($bestellung["expresslieferung"] == 1)
        {
            $message .= "<br>Lieferkosten: 5.00 €"
            ."<br>Gesamtkosten: ".($bestellung["summe"]+5)." €";
        }
        else
        {
            $message .= "<br>Lieferkosten: 0.00 €"
            ."<br>Gesamtkosten: ".$bestellung["summe"]." €";
        }
        

        $message .= "<br><br>Gekaufte Produkte:<br>";
        foreach($bestellungProdukte as $orderProduct)
        {
            $message .= $orderProduct["menge"]."x ".$products[$orderProduct["produktid"]-1]["produktname"]."<br>";
        }
        $message .= "<br><br>Lieferdatum: nie<br><br><br>Mit freundlichen Grüßen<br>Ihr TheJuiceBox-WebShop";
        senden($user["email"], "Versandbestätigung", $message);
    }
?>