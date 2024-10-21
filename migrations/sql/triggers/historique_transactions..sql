
# Créer une fonction pour générer des triggers
SELECT table_name 
FROM information_schema.tables 
WHERE table_schema = 'rice';


SET @sql = (
    SELECT GROUP_CONCAT(CONCAT(
        'CREATE TRIGGER ', table_name, '_after_insert AFTER INSERT ON ', table_name, ' FOR EACH ROW BEGIN INSERT INTO historique (nom_table, action, details) VALUES (\'', table_name, '\', \'INSERT\', CONCAT(\'Nouveau enregistrement ajouté avec ID: \', NEW.id)); END;'
    ) SEPARATOR ' ')
    FROM information_schema.tables 
    WHERE table_schema = 'nom_de_ta_base_de_données'
);
# Ok pour le haut
# trigger UPDATE et DELETE
SET @sql = (
    SELECT GROUP_CONCAT(CONCAT(
        'CREATE TRIGGER ', table_name, '_after_update AFTER UPDATE ON ', table_name, ' FOR EACH ROW BEGIN INSERT INTO historique (nom_table, action, details) VALUES (\'', table_name, '\', \'UPDATE\', CONCAT(\'Enregistrement modifié avec ID: \', NEW.id)); END; ',
        'CREATE TRIGGER ', table_name, '_after_delete AFTER DELETE ON ', table_name, ' FOR EACH ROW BEGIN INSERT INTO historique (nom_table, action, details) VALUES (\'', table_name, '\', \'DELETE\', CONCAT(\'Enregistrement supprimé avec ID: \', OLD.id)); END;'
    ) SEPARATOR ' ')
    FROM information_schema.tables 
    WHERE table_schema = 'nom_de_ta_base_de_données'
);
