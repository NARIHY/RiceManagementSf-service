-- Trigger pour la table 'contact'
CREATE OR REPLACE TRIGGER contact_after_insert
AFTER INSERT ON contact
FOR EACH ROW
DECLARE
    v_details VARCHAR2(4000);
BEGIN
    -- Gestion des valeurs NULL avec NVL() (équivalent d'IFNULL en MySQL)
    v_details := 'Nouveau contact ajouté : ' ||
                 'Nom: ' || :NEW.name ||
                 ', Prénom: ' || :NEW.last_name ||
                 ', Email: ' || NVL(:NEW.email, 'non renseigné') ||
                 ', Numéro de téléphone: ' || NVL(:NEW.phone_number, 'non renseigné') ||
                 ', Date de création: ' || :NEW.creation_date;

    -- Insertion dans la table historique_temp
    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    ) VALUES (
        'contact',  
        'INSERT',   
        v_details,  
        SYSDATE      
    );
END;
/
