-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 21. Dez 2019 um 20:59
-- Server-Version: 10.4.8-MariaDB
-- PHP-Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `thejuicebox`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `adresse`
--

CREATE TABLE `adresse` (
  `id` int(11) NOT NULL,
  `benutzerid` int(11) DEFAULT NULL,
  `vornachname` varchar(255) DEFAULT NULL,
  `zusatzinfo` varchar(255) DEFAULT NULL,
  `strasse` varchar(255) DEFAULT NULL,
  `hausnummer` varchar(25) DEFAULT NULL,
  `plz` char(6) DEFAULT NULL,
  `ort` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `adresse`
--

INSERT INTO `adresse` (`id`, `benutzerid`, `vornachname`, `zusatzinfo`, `strasse`, `hausnummer`, `plz`, `ort`) VALUES
(1, 1, 'TestAdresse1', 'TestFirma', 'Teststrasse', '4', '72764', 'Reutlingen'),
(2, 1, 'TestAdresse2', 'TestPrivat', 'Müllerstrasse', '55/1', '72766', 'Reutlingen');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--

CREATE TABLE `benutzer` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `passwort` varchar(255) DEFAULT NULL,
  `salz` varchar(255) DEFAULT NULL,
  `vorname` varchar(255) DEFAULT NULL,
  `nachname` varchar(255) DEFAULT NULL,
  `last_login` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `logged_in` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `benutzer`
--

INSERT INTO `benutzer` (`id`, `email`, `passwort`, `salz`, `vorname`, `nachname`, `last_login`, `created_at`, `logged_in`) VALUES
(1, 'test@test.de', '1b3df60c735116b37986b67b1a006924785d009c9476f4206e773b1df7eb308cb94700e4bba2d0c7b9443bde6b95a902055cb2378b276c15d4a0bdb39d61432e', '19594914065df61406b6ea05.32069662', 'TestVorname', 'TestNachname', '2019-12-21 20:06:22', '2019-12-17 12:26:02', 1),
(4, 'thejuiceboxwi3@gmail.com', 'de5c6f004cc93c8392c2455f742917115086adae14199e62acce2035f82f21854332ddb5be78b19e96eec23af73d075f55c04678d73ae6ef42a22fedaf88c64f', '17642453675dfe5a62d72506.96682176', 'Keine', 'Ahnung', '2019-12-21 18:46:10', '2019-12-21 18:46:10', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bestellung`
--

CREATE TABLE `bestellung` (
  `id` int(11) NOT NULL,
  `benutzerid` int(11) DEFAULT NULL,
  `lieferadresse` int(11) DEFAULT NULL,
  `rechnungsadresse` int(11) DEFAULT NULL,
  `bestelldatum` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bestellung_hat_produkte`
--

CREATE TABLE `bestellung_hat_produkte` (
  `bestellungid` int(11) NOT NULL,
  `produktid` int(11) NOT NULL,
  `menge` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `produkt`
--

CREATE TABLE `produkt` (
  `id` int(11) NOT NULL,
  `produktname` varchar(255) DEFAULT NULL,
  `preis` float DEFAULT NULL,
  `beschreibung` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `produkt`
--

INSERT INTO `produkt` (`id`, `produktname`, `preis`, `beschreibung`) VALUES
(1, 'Erdbeer-Shake', 10.99, 'Super dupper Erdbeer-Shake.... \r\n\r\n'),
(2, 'Himbeer-Smoothie', 5.99, 'Kreative Beschreibung'),
(3, 'Waldbeeren Smoothie', 5.99, 'Kreative Beschreibung '),
(4, 'Orangenshake', 6.99, 'Kreative Beschreibung'),
(5, 'Erdbeer-Schoko im Doppelpack', 7.99, 'Kreative Beschreibung');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `adresse`
--
ALTER TABLE `adresse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `benutzerid` (`benutzerid`);

--
-- Indizes für die Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `bestellung`
--
ALTER TABLE `bestellung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `benutzerid` (`benutzerid`),
  ADD KEY `lieferadresse` (`lieferadresse`),
  ADD KEY `rechnungsadresse` (`rechnungsadresse`);

--
-- Indizes für die Tabelle `bestellung_hat_produkte`
--
ALTER TABLE `bestellung_hat_produkte`
  ADD PRIMARY KEY (`bestellungid`,`produktid`),
  ADD KEY `produktid` (`produktid`);

--
-- Indizes für die Tabelle `produkt`
--
ALTER TABLE `produkt`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `adresse`
--
ALTER TABLE `adresse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `bestellung`
--
ALTER TABLE `bestellung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `produkt`
--
ALTER TABLE `produkt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `adresse`
--
ALTER TABLE `adresse`
  ADD CONSTRAINT `adresse_ibfk_1` FOREIGN KEY (`benutzerid`) REFERENCES `benutzer` (`id`);

--
-- Constraints der Tabelle `bestellung`
--
ALTER TABLE `bestellung`
  ADD CONSTRAINT `bestellung_ibfk_1` FOREIGN KEY (`benutzerid`) REFERENCES `benutzer` (`id`),
  ADD CONSTRAINT `bestellung_ibfk_2` FOREIGN KEY (`lieferadresse`) REFERENCES `adresse` (`id`),
  ADD CONSTRAINT `bestellung_ibfk_3` FOREIGN KEY (`rechnungsadresse`) REFERENCES `adresse` (`id`);

--
-- Constraints der Tabelle `bestellung_hat_produkte`
--
ALTER TABLE `bestellung_hat_produkte`
  ADD CONSTRAINT `bestellung_hat_produkte_ibfk_1` FOREIGN KEY (`bestellungid`) REFERENCES `bestellung` (`id`),
  ADD CONSTRAINT `bestellung_hat_produkte_ibfk_2` FOREIGN KEY (`produktid`) REFERENCES `produkt` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
