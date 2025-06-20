CREATE DATABASE sun_power;
USE sun_power;

-- Table: Utilisateur
CREATE TABLE Utilisateur (
    id_utilisateur INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    mot_de_passe VARCHAR(255),
    role ENUM('user', 'admin', 'president') DEFAULT 'user'
);

-- Table PRODUIT
CREATE TABLE PRODUIT (
  id_produit INT AUTO_INCREMENT PRIMARY KEY,
  nom_produit VARCHAR(150),
  description TEXT,
  image VARCHAR(255),
  date_ajout DATE,
  statut VARCHAR(50)
);

-- Table: TypeInstallation (off-grid, on-grid, pompage)
CREATE TABLE TypeInstallation (
    id_type_installation INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL
);

-- Table: PanneauType
CREATE TABLE PanneauType (
    id_panneau_type INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    puissance INT, -- en Wc
    tension INT,
    prix_unitaire DECIMAL(10,2)
);

-- Table: BatteryType
CREATE TABLE BatteryType (
    id_batterie_type INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    capacite INT, -- en Ah
    tension INT,
    prix_unitaire DECIMAL(10,2)
);

-- Table: PompePuissance
CREATE TABLE PompePuissance (
    id_pompe_puissance INT PRIMARY KEY AUTO_INCREMENT,
    puissance_kw DECIMAL(5,2),
    prix_unitaire DECIMAL(10,2)
);

-- Table: Localisation
CREATE TABLE Localisation (
    id_localisation INT PRIMARY KEY AUTO_INCREMENT,
    ville VARCHAR(100),
    ensoleillement DECIMAL(4,2) -- en h/jour
);

-- Table: Simulation
CREATE TABLE Simulation (
    id_simulation INT PRIMARY KEY AUTO_INCREMENT,
    consommation_journaliere DECIMAL(10,2), -- Wh/jour
    id_utilisateur INT,
    id_panneau_type INT,
    id_batterie_type INT,
    id_pompe_puissance INT,
    id_localisation INT,
    id_type_installation INT,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
    FOREIGN KEY (id_panneau_type) REFERENCES PanneauType(id_panneau_type),
    FOREIGN KEY (id_batterie_type) REFERENCES BatteryType(id_batterie_type),
    FOREIGN KEY (id_pompe_puissance) REFERENCES PompePuissance(id_pompe_puissance),
    FOREIGN KEY (id_localisation) REFERENCES Localisation(id_localisation),
    FOREIGN KEY (id_type_installation) REFERENCES TypeInstallation(id_type_installation)
);

-- Table: Devis
CREATE TABLE Devis (
    id_devis INT PRIMARY KEY AUTO_INCREMENT,
    date_devis DATE,
    montant_total DECIMAL(10,2),
    id_simulation INT UNIQUE,
    FOREIGN KEY (id_simulation) REFERENCES Simulation(id_simulation)
);

