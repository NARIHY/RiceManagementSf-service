DELIMITER //
CREATE TRIGGER user_after_insert 
AFTER INSERT ON user 
FOR EACH ROW 
BEGIN 
    INSERT INTO historique_temp (nom_table, action, details, date_action) 
    VALUES ('user', 'INSERT', CONCAT('Inscription d\'un utilisateur [ID: ', NEW.id, ', Email: ', NEW.email,']'), NOW()); 
END;
//
DELIMITER;
# Update 
DELIMITER //
CREATE TRIGGER user_after_update 
AFTER UPDATE ON user 
FOR EACH ROW 
BEGIN 
    INSERT INTO historique_temp (nom_table, action, details, date_action) 
    VALUES ('user', 'UPDATE', CONCAT('Mise à jour de l\'utilisateur [ID: ', NEW.id, ', Ancien email: ', OLD.email, ', Nouvel email: ', NEW.email,']'), NOW()); 
END;
//
DELIMITER ;
