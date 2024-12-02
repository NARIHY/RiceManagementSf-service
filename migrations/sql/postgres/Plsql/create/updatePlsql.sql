-- Trigger pour la table 'arrival'
CREATE OR REPLACE TRIGGER arrival_after_update
AFTER UPDATE ON arrival
FOR EACH ROW
DECLARE
    v_details VARCHAR2(4000);
BEGIN
    v_details := 'Enregistrement mis à jour avec ID: ' || :NEW.id ||
                 ', Ancien statut: ' || :OLD.status_id ||
                 ', Nouveau statut: ' || :NEW.status_id;

    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'arrival', 
        'UPDATE', 
        v_details, 
        SYSDATE
    );
END;
/

-- Trigger pour la table 'bag'
CREATE OR REPLACE TRIGGER bag_after_update
AFTER UPDATE ON bag
FOR EACH ROW
DECLARE
    v_details VARCHAR2(4000);
BEGIN
    v_details := 'Enregistrement mis à jour avec ID: ' || :NEW.id ||
                 ', Ancienne quantité: ' || :OLD.quantity ||
                 ', Nouvelle quantité: ' || :NEW.quantity;

    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'bag', 
        'UPDATE', 
        v_details, 
        SYSDATE
    );
END;
/

-- Trigger pour la table 'client'
CREATE OR REPLACE TRIGGER client_after_update
AFTER UPDATE ON client
FOR EACH ROW
DECLARE
    v_details VARCHAR2(4000);
BEGIN
    v_details := 'Enregistrement mis à jour avec ID: ' || :NEW.id ||
                 ', Ancien nom: ' || :OLD.name ||
                 ', Nouveau nom: ' || :NEW.name;

    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'client', 
        'UPDATE', 
        v_details, 
        SYSDATE
    );
END;
/

-- Trigger pour la table 'status'
CREATE OR REPLACE TRIGGER status_after_update
AFTER UPDATE ON status
FOR EACH ROW
DECLARE
    v_details VARCHAR2(4000);
BEGIN
    v_details := 'Enregistrement mis à jour avec ID: ' || :NEW.id ||
                 ', Ancien nom du statut: ' || :OLD.status_name ||
                 ', Nouveau nom du statut: ' || :NEW.status_name;

    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'status', 
        'UPDATE', 
        v_details, 
        SYSDATE
    );
END;
/

-- Trigger pour la table 'stock'
CREATE OR REPLACE TRIGGER stock_after_update
AFTER UPDATE ON stock
FOR EACH ROW
DECLARE
    v_details VARCHAR2(4000);
BEGIN
    v_details := 'Enregistrement mis à jour avec ID: ' || :NEW.id ||
                 ', Ancienne quantité disponible: ' || :OLD.aivalable_quantity ||
                 ', Nouvelle quantité disponible: ' || :NEW.aivalable_quantity;

    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'stock', 
        'UPDATE', 
        v_details, 
        SYSDATE
    );
END;
/

-- Trigger pour la table 'typerice'
CREATE OR REPLACE TRIGGER typerice_after_update
AFTER UPDATE ON typerice
FOR EACH ROW
DECLARE
    v_details VARCHAR2(4000);
BEGIN
    v_details := 'Enregistrement mis à jour avec ID: ' || :NEW.id ||
                 ', Ancien nom du riz: ' || :OLD.rice_name ||
                 ', Nouveau nom du riz: ' || :NEW.rice_name;

    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'typerice', 
        'UPDATE', 
        v_details, 
        SYSDATE
    );
END;
/
