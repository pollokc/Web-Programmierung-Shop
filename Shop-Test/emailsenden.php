<?php
require 'vendor/autoload.php'; 


function senden($empfaenger, $betreff, $nachricht)
{
    $API_KEY = "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";

    $email = new \SendGrid\Mail\Mail(); 
    $email->setFrom("thejuiceboxwi3@gmail.com", "WebShop WI3");
    $email->setSubject($betreff);
    $email->addTo($empfaenger);
    //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $email->addContent(
        "text/html", $nachricht
    );

    $sendgrid = new \SendGrid($API_KEY);
    
    $response = $sendgrid->send($email);
}