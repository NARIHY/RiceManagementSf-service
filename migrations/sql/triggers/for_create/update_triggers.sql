DELIMITER //

CREATE TRIGGER arrival_after_update AFTER UPDATE ON arrival 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('arrival', 'UPDATE', CONCAT('Enregistrement mis à jour avec ID: ', NEW.id)); 
END;
//

CREATE TRIGGER bag_after_update AFTER UPDATE ON bag 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('bag', 'UPDATE', CONCAT('Enregistrement mis à jour avec ID: ', NEW.id)); 
END;
//

CREATE TRIGGER client_after_update AFTER UPDATE ON client 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('client', 'UPDATE', CONCAT('Enregistrement mis à jour avec ID: ', NEW.id)); 
END;
//

CREATE TRIGGER doctrine_migration_versions_after_update AFTER UPDATE ON doctrine_migration_versions 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('doctrine_migration_versions', 'UPDATE', CONCAT('Enregistrement mis à jour avec ID: ', NEW.id)); 
END;
//

CREATE TRIGGER gender_management_after_update AFTER UPDATE ON gender_management 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('gender_management', 'UPDATE', CONCAT('Enregistrement mis à jour avec ID: ', NEW.id)); 
END;
//

CREATE TRIGGER historique_after_update AFTER UPDATE ON historique 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('historique', 'UPDATE', CONCAT('Enregistrement mis à jour avec ID: ', NEW.id)); 
END;
//

CREATE TRIGGER status_after_update AFTER UPDATE ON status 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('status', 'UPDATE', CONCAT('Enregistrement mis à jour avec ID: ', NEW.id)); 
END;
//

CREATE TRIGGER stock_after_update AFTER UPDATE ON stock 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('stock', 'UPDATE', CONCAT('Enregistrement mis à jour avec ID: ', NEW.id)); 
END;
//

CREATE TRIGGER typerice_after_update AFTER UPDATE ON typerice 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('typerice', 'UPDATE', CONCAT('Enregistrement mis à jour avec ID: ', NEW.id)); 
END;
//

CREATE TRIGGER type_compte_after_update AFTER UPDATE ON type_compte 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details) VALUES ('type_compte', 'UPDATE', CONCAT('Enregistrement mis à jour avec ID: ', NEW.id)); 
END;
//

