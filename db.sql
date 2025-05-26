CREATE DATABASE sun_power;
USE sun_power;

-- Table UTILISATEUR
CREATE TABLE UTILISATEUR (
  id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100),
  prénom VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  mot_de_passe VARCHAR(255)
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

-- Table ADMIN
CREATE TABLE ADMIN (
  id_admin INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100),
  prénom VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  mot_de_passe VARCHAR(255)
);

-- Table ACTION_ADMIN
CREATE TABLE ACTION_ADMIN (
  id_action INT AUTO_INCREMENT PRIMARY KEY,
  type_action VARCHAR(100),
  date_action DATE,
  id_admin INT,
  id_produit INT,
  FOREIGN KEY (id_admin) REFERENCES ADMIN(id_admin) ON DELETE CASCADE,
  FOREIGN KEY (id_produit) REFERENCES PRODUIT(id_produit) ON DELETE CASCADE
);

-- Table DEVIS
CREATE TABLE DEVIS (
  id_devis INT AUTO_INCREMENT PRIMARY KEY,
  date_devis DATE,
  montant_total DECIMAL(10,2),
  id_utilisateur INT,
  FOREIGN KEY (id_utilisateur) REFERENCES UTILISATEUR(id_utilisateur) ON DELETE CASCADE
);
