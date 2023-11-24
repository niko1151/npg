-- Opret databasen 'webshop' (hvis den ikke allerede findes)
-- drop database webshop
CREATE DATABASE IF NOT EXISTS webshop;
USE webshop;
-- Opret tabellen 'kategorier' til at gemme forskellige produktkategorier
CREATE TABLE kategorier (
    kategori_id INT AUTO_INCREMENT PRIMARY KEY,
    kategori_navn VARCHAR(50) NOT NULL
);

-- Indsæt eksempelkategorier
INSERT INTO kategorier (kategori_navn) VALUES
	('Laptops'),
    ('Desktops'),
    ('Tilbehør'),
    ('Skærme'),
    ('Grafikkort'),
    ('Hovedtelefoner'),
    ('Printere'),
    ('Lagring'),
    ('Netværksudstyr'),
    ('Gaming Udstyr');

-- Opret tabellen 'produkter' til at gemme oplysninger om computerprodukter
CREATE TABLE produkter (
    produkt_id INT AUTO_INCREMENT PRIMARY KEY,
    produkt_navn VARCHAR(100) NOT NULL,
    kategori_id INT,
    antal int,
    pris DECIMAL(10, 2) NOT NULL,
    beskrivelse TEXT,
    billede_url VARCHAR(255),
    FOREIGN KEY (kategori_id) REFERENCES kategorier(kategori_id)
);

-- Indsæt eksempelprodukter
INSERT INTO produkter (produkt_navn, kategori_id, antal, pris, beskrivelse, billede_url) VALUES
    -- Kategori 1: Laptops
    ('UltraSlim Laptop', 1, 10, 899.99, 'Letvægts og bærbar laptop til daglig brug.', 'slimlaptop.png'),
    ('Powerful Gaming Laptop', 1, 15, 1499.99, 'Kraftfuld gaming laptop til den ultimative spiloplevelse.', ''),
    ('Business Ultrabook', 1, 12, 1299.99, 'Professionel ultrabook til forretningsbrug.', ''),

    -- Kategori 2: Desktops
    ('High-Performance Desktop', 2, 8, 1799.99, 'Højtydende stationær computer til krævende opgaver.', ''),
    ('Compact Mini PC', 2, 5, 699.99, 'Kompakt mini-PC med kraftfulde funktioner.', ''),
    ('Home Office Desktop', 2, 7, 999.99, 'Stationær computer perfekt til hjemmekontoret.', ''),

    -- Kategori 3: Tilbehør
    ('Wireless Mouse', 3, 20, 29.99, 'Trådløs mus til komfortabel brug.', ''),
    ('Mechanical Keyboard', 3, 15, 79.99, 'Mekanisk tastatur med taktil feedback.', ''),
    ('Laptop Stand', 3, 25, 19.99, 'Justerbar laptopstand for bedre ergonomi.', ''),

    -- Kategori 4: Skærme
    ('Curved Gaming Monitor', 4, 10, 549.99, 'Curvet gaming-skærm med høj opdateringshastighed.', ''),
    ('Professional Color-accurate Display', 4, 8, 799.99, 'Professionel skærm med nøjagtig farvegengivelse.', ''),
    ('Dual Monitor Setup', 4, 12, 899.99, 'Sæt med to skærme til multitasking.', ''),

    -- Kategori 5: Grafikkort
    ('Mid-Range Graphics Card', 5, 18, 349.99, 'Grafikkort til gaming og let grafisk arbejde.', ''),
    ('VR-Ready Graphics Card', 5, 12, 499.99, 'Grafikkort klar til virtual reality-oplevelser.', ''),
    ('High-End Graphics Card', 5, 8, 799.99, 'Toppræstation grafikkort til gaming og grafisk design.', ''),

    -- Kategori 6: Hovedtelefoner
    ('Over-Ear Gaming Headset', 6, 15, 99.99, 'Over-ear gaming headset med surroundlyd.', ''),
    ('Wireless Bluetooth Earbuds', 6, 20, 69.99, 'Trådløse Bluetooth-ørepropper til musik og opkald.', ''),
    ('Noise-Canceling On-Ear Headphones', 6, 10, 149.99, 'Støjreducerende on-ear hovedtelefoner til fokus og ro.', ''),

    -- Kategori 7: Printere
    ('All-in-One Inkjet Printer', 7, 8, 129.99, 'Alt-i-en blækprinter til scanning, kopiering og udskrivning.', ''),
    ('Laser Printer for Business', 7, 5, 249.99, 'Laserprinter designet til forretningsbrug.', ''),
    ('Portable Photo Printer', 7, 12, 79.99, 'Bærbar fotoprinter til øjeblikkelige udskrifter.', ''),

    -- Kategori 8: Lagring
    ('External SSD Drive', 8, 10, 179.99, 'Ekstern SSD-drev til hurtig datalagring og overførsel.', ''),
    ('Network Attached Storage (NAS)', 8, 6, 499.99, 'Netværksforbundet opbevaringsenhed til sikkerhedskopiering og deling.', ''),
    ('USB Flash Drive Pack', 8, 15, 39.99, 'Pakke med USB-flashdrev til bærbar datalagring.', ''),

    -- Kategori 9: Netværksudstyr
    ('Mesh Wi-Fi System', 9, 8, 299.99, 'Mesh Wi-Fi-system til fuldstændig dækning i hjemmet.', ''),
    ('Gigabit Ethernet Switch', 9, 12, 79.99, 'Gigabit Ethernet-switch for hurtig netværksforbindelse.', ''),
    ('Wi-Fi Range Extender', 9, 15, 49.99, 'Wi-Fi-range extender for at forbedre trådløs dækning.', ''),

    -- Kategori 10: Gaming Udstyr
    ('RGB Gaming Keyboard', 10, 10, 89.99, 'Gamingtastatur med RGB-belysning og programmerbare taster.', ''),
    ('Gaming Mouse Pad', 10, 18, 24.99, 'Stor musemåtte designet til præcis gaming.', ''),
    ('Gaming Chair', 10, 8, 199.99, 'Ergonomisk gamingstol for komfort under lange spilsessioner.', '');
-- Opret tabellen 'kunder' til at gemme kundeoplysninger
CREATE TABLE kunder (
    kunde_id INT AUTO_INCREMENT PRIMARY KEY,
    fornavn VARCHAR(50) NOT NULL,
    efternavn VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    adgangskode VARCHAR(100) NOT NULL,
    adresse VARCHAR(255),
    by_navn VARCHAR(50),
    postnummer VARCHAR(20),
    telefonnummer int,
    adminP int
);

INSERT INTO kunder (fornavn, efternavn, email, adgangskode, adresse, by_navn, postnummer, telefonnummer, adminP) VALUES
	('Nikolai', 'Flodin', 'nikolai@gmail.com', 'test123', 'telegrafvej 9', 'Ballerup', 2750, 42641422,1),
	('Mathias', 'Plum', 'plum@gmail.com', 'onkel123', 'telegrafvej 19', 'Skovlunde ', 2740,12345678,1 ),
  ('Bo', 'Andersen', 'bo@gmail.com', 'bo123', 'telegrafvej 29', 'Herlev', 2730, 11223344,0);




-- Opret tabellen 'ordrer' til at gemme ordreoplysninger
CREATE TABLE ordrer (
    ordre_id INT AUTO_INCREMENT PRIMARY KEY,
    kunde_id INT,
    ordre_dato TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_beløb DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (kunde_id) REFERENCES kunder(kunde_id)
);


CREATE TABLE ordre_detaljer (
    ordre_detalje_id INT AUTO_INCREMENT PRIMARY KEY,
    ordre_id INT,
    produkt_id INT,
    antal_produkter INT NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (ordre_id) REFERENCES ordrer(ordre_id),
    FOREIGN KEY (produkt_id) REFERENCES produkter(produkt_id)
);

select * FROM produkter;