TRUNCATE TABLE type_compte;


INSERT INTO type_compte (role, created_at, updated_at) VALUES
('Admin', NOW(), NOW()),
('Client', NOW(), NOW()),
('Modérateur', NOW(), NOW()),
('Invité', NOW(), NOW()),
('Super Admin', NOW(), NOW());
