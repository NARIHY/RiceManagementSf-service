-- Trigger pour la table 'arrival'
CREATE OR REPLACE TRIGGER arrival_after_insert
AFTER INSERT ON arrival
FOR EACH ROW
DECLARE
    v_details VARCHAR2(4000);
BEGIN
    v_details := 'Nouveau enregistrement ajouté avec ID: ' || :NEW.id ||
                 ', Bag ID: ' || :NEW.bag_id ||
                 ', Nom de l''étiquette: ' || :NEW.label_name ||
                 ', Date d''arrivée: ' || :NEW.arrival_date ||
                 ', Prix du bagage: ' || :NEW.bag_price;

    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'arrival', 
        'INSERT', 
        v_details, 
        SYSDATE
    );
END;
/

-- Trigger pour la table 'bag'
CREATE OR REPLACE TRIGGER bag_after_insert
AFTER INSERT ON bag
FOR EACH ROW
DECLARE
    v_details VARCHAR2(4000);
BEGIN
    v_details := 'Nouveau enregistrement ajouté avec ID: ' || :NEW.id ||
                 ', Quantité: ' || :NEW.quantity ||
                 ', Date de création: ' || SYSDATE;

    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'bag', 
        'INSERT', 
        v_details, 
        SYSDATE
    );
END;
/

-- Trigger pour la table 'client'
CREATE OR REPLACE TRIGGER client_after_insert
AFTER INSERT ON client
FOR EACH ROW
DECLARE
    v_details VARCHAR2(4000);
BEGIN
    v_details := 'Nouveau enregistrement ajouté avec ID: ' || :NEW.id ||
                 ', Nom: ' || :NEW.name ||
                 ', Prénom: ' || :NEW.last_name ||
                 ', CIN: ' || :NEW.cin ||
                 ', Adresse: ' || :NEW.address;

    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'client', 
        'INSERT', 
        v_details, 
        SYSDATE
    );
END;
/

-- Trigger pour la table 'status'
CREATE OR REPLACE TRIGGER status_after_insert
AFTER INSERT ON status
FOR EACH ROW
DECLARE
    v_details VARCHAR2(4000);
BEGIN
    v_details := 'Nouveau enregistrement ajouté avec ID: ' || :NEW.id ||
                 ', Nom du statut: ' || :NEW.status_name;

    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'status', 
        'INSERT', 
        v_details, 
        SYSDATE
    );
END;
/

-- Trigger pour la table 'stock'
CREATE OR REPLACE TRIGGER stock_after_insert
AFTER INSERT ON stock
FOR EACH ROW
DECLARE
    v_details VARCHAR2(4000);
BEGIN
    v_details := 'Nouveau enregistrement ajouté avec ID: ' || :NEW.id ||
                 ', Quantité disponible: ' || :NEW.aivalable_quantity;

    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'stock', 
        'INSERT', 
        v_details, 
        SYSDATE
    );
END;
/

-- Trigger pour la table 'typerice'
CREATE OR REPLACE TRIGGER typerice_after_insert
AFTER INSERT ON typerice
FOR EACH ROW
DECLARE
    v_details VARCHAR2(4000);
BEGIN
    v_details := 'Nouveau enregistrement ajouté avec ID: ' || :NEW.id ||
                 ', Nom du riz: ' || :NEW.rice_name ||
                 ', Description: ' || :NEW.description;

    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'typerice', 
        'INSERT', 
        v_details, 
        SYSDATE
    );
END;
/
