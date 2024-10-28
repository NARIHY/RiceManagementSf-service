DELIMITER //

CREATE TRIGGER arrival_after_update 
AFTER UPDATE ON arrival 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details, date_action) VALUES (
        'arrival', 
        'UPDATE', 
        CONCAT('Enregistrement mis à jour avec ID: ', NEW.id, 
               ', Ancien statut: ', OLD.status_id, 
               ', Nouveau statut: ', NEW.status_id), 
        NOW()
    ); 
END;
//

CREATE TRIGGER bag_after_update 
AFTER UPDATE ON bag 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details, date_action) VALUES (
        'bag', 
        'UPDATE', 
        CONCAT('Enregistrement mis à jour avec ID: ', NEW.id, 
               ', Ancienne quantité: ', OLD.quantity, 
               ', Nouvelle quantité: ', NEW.quantity), 
        NOW()
    ); 
END;
//

CREATE TRIGGER client_after_update 
AFTER UPDATE ON client 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details, date_action) VALUES (
        'client', 
        'UPDATE', 
        CONCAT('Enregistrement mis à jour avec ID: ', NEW.id, 
               ', Ancien nom: ', OLD.name, 
               ', Nouveau nom: ', NEW.name), 
        NOW()
    ); 
END;
//

CREATE TRIGGER status_after_update 
AFTER UPDATE ON status 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details, date_action) VALUES (
        'status', 
        'UPDATE', 
        CONCAT('Enregistrement mis à jour avec ID: ', NEW.id, 
               ', Ancien nom du statut: ', OLD.status_name, 
               ', Nouveau nom du statut: ', NEW.status_name), 
        NOW()
    ); 
END;
//

CREATE TRIGGER stock_after_update 
AFTER UPDATE ON stock 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details, date_action) VALUES (
        'stock', 
        'UPDATE', 
        CONCAT('Enregistrement mis à jour avec ID: ', NEW.id, 
               ', Ancienne quantité disponible: ', OLD.aivalable_quantity, 
               ', Nouvelle quantité disponible: ', NEW.aivalable_quantity), 
        NOW()
    ); 
END;
//

CREATE TRIGGER typerice_after_update 
AFTER UPDATE ON typerice 
FOR EACH ROW BEGIN 
    INSERT INTO historique_temp (nom_table, action, details, date_action) VALUES (
        'typerice', 
        'UPDATE', 
        CONCAT('Enregistrement mis à jour avec ID: ', NEW.id, 
               ', Ancien nom du riz: ', OLD.rice_name, 
               ', Nouveau nom du riz: ', NEW.rice_name), 
        NOW()
    ); 
END;
//

DELIMITER ;
