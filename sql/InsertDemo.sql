INSERT INTO `produkt` (`id`,`produktname`, `preis`, `beschreibung`, `hersteller`) VALUES
(1, 'Activate', 3.15, '„Bis-obenhin-voll-sein“ hat einen schlechten Ruf, den wir endlich rehabilitieren wollen. Darum füllen wir diesen Smoothie bis obenhin voll mit einer köstlichen Mischung aus Obst, Gemüse, Leinsamen und extra Vitaminen.', 'innocent'),
(2, 'Antioxidant', 3.15, 'Atme ein. Atme aus. Leg die Beine hoch und entspann Dich. Am besten mit diesem Super Smoothie. Mit ihm findest Du Deine Mitte ganz einfach. Ommm.', 'innocent'),
(3, 'Antioxidant Cacao', 3.15, 'Das Ganze ist mehr als die Summe seiner Teile. Das wissen nicht nur Philosophen und Konstrukteure, sondern auch Köche – und besonders auch unsere Smoothierezeptentwickler.', 'innocent'),
(4, 'Energise', 3.15, 'Dies ist die Smoothie-Version des Abends, als wir beim Karaoke-Singen Applaus bekamen: Er ist unser größter Stolz, denn er ist randvoll mit gesunden Sachen.', 'innocent'),
(5, 'Energise Tropical', 3.15, 'Manchmal fühlt es sich so an, als würde jeder Download am Computer länger dauern als der Sommer. Gerade war es zum ersten Mal warm– schwupps – schon ist wieder Herbst.', 'innocent'),
(6, 'Uplift', 3.29, 'Man sollte nie die Kraft von kleinen Dingen unterschätzen: Ameisen können das Fünftausendfache ihres Gewichts stemmen. Und die kleinen Beeren und Acerola-Kirschen in diesem Smoothie sorgen für mächtig guten Geschmack.', 'innocent'),
(7, 'Smoothie Minze & Caju', 2.49, 'Fans der ersten Stunde erinnern sich vielleicht, denn unseren Smoothie mit Ananas, Minze & Caju gab es schon mal. Jetzt feiert er endlich sein Revival.', 'truefruits'),
(8, 'Green Smoothie no. 1', 2.49, 'Grünkohl kennt man zwar eher vom Urlaub an der Nordsee in Kombination mit heißen Kartoffeln und geräucherter Wurst, aber Grünkohl schmeckt auch ohne Mett.', 'truefruits'),
(9, 'Smoothie orange', 2.49, 'Unsere Hautattraktion im Kühlregal: Unser Smoothie orange mit pürierter Orangenhaut. Das neue Smoothie Rezept aus Orangenschale, Goji, Acerola, Mango & Apfel macht ihn fruchtig frisch.', 'truefruits'),
(10, 'Smoothie pink', 2.49, 'Unser Smoothie pink fällt allein wegen der intensiven Farbe auf, die er der Pinken Drachenfrucht zu verdanken hat. In Fachkreisen wird unser Smoothie pink auch liebevoll #Einhornkotze genannt.', 'truefruits'),
(11, 'Smoothie purple', 2.49, 'In unserem Smoothie purple steckt die volle Ladung Beerenpower. Das macht ihn ein bisschen sauer, aber lustig.', 'truefruits'),
(12, 'Smoothie yellow', 2.49, 'In unserem Smoothie yellow versteckt sich ganz unbemerkt der Champion unter den Mangos, die Kesar Mango aus Indien. Das sieht man ihm zwar nicht an, aber man schmeckt es.', 'truefruits');

INSERT INTO `benutzer` (`id`,`email`,`passwort`,`salz`,`vorname`,`nachname`) VALUES
(1,'test@test.de','1b3df60c735116b37986b67b1a006924785d009c9476f4206e773b1df7eb308cb94700e4bba2d0c7b9443bde6b95a902055cb2378b276c15d4a0bdb39d61432e','19594914065df61406b6ea05.32069662', 'TestVorname', 'TestNachname'),
(2, 'thejuiceboxwi3@gmail.com', 'de5c6f004cc93c8392c2455f742917115086adae14199e62acce2035f82f21854332ddb5be78b19e96eec23af73d075f55c04678d73ae6ef42a22fedaf88c64f', '17642453675dfe5a62d72506.96682176', 'Keine', 'Ahnung');

INSERT INTO `warenkorb` (`id`,`benutzerid`,`produktid`,`menge`) VALUES
(1,1,6,4),
(2,1,1,2),
(3,1,11,10);

INSERT INTO `bestellung` (`id`,`benutzerid`,`expresslieferung`,`bestelldatum`,`summe`,`vornachname`,`zusatzinfo`,`strasse`,`plz`,`ort`) VALUES
(1,1,1,"2019-12-27 14:49:48",20.73,"Hochschule Reutlingen","Fakultät Informatik","Alteburgstraße 150","72762","Reutlingen");

INSERT INTO `bestellung_hat_produkte` (`bestellungid`,`produktid`,`menge`) VALUES
(1,2,1),
(1,4,3),
(1,5,1),
(1,10,1),
(1,12,1);
