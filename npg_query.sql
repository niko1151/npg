-- Opret databasen 'webshop' (hvis den ikke allerede findes)
CREATE DATABASE IF NOT EXISTS webshop;
USE webshop;

-- Opret tabellen 'kategorier' til at gemme forskellige produktkategorier
CREATE TABLE kategorier (
    kategori_id INT AUTO_INCREMENT PRIMARY KEY,
    kategori_navn VARCHAR(50) NOT NULL
);

-- Indsæt eksempelkategorier
INSERT INTO kategorier (kategori_navn) VALUES
    ('Bærbare computere'),
    ('Stationære computere'),
    ('Tilbehør');

-- Opret tabellen 'produkter' til at gemme oplysninger om computerprodukter
CREATE TABLE produkter (
    produkt_id INT AUTO_INCREMENT PRIMARY KEY,
    produkt_navn VARCHAR(100) NOT NULL,
    kategori_id INT,
    pris DECIMAL(10, 2) NOT NULL,
    beskrivelse TEXT,
    billede_url VARCHAR(255),
    FOREIGN KEY (kategori_id) REFERENCES kategorier(kategori_id)
);

-- Indsæt eksempelprodukter
INSERT INTO produkter (produkt_navn, kategori_id, pris, beskrivelse, billede_url) VALUES
    ('Gaming Bærbar', 1, 1499.99, 'Kraftfuld gaming bærbar til den ultimative spiloplevelse.', 'bærbar_gaming.jpg'),
    ('Arbejdsstation Desktop', 2, 1299.99, 'Højtydende stationær computer til professionelle arbejdsbelastninger.', 'desktop_arbejdsstation.jpg'),
    ('Trådløst Tastatur', 3, 49.99, 'Ergonomisk trådløst tastatur til behagelig skrivning.', 'tastatur_trådløs.jpg');

-- Opret tabellen 'kunder' til at gemme kundeoplysninger
CREATE TABLE kunder (
    kunde_id INT AUTO_INCREMENT PRIMARY KEY,
    fornavn VARCHAR(50) NOT NULL,
    efternavn VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    adgangskode VARCHAR(100) NOT NULL,
    adresse VARCHAR(255),
    by_navn VARCHAR(50),
    postnummer VARCHAR(20)
);

-- Opret tabellen 'ordrer' til at gemme ordreoplysninger
CREATE TABLE ordrer (
    ordre_id INT AUTO_INCREMENT PRIMARY KEY,
    kunde_id INT,
    ordre_dato TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_beløb DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (kunde_id) REFERENCES kunder(kunde_id)
);

-- Opret tabellen 'ordre_detaljer' til at gemme detaljer om produkter i hver ordre
CREATE TABLE ordre_detaljer (
    ordre_detalje_id INT AUTO_INCREMENT PRIMARY KEY,
    ordre_id INT,
    produkt_id INT,
    antal INT NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (ordre_id) REFERENCES ordrer(ordre_id),
    FOREIGN KEY (produkt_id) REFERENCES produkter(produkt_id)
);
