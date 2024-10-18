CREATE TABLE historique (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_table VARCHAR(255),
    action VARCHAR(50),
    date_action DATETIME DEFAULT CURRENT_TIMESTAMP,
    details TEXT
);


# Créer une fonction pour générer des triggers
SELECT table_name 
FROM information_schema.tables 
WHERE table_schema = 'nice';


SET @sql = (
    SELECT GROUP_CONCAT(CONCAT(
        'CREATE TRIGGER ', table_name, '_after_insert AFTER INSERT ON ', table_name, ' FOR EACH ROW BEGIN INSERT INTO historique (nom_table, action, details) VALUES (\'', table_name, '\', \'INSERT\', CONCAT(\'Nouveau enregistrement ajouté avec ID: \', NEW.id)); END;'
    ) SEPARATOR ' ')
    FROM information_schema.tables 
    WHERE table_schema = 'nom_de_ta_base_de_données'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;


# trigger UPDATE et DELETE
SET @sql = (
    SELECT GROUP_CONCAT(CONCAT(
        'CREATE TRIGGER ', table_name, '_after_update AFTER UPDATE ON ', table_name, ' FOR EACH ROW BEGIN INSERT INTO historique (nom_table, action, details) VALUES (\'', table_name, '\', \'UPDATE\', CONCAT(\'Enregistrement modifié avec ID: \', NEW.id)); END; ',
        'CREATE TRIGGER ', table_name, '_after_delete AFTER DELETE ON ', table_name, ' FOR EACH ROW BEGIN INSERT INTO historique (nom_table, action, details) VALUES (\'', table_name, '\', \'DELETE\', CONCAT(\'Enregistrement supprimé avec ID: \', OLD.id)); END;'
    ) SEPARATOR ' ')
    FROM information_schema.tables 
    WHERE table_schema = 'nom_de_ta_base_de_données'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
