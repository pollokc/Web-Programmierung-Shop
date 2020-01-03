<?php
require 'vendor/autoload.php'; 


function senden($empfaenger, $betreff, $nachricht)
{
    $API_KEY = "";

    $email = new \SendGrid\Mail\Mail(); 
    $email->setFrom("thejuiceboxwi3@gmail.com", "TheJuiceBox-WebShop");
    $email->setSubject($betreff);
    $email->addTo($empfaenger);
    //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
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


    $message = "UserID: ".$userid."<br>BestellID: ".$bestellungid;


    echo "Vor dem Senden";
    senden($user["email"], "Versandbestätigung", $message);
    echo "Nach dem Senden";
}
?>