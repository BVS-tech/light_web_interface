-- Creation de la bdd
CREATE DATABASE IF NOT EXISTS dblight;

USE dblight;

CREATE TABLE IF NOT EXISTS light (
    light_id INT NOT NULL,
    light_state TINYINT,
    light_pair TINYINT,
    light_power TINYINT,
    light_xmin INT,
    light_xmax INT,
    light_ymin INT,
    light_ymax INT,
    PRIMARY KEY (light_id)
);

CREATE TABLE IF NOT EXISTS powerl (
    light_id INT NOT NULL,
    powerl_start_date TIMESTAMP NOT NULL,
    powerl_end_date TIMESTAMP NOT NULL,
    powerl_power TINYINT,
    powerl_consumption TINYINT,
    FOREIGN KEY fk_light(light_id)
    REFERENCES light(light_id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS scenario (
    scenario_id INT NOT NULL,
    scenario_lib TEXT,
    PRIMARY KEY (scenario_id)
);

CREATE TABLE IF NOT EXISTS rasplight (
    scenario_id INT DEFAULT NULL,
    scenario_pid INT DEFAULT NULL,
    FOREIGN KEY fk_scenario(scenario_id)
    REFERENCES scenario(scenario_id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

#########################################

-- Ajout de lampes
INSERT INTO light(light_id, light_state, light_pair, light_power, light_xmin, light_xmax, light_ymin, light_ymax) VALUES (1, 0, 0, 2, 25, 10, 30, 40);
INSERT INTO light VALUES (2, 0, 1, 2, 25, 10, 30, 40);
INSERT INTO light VALUES (3, 1, 0, 2, 25, 10, 30, 40);
INSERT INTO light VALUES (4, 1, 1, 2, 25, 10, 30, 40);
INSERT INTO light VALUES (5, 0, 0, 2, 25, 10, 30, 40);

-- Ajout de mesures de consommations
INSERT INTO powerl(light_id, powerl_start_date, powerl_end_date, powerl_power, powerl_consumption) VALUES (1, '2015-01-01 10:10:10', '2015-01-01 10:10:10', 0, 0);
INSERT INTO powerl VALUES (2, '2015-01-01 10:10:10', '2015-01-01 10:10:10', 0, 0);

-- Ajout de scenarios
INSERT INTO scenario(scenario_id, scenario_lib) VALUES (1, "Scenario 1 - explication");
INSERT INTO scenario VALUES	(2, "Scenario 2 - explication");

-- Ajout du (UN SEUL) scenario en cours
INSERT INTO rasplight(scenario_id, scenario_pid) VALUES (1, 1456);

#######################################

-- Recuperation de l'id du scenario en cours pour pouvoir le changer
SELECT scenario_id FROM rasplight;

-- Changement de scenario -> mise a jour de la table "rasplight"
-- Remarque la valeur de "scenario_id" doit exister dans la table "scenario"
UPDATE rasplight
SET scenario_id = , scenario_pid =
WHERE scenario_id = ;

-- Mise a jour d'une lampe
UPDATE light
SET light_state =, light_power =, light_xmin =, light_xmax =, light_ymin =, light_ymax =
WHERE light_id = ;

-- Suppression d'une lampe
-- Il faut d'abord supprimer les enregistrements dans la table "powerl"
DELETE FROM powerl WHERE light_id = ;
DELETE FROM light WHERE light_id = ;

#######################################

-- Suppression des tables
DROP TABLE IF EXISTS scenario, light, powerl, rasplight;

-- Suppression de la bdd
DROP DATABASE IF EXISTS dblight;

#######################################

-- Afficher les erreurs
SHOW WARNINGS;

-- Afficher le nom de toutes les tables présentent dans la bdd
SHOW TABLES;
