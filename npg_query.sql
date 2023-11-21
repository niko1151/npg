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
    pris DECIMAL(10, 2) NOT NULL,
    beskrivelse TEXT,
    billede_url VARCHAR(255),
    FOREIGN KEY (kategori_id) REFERENCES kategorier(kategori_id)
);

-- Indsæt eksempelprodukter
INSERT INTO produkter (produkt_navn, kategori_id, pris, beskrivelse, billede_url) VALUES
    -- Kategori 1: Laptops
    ('UltraSlim Laptop', 1, 899.99, 'Letvægts og bærbar laptop til daglig brug.', 'ultraslim_laptop.jpg'),
    ('Powerful Gaming Laptop', 1, 1499.99, 'Kraftfuld gaming laptop til den ultimative spiloplevelse.', 'gaming_laptop_powerful.jpg'),
    ('Business Ultrabook', 1, 1299.99, 'Professionel ultrabook til forretningsbrug.', 'business_ultrabook.jpg'),

    -- Kategori 2: Desktops
    ('High-Performance Desktop', 2, 1799.99, 'Højtydende stationær computer til krævende opgaver.', 'high_performance_desktop.jpg'),
    ('Compact Mini PC', 2, 699.99, 'Kompakt mini-PC med kraftfulde funktioner.', 'compact_mini_pc.jpg'),
    ('Home Office Desktop', 2, 999.99, 'Stationær computer perfekt til hjemmekontoret.', 'home_office_desktop.jpg'),

    -- Kategori 3: Tilbehør
    ('Wireless Mouse', 3, 29.99, 'Trådløs mus til komfortabel brug.', 'wireless_mouse.jpg'),
    ('Mechanical Keyboard', 3, 79.99, 'Mekanisk tastatur med taktil feedback.', 'mechanical_keyboard.jpg'),
    ('Laptop Stand', 3, 19.99, 'Justerbar laptopstand for bedre ergonomi.', 'laptop_stand.jpg'),

    -- Kategori 4: Skærme
    ('Curved Gaming Monitor', 4, 549.99, 'Curvet gaming-skærm med høj opdateringshastighed.', 'curved_gaming_monitor.jpg'),
    ('Professional Color-accurate Display', 4, 799.99, 'Professionel skærm med nøjagtig farvegengivelse.', 'professional_display.jpg'),
    ('Dual Monitor Setup', 4, 899.99, 'Sæt med to skærme til multitasking.', 'dual_monitor_setup.jpg'),

    -- Kategori 5: Grafikkort
    ('Mid-Range Graphics Card', 5, 349.99, 'Grafikkort til gaming og let grafisk arbejde.', 'mid_range_graphics_card.jpg'),
    ('VR-Ready Graphics Card', 5, 499.99, 'Grafikkort klar til virtual reality-oplevelser.', 'vr_ready_graphics_card.jpg'),
    ('High-End Graphics Card', 5, 799.99, 'Toppræstation grafikkort til gaming og grafisk design.', 'high_end_graphics_card.jpg'),

    -- Kategori 6: Hovedtelefoner
    ('Over-Ear Gaming Headset', 6, 99.99, 'Over-ear gaming headset med surroundlyd.', 'gaming_headset_over_ear.jpg'),
    ('Wireless Bluetooth Earbuds', 6, 69.99, 'Trådløse Bluetooth-ørepropper til musik og opkald.', 'wireless_earbuds.jpg'),
    ('Noise-Canceling On-Ear Headphones', 6, 149.99, 'Støjreducerende on-ear hovedtelefoner til fokus og ro.', 'noise_canceling_headphones.jpg'),

    -- Kategori 7: Printere
    ('All-in-One Inkjet Printer', 7, 129.99, 'Alt-i-en blækprinter til scanning, kopiering og udskrivning.', 'inkjet_printer.jpg'),
    ('Laser Printer for Business', 7, 249.99, 'Laserprinter designet til forretningsbrug.', 'laser_printer_business.jpg'),
    ('Portable Photo Printer', 7, 79.99, 'Bærbar fotoprinter til øjeblikkelige udskrifter.', 'portable_photo_printer.jpg'),

    -- Kategori 8: Lagring
    ('External SSD Drive', 8, 179.99, 'Ekstern SSD-drev til hurtig datalagring og overførsel.', 'external_ssd_drive.jpg'),
    ('Network Attached Storage (NAS)', 8, 499.99, 'Netværksforbundet opbevaringsenhed til sikkerhedskopiering og deling.', 'nas_storage.jpg'),
    ('USB Flash Drive Pack', 8, 39.99, 'Pakke med USB-flashdrev til bærbar datalagring.', 'usb_flash_drive_pack.jpg'),

    -- Kategori 9: Netværksudstyr
    ('Mesh Wi-Fi System', 9, 299.99, 'Mesh Wi-Fi-system til fuldstændig dækning i hjemmet.', 'mesh_wifi_system.jpg'),
    ('Gigabit Ethernet Switch', 9, 79.99, 'Gigabit Ethernet-switch for hurtig netværksforbindelse.', 'ethernet_switch.jpg'),
    ('Wi-Fi Range Extender', 9, 49.99, 'Wi-Fi-range extender for at forbedre trådløs dækning.', 'wifi_range_extender.jpg'),

    -- Kategori 10: Gaming Udstyr
    ('RGB Gaming Keyboard', 10, 89.99, 'Gamingtastatur med RGB-belysning og programmerbare taster.', 'rgb_gaming_keyboard.jpg'),
    ('Gaming Mouse Pad', 10, 24.99, 'Stor musemåtte designet til præcis gaming.', 'gaming_mouse_pad.jpg'),
    ('Gaming Chair', 10, 199.99, 'Ergonomisk gamingstol for komfort under lange spilsessioner.', 'gaming_chair.jpg');
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