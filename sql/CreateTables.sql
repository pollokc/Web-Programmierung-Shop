CREATE TABLE benutzer(
	id int PRIMARY KEY AUTO_INCREMENT,
	email varchar(255),
	passwort varchar(255),
	salz varchar(255),
	vorname varchar(255),
	nachname varchar(255),
	last_login DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	logged_in int(1) NOT NULL DEFAULT 0
);

CREATE TABLE produkt(
	id int PRIMARY KEY AUTO_INCREMENT,
	produktname varchar(255),
	preis float,
	beschreibung varchar(1000),
	hersteller varchar(255)
);

CREATE TABLE bestellung(
	id int PRIMARY KEY AUTO_INCREMENT,
	benutzerid int,
	FOREIGN KEY (benutzerid) REFERENCES benutzer(id),
	expresslieferung int(1),
	bestelldatum DATETIME,
	summe float,
	vornachname varchar(255),
	zusatzinfo varchar(255),
	strasse varchar(255),
	plz char(6),
	ort varchar(255)
);

CREATE TABLE bestellung_hat_produkte(
	bestellungid int,
	FOREIGN KEY (bestellungid) REFERENCES bestellung(id),
	produktid int,
	FOREIGN KEY (produktid) REFERENCES produkt(id),
	menge int,
	PRIMARY KEY (bestellungid, produktid)
);

CREATE TABLE warenkorb(
	id int PRIMARY KEY AUTO_INCREMENT,
	benutzerid int ,
	FOREIGN KEY (benutzerid) REFERENCES benutzer(id),
	produktid int,
	FOREIGN KEY (produktid) REFERENCES produkt(id),
	menge int
);