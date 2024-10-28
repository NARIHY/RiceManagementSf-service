
DELIMITER //

CREATE TRIGGER arrival_after_insert 
AFTER INSERT ON arrival 
FOR EACH ROW 
BEGIN 
    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'arrival', 
        'INSERT', 
        CONCAT('Nouveau enregistrement ajouté avec ID: ', NEW.id, 
               ', Bag ID: ', NEW.bag_id, 
               ', Nom de l\'étiquette: ', NEW.label_name, 
               ', Date d\'arrivée: ', NEW.arrival_date, 
               ', Prix du bagage: ', NEW.bag_price), 
        NOW()
    ); 
END;

//

#
DELIMITER //

CREATE TRIGGER bag_after_insert 
AFTER INSERT ON bag 
FOR EACH ROW 
BEGIN 
    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'bag', 
        'INSERT', 
        CONCAT('Nouveau enregistrement ajouté avec ID: ', NEW.id, 
               ', Quantité: ', NEW.quantity, 
               ', Date de création: ', NOW()), 
        NOW()
    ); 
END;

//

#
DELIMITER //

CREATE TRIGGER client_after_insert 
AFTER INSERT ON client 
FOR EACH ROW 
BEGIN 
    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'client', 
        'INSERT', 
        CONCAT('Nouveau enregistrement ajouté avec ID: ', NEW.id, 
               ', Nom: ', NEW.name, 
               ', Prénom: ', NEW.last_name, 
               ', CIN: ', NEW.cin, 
               ', Adresse: ', NEW.address), 
        NOW()
    ); 
END;

//


#
DELIMITER //

CREATE TRIGGER status_after_insert 
AFTER INSERT ON status 
FOR EACH ROW 
BEGIN 
    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'status', 
        'INSERT', 
        CONCAT('Nouveau enregistrement ajouté avec ID: ', NEW.id, 
               ', Nom du statut: ', NEW.status_name), 
        NOW()
    ); 
END;

//

#

DELIMITER //

CREATE TRIGGER stock_after_insert 
AFTER INSERT ON stock 
FOR EACH ROW 
BEGIN 
    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'stock', 
        'INSERT', 
        CONCAT('Nouveau enregistrement ajouté avec ID: ', NEW.id, 
               ', Quantité disponible: ', NEW.aivalable_quantity), 
        NOW()
    ); 
END;

//

#

DELIMITER //

CREATE TRIGGER typerice_after_insert 
AFTER INSERT ON typerice 
FOR EACH ROW 
BEGIN 
    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'typerice', 
        'INSERT', 
        CONCAT('Nouveau enregistrement ajouté avec ID: ', NEW.id, 
               ', Nom du riz: ', NEW.rice_name, 
               ', Description: ', NEW.description), 
        NOW()
    ); 
END;

//

