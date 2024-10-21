
DELIMITER //
CREATE TRIGGER arrival_after_insert AFTER INSERT ON arrival 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('arrival', 'INSERT', CONCAT('Nouveau enregistrement ajouté avec ID: ', NEW.id)); 
END;
//
DELIMITER //
CREATE TRIGGER bag_after_insert AFTER INSERT ON bag 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('bag', 'INSERT', CONCAT('Nouveau enregistrement ajouté avec ID: ', NEW.id)); 
END;
//
DELIMITER //
CREATE TRIGGER client_after_insert AFTER INSERT ON client 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('client', 'INSERT', CONCAT('Nouveau enregistrement ajouté avec ID: ', NEW.id)); 
END;
//
DELIMITER //
CREATE TRIGGER doctrine_migration_versions_after_insert AFTER INSERT ON doctrine_migration_versions 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('doctrine_migration_versions', 'INSERT', CONCAT('Nouveau enregistrement ajouté avec ID: ', NEW.id)); 
END;
//
DELIMITER //
CREATE TRIGGER gender_management_after_insert AFTER INSERT ON gender_management 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('gender_management', 'INSERT', CONCAT('Nouveau enregistrement ajouté avec ID: ', NEW.id)); 
END;
//
DELIMITER //
CREATE TRIGGER historique_after_insert AFTER INSERT ON historique 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('historique', 'INSERT', CONCAT('Nouveau enregistrement ajouté avec ID: ', NEW.id)); 
END;
//
DELIMITER //
CREATE TRIGGER status_after_insert AFTER INSERT ON status 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('status', 'INSERT', CONCAT('Nouveau enregistrement ajouté avec ID: ', NEW.id)); 
END;
//
DELIMITER //
CREATE TRIGGER stock_after_insert AFTER INSERT ON stock 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('stock', 'INSERT', CONCAT('Nouveau enregistrement ajouté avec ID: ', NEW.id)); 
END;
//
DELIMITER //
CREATE TRIGGER typerice_after_insert AFTER INSERT ON typerice 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('typerice', 'INSERT', CONCAT('Nouveau enregistrement ajouté avec ID: ', NEW.id)); 
END;
//
DELIMITER //
CREATE TRIGGER type_compte_after_insert AFTER INSERT ON type_compte 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('type_compte', 'INSERT', CONCAT('Nouveau enregistrement ajouté avec ID: ', NEW.id)); 
END;
//