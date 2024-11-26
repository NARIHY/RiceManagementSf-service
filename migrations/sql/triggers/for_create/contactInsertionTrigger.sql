DELIMITER //

CREATE TRIGGER contact_after_insert
AFTER INSERT ON contact
FOR EACH ROW
BEGIN
    INSERT INTO historique_temp (
        nom_table, 
        action, 
        details, 
        date_action
    )
    VALUES (
        'contact',  
        'INSERT',   
        CONCAT(
            'Nouveau contact ajouté : ', 
            'Nom: ', NEW.name, 
            ', Prénom: ', NEW.last_name, 
            ', Email: ', IFNULL(NEW.email, 'non renseigné'), 
            ', Numéro de téléphone: ', IFNULL(NEW.phone_number, 'non renseigné'), 
            ', Date de création: ', NEW.creation_date
        ),  
        NOW()      
    );
END;

//
DELIMITER ;
