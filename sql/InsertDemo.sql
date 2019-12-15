INSERT INTO `produkt` (`id`,`produktname`, `preis`, `beschreibung`) VALUES
(1, 'Erdbeer-Shake', 10.99, 'Super dupper Erdbeer-Shake.... Ich kann man auch noch kreativ werden und eine tolle Beschreibung hinzufügen.'),
(2, 'Himbeer-Smoothie', 5.99, 'Kreative Beschreibung'),
(3, 'Waldbeeren Smoothie', 5.99, 'Kreative Beschreibung '),
(4, 'Orangenshake', 6.99, 'Kreative Beschreibung'),
(5, 'Erdbeer-Schoko im Doppelpack', 7.99, 'Kreative Beschreibung');

INSERT INTO `benutzer` (`id`,`email`,`passwort`,`salz`,`vorname`,`nachname`) VALUES
(1,'test@test.de','987b0584c39d0b40505d02ad2c30ce96d65762004f5fa71ed36d1641b5aac31e59e396384b0ba7d2c22b9abc8daa032247253abe0fccc925dd0eaa028400874c','19594914065df61406b6ea05.32069662', 'TestVorname', 'TestNachname');

INSERT INTO `adresse` (`id`, `benutzerid`, `vornachname`, `zusatzinfo`, `strasse`, `hausnummer`, `plz`, `ort`) VALUES
('1', '1', 'TestAdresse1', 'TestFirma', 'Teststrasse', '4', '72764', 'Reutlingen'),
('2', '1', 'TestAdresse2', 'TestPrivat', 'Müllerstrasse', '55/1', '72766', 'Reutlingen');