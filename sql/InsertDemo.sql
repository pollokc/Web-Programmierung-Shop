INSERT INTO `produkt` (`id`,`produktname`, `preis`, `beschreibung`) VALUES
(1, 'Erdbeer-Shake', 10.99, 'Super dupper Erdbeer-Shake.... Ich kann man auch noch kreativ werden und eine tolle Beschreibung hinzufügen.'),
(2, 'Himbeer-Smoothie', 5.99, 'Kreative Beschreibung'),
(3, 'Waldbeeren Smoothie', 5.99, 'Kreative Beschreibung '),
(4, 'Orangenshake', 6.99, 'Kreative Beschreibung'),
(5, 'Erdbeer-Schoko im Doppelpack', 7.99, 'Kreative Beschreibung');

INSERT INTO `benutzer` (`id`,`email`,`passwort`,`salz`,`vorname`,`nachname`) VALUES
(1,'test@test.de','1b3df60c735116b37986b67b1a006924785d009c9476f4206e773b1df7eb308cb94700e4bba2d0c7b9443bde6b95a902055cb2378b276c15d4a0bdb39d61432e','19594914065df61406b6ea05.32069662', 'TestVorname', 'TestNachname'),
(2, 'thejuiceboxwi3@gmail.com', 'de5c6f004cc93c8392c2455f742917115086adae14199e62acce2035f82f21854332ddb5be78b19e96eec23af73d075f55c04678d73ae6ef42a22fedaf88c64f', '17642453675dfe5a62d72506.96682176', 'Keine', 'Ahnung');

INSERT INTO `adresse` (`id`, `benutzerid`, `vornachname`, `zusatzinfo`, `strasse`, `hausnummer`, `plz`, `ort`) VALUES
('1', '1', 'TestAdresse1', 'TestFirma', 'Teststrasse', '4', '72764', 'Reutlingen'),
('2', '1', 'TestAdresse2', 'TestPrivat', 'Müllerstrasse', '55/1', '72766', 'Reutlingen');