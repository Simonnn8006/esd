CREATE DATABASE IF NOT EXISTS Website CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

DROP USER IF EXISTS 'example_user'@'%';

CREATE USER 'example_user'@'%' IDENTIFIED BY 'example_password';

GRANT ALL PRIVILEGES ON Website.* TO 'example_user'@'%';

FLUSH PRIVILEGES;
USE Website;

-- Crée la table des utilisateurs (users)
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,   -- ID unique pour chaque utilisateur
    login VARCHAR(255) NOT NULL,              -- Login de l'utilisateur
    email VARCHAR(100) NOT NULL,             -- Adresse email de l'utilisateur
    password VARCHAR(255) NOT NULL,        -- Mot de passe haché
    photo_path VARCHAR(255) NULL,
    groupe VARCHAR(50) NULL              -- Groupe de l'utilisateur (ex: admin, utilisateur)
);

-- Crée la table des procédures
CREATE TABLE IF NOT EXISTS procedures (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,    -- ID unique pour chaque procédure
    user_id INT(11),                          -- Lien vers l'utilisateur (clé étrangère)
    nom_fichier VARCHAR(255) NOT NULL,        -- Nom du fichier associé
    emplacement_fichier VARCHAR(255) NOT NULL,-- Emplacement du fichier dans le dossier data de l'utilisateur
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE -- Clé étrangère reliant à l'utilisateur
);

CREATE TABLE IF NOT EXISTS partenaire (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL COLLATE utf8mb4_general_ci,
    site_web VARCHAR(255) NOT NULL COLLATE utf8mb4_general_ci,
    adresse_postale VARCHAR(255) NOT NULL COLLATE utf8mb4_general_ci,
    pays VARCHAR(100) NOT NULL COLLATE utf8mb4_general_ci
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;


INSERT INTO users (login, email, password, groupe) VALUES 
('admin', 'admin@example.com', '$2y$10$eW5kKo2FtbLb.fM/cYDDPe1svyBpFfGznmq1XWq3.mwZRhsj.X2Cq', 'admin'),
('HarryCopter', 'harry.copter@example.com', '$2y$10$R6LjgOpq/oeaYxoIFOMqWOpXOL6fnTUE58jdKzHoFwUqFBRGBZ4g6', 'utilisateur'),
('JeanNeige', 'jean.neige@example.com', '$2y$10$SLwJ6CpY28G3AvV1H/OI6uS1BzU8BGqV0TWOSib5Hbm3PrdyyoqJi', 'utilisateur'),
('AlexTherapeutique', 'alex.therapeutique@example.com', '$2y$10$MkhSK98yRpYmip/S1DZC1uKl/dJgdl58TXcf2ENjZXgUQlWlRuDJW', 'utilisateur'),
('EmmaPatie', 'emma.patie@example.com', '$2y$10$YstNmK/HbZptV.SVRFyZKOVFPLWQ8TTyOFNTce3BoI4bgbrHyWFTy', 'admin'),
('PhilAtropique', 'phil.atropique@example.com', '$2y$10$XFsM4RdjdJ9XnkLv/Z.CveG4SpG/IA54kC2Ak2uCVpb7rPxrmDPLa', 'utilisateur'),
('ClaireVoyante', 'claire.voyante@example.com', '$2y$10$rjQeO.eNPFPUzWfxEpp61esOAi9DbPYI6IxH/Jzj44fxDGO1zPcfO', 'utilisateur'),
('MaxIlien', 'max.ilien@example.com', '$2y$10$8Oa/aCdDtvEYIaaBzRcE4.L0Uw/bbpEdZRoKopOASPRozF5y0cuqe', 'utilisateur'),
('EddyQuate', 'eddy.quate@example.com', '$2y$10$Z1iGIZFzZoXzWXt99wUdg.TE3H8il7rKDcwbGdrqUG3FPPsCcvLO6', 'utilisateur'),
('NoaLarme', 'noa.larme@example.com', '$2y$10$Lu4CZCvTF8VZBSEECG3qAuF6U1bmXZdOU9zWwTfH.x7JVi3bF5X3K', 'utilisateur'),
('JacquesPot', 'jacques.pot@example.com', '$2y$10$spCzKNlU39zpYO8WFFmqrujytlE9DTxAjqT.Q8x5MBOt2JcKT0eTy', 'utilisateur'),
('alex', 'alex@example.com', '$2y$10$P6Q5DufXhPfLTyk4FHiHGuHcVHQDKBlzGqIdfpOYyNnppnpzrgJuG', 'utilisateur'),
('jthemee', 'jthemee@example.com', '$2y$10$cwK3frq5DDIwKtgjpX5IMuvbs4V5hJgCOC9lHXE/2ryAg4h0gNCvG', 'utilisateur'),
('valek', 'kelav@example.com', '$2y$10$kY7RbHFJbJcq3kKQibefruDtc/.nscy.nSxl17NOLrkEjM3dLfFpi', 'utilisateur'),
('jerry', 'jerrygolay@example.com', '$2y$10$3p5iV/LiX9u2jPBALRYPze5GZ/RqFZ/5LVsj6q9m1pQqEXicnnSg', 'utilisateur');


INSERT INTO partenaire (nom, site_web, adresse_postale, pays)
VALUES 
('HealthCare Solutions', 'https://www.healthcare-solutions.com', '123 Rue de la Santé, Paris', 'France'),
('MediTech Innovations', 'https://www.meditech-innovations.com', '456 Innovation Street, Lyon', 'France'),
('SantéPlus', 'https://www.santeplus.com', '789 Avenue du Bien-Être, Genève', 'Suisse'),
('Bien-être & Santé', 'https://www.bienetresante.com', '101 Rue du Confort, Bruxelles', 'Belgique'),
('Clinique Virtuelle', 'https://www.cliniquevirtuelle.com', '202 Digital Health Blvd, Zurich', 'Suisse'),
('PharmaConnect', 'https://www.pharmaconnect.com', '303 Rue des Médicaments, Montréal', 'Canada'),
('Prévention Santé', 'https://www.prevention-sante.com', '404 Avenue de la Prévention, Paris', 'France'),
('E-Santé Global', 'https://www.e-sante-global.com', '505 Global Health Road, Genève', 'Suisse'),
('Telemed Assistance', 'https://www.telemed-assistance.com', '606 Telemed Plaza, Bruxelles', 'Belgique'),
('Solutions Médicales Digitales', 'https://www.solutionsmeddigitales.com', '707 Digital Solutions Lane, Paris', 'France');



-- Insère une procédure de test pour cet utilisateur (admin)
INSERT INTO procedures (user_id, nom_fichier, emplacement_fichier) VALUES 
(1, 'procedure1.txt', '/data/admin/procedure1.txt');


-- Création de la base de données HealthcareRecords (dossiers médicaux)
CREATE DATABASE IF NOT EXISTS HealthcareRecords CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Création de la table des utilisateurs pour HealthcareRecords
USE HealthcareRecords;
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role VARCHAR(100) NOT NULL,     -- Rôles : médecin, infirmier, secrétaire médical
    specialty VARCHAR(100) NULL,    -- Spécialité médicale (pour les médecins)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Création de la base de données HRManagement (ressources humaines)
CREATE DATABASE IF NOT EXISTS HRManagement CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Création de la table des utilisateurs pour HRManagement
USE HRManagement;
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(50) NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    department VARCHAR(100) NOT NULL,   -- Département : RH, Finances, Marketing
    position VARCHAR(100) NOT NULL,     -- Poste : Manager, Assistant, etc.
    hired_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Création de la base de données FinanceOperations (opérations financières)
CREATE DATABASE IF NOT EXISTS FinanceOperations CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Création de la table des utilisateurs pour FinanceOperations
USE FinanceOperations;
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role VARCHAR(100) NOT NULL,   -- Rôles : Comptable, Analyste financier
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Création de la base de données ITOperations (opérations informatiques)
CREATE DATABASE IF NOT EXISTS ITOperations CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Création de la table des utilisateurs pour ITOperations
USE ITOperations;
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role VARCHAR(100) NOT NULL,   -- Rôles : Administrateur système, Développeur, Analyste de sécurité
    team VARCHAR(100) NULL,       -- Équipe : Réseau, Sécurité, Support technique
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



-- Insertion des utilisateurs pour HealthcareRecords
USE HealthcareRecords;
INSERT INTO users (name, email, role, specialty) VALUES
('Dr. Alice Dupont', 'alice.dupont@hospital.com', 'Médecin', 'Cardiologie'),
('Nurse Emma Leroy', 'emma.leroy@hospital.com', 'Infirmier', NULL),
('Dr. Paul Martin', 'paul.martin@hospital.com', 'Médecin', 'Neurologie'),
('Sophie Dubois', 'sophie.dubois@hospital.com', 'Secrétaire médical', NULL);

-- Insertion des utilisateurs pour HRManagement
USE HRManagement;
INSERT INTO users (employee_id, name, email, department, position, hired_date) VALUES
('HR001', 'Caroline Lefevre', 'caroline.lefevre@company.com', 'Ressources Humaines', 'Manager RH', '2018-04-15'),
('HR002', 'Marc Dupuis', 'marc.dupuis@company.com', 'Ressources Humaines', 'Assistant RH', '2019-07-22'),
('HR003', 'Julie Bernard', 'julie.bernard@company.com', 'Finances', 'Analyste Financier', '2020-01-10'),
('HR004', 'Lucien Dubois', 'lucien.dubois@company.com', 'Marketing', 'Responsable Marketing', '2017-09-01');

-- Insertion des utilisateurs pour FinanceOperations
USE FinanceOperations;
INSERT INTO users (name, email, role) VALUES
('Elodie Tremblay', 'elodie.tremblay@financecorp.com', 'Comptable'),
('Jean-Claude Riviere', 'jean.riviere@financecorp.com', 'Analyste Financier'),
('Nadine Lacroix', 'nadine.lacroix@financecorp.com', 'Contrôleur de gestion'),
('Georges Martin', 'georges.martin@financecorp.com', 'Auditeur');

-- Insertion des utilisateurs pour ITOperations
USE ITOperations;
INSERT INTO users (name, email, role, team) VALUES
('Mathieu Dupont', 'mathieu.dupont@itcorp.com', 'Administrateur système', 'Réseau'),
('Camille Petit', 'camille.petit@itcorp.com', 'Développeur', 'Développement web'),
('Hugo Lefevre', 'hugo.lefevre@itcorp.com', 'Analyste de sécurité', 'Sécurité'),
('Laura Delacroix', 'laura.delacroix@itcorp.com', 'Technicien support', 'Support technique');
