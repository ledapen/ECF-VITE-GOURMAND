-- ==========================================================
-- ECF TP Developpeur Web et Web Mobile
-- Projet : Vite & Gourmand
-- Partie 8 : Script SQL de creation et d'insertion de donnees
-- SGBD cible : MySQL / MariaDB
-- ==========================================================

DROP DATABASE IF EXISTS vite_gourmand;
CREATE DATABASE vite_gourmand
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE vite_gourmand;

-- ==========================================================
-- 1. TABLES DE REFERENCE
-- ==========================================================

CREATE TABLE role (
  id_role INT AUTO_INCREMENT PRIMARY KEY,
  libelle VARCHAR(50) NOT NULL UNIQUE,
  description TEXT NULL
) ENGINE=InnoDB;

CREATE TABLE theme (
  id_theme INT AUTO_INCREMENT PRIMARY KEY,
  libelle VARCHAR(80) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE regime (
  id_regime INT AUTO_INCREMENT PRIMARY KEY,
  libelle VARCHAR(80) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE statut_commande (
  id_statut INT AUTO_INCREMENT PRIMARY KEY,
  libelle VARCHAR(80) NOT NULL UNIQUE,
  ordre_affichage INT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE allergene (
  id_allergene INT AUTO_INCREMENT PRIMARY KEY,
  libelle VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- ==========================================================
-- 2. UTILISATEURS ET AUTHENTIFICATION
-- ==========================================================

CREATE TABLE utilisateur (
  id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
  id_role INT NOT NULL,
  nom VARCHAR(100) NOT NULL,
  prenom VARCHAR(100) NOT NULL,
  email VARCHAR(180) NOT NULL UNIQUE,
  telephone VARCHAR(20) NOT NULL,
  adresse VARCHAR(255) NOT NULL,
  mot_de_passe_hash VARCHAR(255) NOT NULL,
  actif BOOLEAN NOT NULL DEFAULT TRUE,
  date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_utilisateur_role
    FOREIGN KEY (id_role) REFERENCES role(id_role)
) ENGINE=InnoDB;

-- ==========================================================
-- 3. MENUS, PLATS, IMAGES ET ALLERGENES
-- ==========================================================

CREATE TABLE menu (
  id_menu INT AUTO_INCREMENT PRIMARY KEY,
  id_theme INT NOT NULL,
  id_regime INT NOT NULL,
  titre VARCHAR(150) NOT NULL,
  description TEXT NOT NULL,
  nb_personnes_min INT NOT NULL,
  prix_minimum DECIMAL(10,2) NOT NULL,
  conditions_menu TEXT NOT NULL,
  stock_disponible INT NOT NULL DEFAULT 0,
  actif BOOLEAN NOT NULL DEFAULT TRUE,
  CONSTRAINT fk_menu_theme
    FOREIGN KEY (id_theme) REFERENCES theme(id_theme),
  CONSTRAINT fk_menu_regime
    FOREIGN KEY (id_regime) REFERENCES regime(id_regime),
  CONSTRAINT chk_menu_nb_personnes CHECK (nb_personnes_min > 0),
  CONSTRAINT chk_menu_prix CHECK (prix_minimum >= 0),
  CONSTRAINT chk_menu_stock CHECK (stock_disponible >= 0)
) ENGINE=InnoDB;

CREATE TABLE image_menu (
  id_image INT AUTO_INCREMENT PRIMARY KEY,
  id_menu INT NOT NULL,
  url_image VARCHAR(255) NOT NULL,
  texte_alternatif VARCHAR(255) NOT NULL,
  ordre_affichage INT NOT NULL DEFAULT 1,
  CONSTRAINT fk_image_menu
    FOREIGN KEY (id_menu) REFERENCES menu(id_menu)
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE plat (
  id_plat INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(150) NOT NULL,
  description TEXT NULL,
  type_plat ENUM('entree','plat','dessert') NOT NULL,
  actif BOOLEAN NOT NULL DEFAULT TRUE
) ENGINE=InnoDB;

CREATE TABLE menu_plat (
  id_menu INT NOT NULL,
  id_plat INT NOT NULL,
  PRIMARY KEY (id_menu, id_plat),
  CONSTRAINT fk_menu_plat_menu
    FOREIGN KEY (id_menu) REFERENCES menu(id_menu)
    ON DELETE CASCADE,
  CONSTRAINT fk_menu_plat_plat
    FOREIGN KEY (id_plat) REFERENCES plat(id_plat)
    ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE plat_allergene (
  id_plat INT NOT NULL,
  id_allergene INT NOT NULL,
  PRIMARY KEY (id_plat, id_allergene),
  CONSTRAINT fk_plat_allergene_plat
    FOREIGN KEY (id_plat) REFERENCES plat(id_plat)
    ON DELETE CASCADE,
  CONSTRAINT fk_plat_allergene_allergene
    FOREIGN KEY (id_allergene) REFERENCES allergene(id_allergene)
    ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ==========================================================
-- 4. COMMANDES ET SUIVI
-- ==========================================================

CREATE TABLE commande (
  id_commande INT AUTO_INCREMENT PRIMARY KEY,
  id_utilisateur INT NOT NULL,
  id_menu INT NOT NULL,
  id_statut INT NOT NULL,
  date_prestation DATE NOT NULL,
  heure_livraison TIME NOT NULL,
  adresse_livraison VARCHAR(255) NOT NULL,
  ville_livraison VARCHAR(100) NOT NULL,
  nb_personnes INT NOT NULL,
  prix_menu DECIMAL(10,2) NOT NULL,
  frais_livraison DECIMAL(10,2) NOT NULL DEFAULT 0,
  reduction DECIMAL(10,2) NOT NULL DEFAULT 0,
  total DECIMAL(10,2) NOT NULL,
  date_commande DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_commande_utilisateur
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur),
  CONSTRAINT fk_commande_menu
    FOREIGN KEY (id_menu) REFERENCES menu(id_menu),
  CONSTRAINT fk_commande_statut
    FOREIGN KEY (id_statut) REFERENCES statut_commande(id_statut),
  CONSTRAINT chk_commande_nb_personnes CHECK (nb_personnes > 0),
  CONSTRAINT chk_commande_montants CHECK (
    prix_menu >= 0 AND frais_livraison >= 0 AND reduction >= 0 AND total >= 0
  )
) ENGINE=InnoDB;

CREATE TABLE historique_statut (
  id_historique INT AUTO_INCREMENT PRIMARY KEY,
  id_commande INT NOT NULL,
  id_statut INT NOT NULL,
  id_utilisateur INT NOT NULL,
  date_changement DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  commentaire TEXT NULL,
  CONSTRAINT fk_historique_commande
    FOREIGN KEY (id_commande) REFERENCES commande(id_commande)
    ON DELETE CASCADE,
  CONSTRAINT fk_historique_statut
    FOREIGN KEY (id_statut) REFERENCES statut_commande(id_statut),
  CONSTRAINT fk_historique_utilisateur
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur)
) ENGINE=InnoDB;

CREATE TABLE avis (
  id_avis INT AUTO_INCREMENT PRIMARY KEY,
  id_commande INT NOT NULL,
  id_utilisateur INT NOT NULL,
  note TINYINT NOT NULL,
  commentaire TEXT NOT NULL,
  valide BOOLEAN NOT NULL DEFAULT FALSE,
  date_avis DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_avis_commande
    FOREIGN KEY (id_commande) REFERENCES commande(id_commande)
    ON DELETE CASCADE,
  CONSTRAINT fk_avis_utilisateur
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur),
  CONSTRAINT chk_avis_note CHECK (note BETWEEN 1 AND 5)
) ENGINE=InnoDB;


CREATE TABLE password_reset (
  id_password_reset INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(180) NOT NULL,
  token VARCHAR(255) NOT NULL,
  expires_at DATETIME NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_password_reset_email (email)
) ENGINE=InnoDB;

-- ==========================================================
-- 5. HORAIRES ET CONTACT
-- ==========================================================

CREATE TABLE horaire (
  id_horaire INT AUTO_INCREMENT PRIMARY KEY,
  jour_semaine VARCHAR(20) NOT NULL UNIQUE,
  heure_ouverture TIME NULL,
  heure_fermeture TIME NULL,
  ferme BOOLEAN NOT NULL DEFAULT FALSE
) ENGINE=InnoDB;

CREATE TABLE contact (
  id_contact INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(150) NOT NULL,
  email VARCHAR(180) NOT NULL,
  description TEXT NOT NULL,
  date_envoi DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  traite BOOLEAN NOT NULL DEFAULT FALSE
) ENGINE=InnoDB;

-- ==========================================================
-- 6. INDEX POUR LES RECHERCHES ET FILTRES
-- ==========================================================

CREATE INDEX idx_menu_theme ON menu(id_theme);
CREATE INDEX idx_menu_regime ON menu(id_regime);
CREATE INDEX idx_menu_prix ON menu(prix_minimum);
CREATE INDEX idx_menu_personnes ON menu(nb_personnes_min);
CREATE INDEX idx_commande_utilisateur ON commande(id_utilisateur);
CREATE INDEX idx_commande_statut ON commande(id_statut);
CREATE INDEX idx_commande_date ON commande(date_prestation);
CREATE INDEX idx_avis_valide ON avis(valide);

-- ==========================================================
-- 7. DONNEES INITIALES
-- ==========================================================

INSERT INTO role (libelle, description) VALUES
('administrateur', 'Acces complet a l application'),
('employe', 'Gestion des menus, commandes, horaires et avis'),
('utilisateur', 'Client pouvant commander et donner un avis');

INSERT INTO theme (libelle) VALUES
('Noel'),
('Paques'),
('Classique'),
('Evenement');

INSERT INTO regime (libelle) VALUES
('Classique'),
('Vegetarien'),
('Vegan'),
('Sans gluten');

INSERT INTO statut_commande (libelle, ordre_affichage) VALUES
('en attente', 1),
('acceptee', 2),
('en preparation', 3),
('en cours de livraison', 4),
('livree', 5),
('en attente du retour de materiel', 6),
('terminee', 7),
('annulee', 8);

INSERT INTO allergene (libelle) VALUES
('Gluten'),
('Lait'),
('Oeuf'),
('Arachides'),
('Fruits a coque'),
('Soja'),
('Poisson'),
('Crustaces');

-- Mot de passe de demonstration : Admin1234!
-- En production, il doit etre genere avec password_hash() cote back-end.
INSERT INTO utilisateur
(id_role, nom, prenom, email, telephone, adresse, mot_de_passe_hash, actif)
VALUES
(1, 'Gourmand', 'Jose', 'admin@vitegourmand.fr', '0600000000', '12 rue Sainte-Catherine, 33000 Bordeaux', '$2y$10$examplehashadmin', TRUE),
(2, 'Dupont', 'Julie', 'employe@vitegourmand.fr', '0611111111', '12 rue Sainte-Catherine, 33000 Bordeaux', '$2y$10$examplehashemploye', TRUE),
(3, 'Martin', 'Alice', 'alice.martin@example.fr', '0622222222', '18 rue des Remparts, 33000 Bordeaux', '$2y$10$examplehashclient', TRUE);

INSERT INTO plat (nom, description, type_plat, actif) VALUES
('Foie gras maison', 'Foie gras accompagne de chutney de figues', 'entree', TRUE),
('Veloute de potimarron', 'Veloute cremeux aux graines torrifiees', 'entree', TRUE),
('Dinde farcie', 'Dinde festive accompagnee de legumes de saison', 'plat', TRUE),
('Risotto aux champignons', 'Risotto vegetarien aux champignons frais', 'plat', TRUE),
('Buche chocolat noisette', 'Dessert de fete au chocolat et noisettes', 'dessert', TRUE),
('Tarte citron revisitee', 'Dessert frais et acidule', 'dessert', TRUE);

INSERT INTO menu
(id_theme, id_regime, titre, description, nb_personnes_min, prix_minimum, conditions_menu, stock_disponible, actif)
VALUES
(1, 1, 'Menu de Noel Tradition', 'Menu complet pour repas de Noel familial ou professionnel.', 6, 210.00, 'Commande au moins 7 jours avant la prestation. Conservation au frais obligatoire.', 5, TRUE),
(3, 2, 'Menu Vegetarien Gourmand', 'Menu vegetarien complet avec entree, plat et dessert.', 4, 120.00, 'Commande au moins 72 heures avant la prestation.', 8, TRUE),
(4, 1, 'Menu Evenement Prestige', 'Menu haut de gamme pour reception professionnelle.', 10, 450.00, 'Commande au moins 14 jours avant la prestation. Materiel de service possible.', 3, TRUE);

INSERT INTO image_menu (id_menu, url_image, texte_alternatif, ordre_affichage) VALUES
(1, '/assets/images/menu-noel.jpg', 'Table de Noel avec plat principal et decoration festive', 1),
(2, '/assets/images/menu-vegetarien.jpg', 'Assiette vegetarienne composee de legumes et cereales', 1),
(3, '/assets/images/menu-prestige.jpg', 'Buffet de reception haut de gamme', 1);

INSERT INTO menu_plat (id_menu, id_plat) VALUES
(1, 1), (1, 3), (1, 5),
(2, 2), (2, 4), (2, 6),
(3, 1), (3, 3), (3, 6);

INSERT INTO plat_allergene (id_plat, id_allergene) VALUES
(1, 2), (1, 3),
(3, 1),
(4, 2),
(5, 1), (5, 2), (5, 5),
(6, 1), (6, 2), (6, 3);

INSERT INTO horaire (jour_semaine, heure_ouverture, heure_fermeture, ferme) VALUES
('Lundi', '09:00:00', '18:00:00', FALSE),
('Mardi', '09:00:00', '18:00:00', FALSE),
('Mercredi', '09:00:00', '18:00:00', FALSE),
('Jeudi', '09:00:00', '18:00:00', FALSE),
('Vendredi', '09:00:00', '19:00:00', FALSE),
('Samedi', '10:00:00', '17:00:00', FALSE),
('Dimanche', NULL, NULL, TRUE);

INSERT INTO commande
(id_utilisateur, id_menu, id_statut, date_prestation, heure_livraison, adresse_livraison, ville_livraison, nb_personnes, prix_menu, frais_livraison, reduction, total)
VALUES
(3, 1, 2, '2026-12-24', '19:00:00', '18 rue des Remparts', 'Bordeaux', 8, 280.00, 0.00, 0.00, 280.00);

INSERT INTO historique_statut (id_commande, id_statut, id_utilisateur, commentaire) VALUES
(1, 1, 3, 'Commande creee par le client'),
(1, 2, 2, 'Commande acceptee apres verification');

INSERT INTO avis (id_commande, id_utilisateur, note, commentaire, valide) VALUES
(1, 3, 5, 'Prestation excellente, menu tres apprecie par nos invites.', TRUE);

INSERT INTO contact (titre, email, description, traite) VALUES
('Demande de devis', 'contact.client@example.fr', 'Bonjour, je souhaite un devis pour un repas de 20 personnes.', FALSE);

-- ==========================================================
-- 8. EXEMPLES DE REQUETES UTILES
-- ==========================================================

-- Recherche de menus actifs par prix maximum
-- SELECT * FROM menu WHERE actif = TRUE AND prix_minimum <= 250;

-- Recherche de menus par theme et regime
-- SELECT m.*
-- FROM menu m
-- JOIN theme t ON t.id_theme = m.id_theme
-- JOIN regime r ON r.id_regime = m.id_regime
-- WHERE t.libelle = 'Noel' AND r.libelle = 'Classique';

-- Commandes par statut
-- SELECT c.id_commande, u.email, m.titre, s.libelle, c.date_prestation, c.total
-- FROM commande c
-- JOIN utilisateur u ON u.id_utilisateur = c.id_utilisateur
-- JOIN menu m ON m.id_menu = c.id_menu
-- JOIN statut_commande s ON s.id_statut = c.id_statut
-- ORDER BY c.date_commande DESC;

-- Chiffre d'affaires par menu
-- SELECT m.titre, COUNT(c.id_commande) AS nombre_commandes, SUM(c.total) AS chiffre_affaires
-- FROM commande c
-- JOIN menu m ON m.id_menu = c.id_menu
-- GROUP BY m.id_menu, m.titre;
