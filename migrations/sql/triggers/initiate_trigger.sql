CREATE TABLE historique_temp (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_table VARCHAR(255),
    action VARCHAR(10),
    details TEXT,
    date_action DATETIME DEFAULT CURRENT_TIMESTAMP
);