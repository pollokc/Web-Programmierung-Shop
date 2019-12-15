CREATE TABLE benutzer(
	id int PRIMARY KEY,
	email varchar(255),
	passwort varchar(255),
	salz varchar(255),
	vorname varchar(255),
	nachname varchar(255),
	last_login DATETIME,
	created_at DATETIME
);

CREATE TABLE adresse(
	id int PRIMARY KEY,
	benutzerid int,
	FOREIGN KEY (benutzerid) REFERENCES benutzer(id),
	vornachname varchar(255),
	zusatzinfo varchar(255),
	strasse varchar(255),
	hausnummer varchar(25),
	plz char(6),
	ort varchar(255)
);

CREATE TABLE produkt(
	id int PRIMARY KEY,
	produktname varchar(255),
	preis float,
	beschreibung varchar(255)
);

CREATE TABLE bestellung(
	id int PRIMARY KEY,
	benutzerid int ,
	FOREIGN KEY (benutzerid) REFERENCES benutzer(id),
	lieferadresse int,
	FOREIGN KEY (lieferadresse) REFERENCES adresse(id),
	rechnungsadresse int,
	FOREIGN KEY (rechnungsadresse) REFERENCES adresse(id),
	bestelldatum DATETIME
);

CREATE TABLE besttelung_hat_produkte(
	bestellungid int,
	FOREIGN KEY (bestellungid) REFERENCES bestellung(id),
	produktid int,
	FOREIGN KEY (produktid) REFERENCES produkt(id),
	menge int,
	PRIMARY KEY (bestellungid, produktid)
);