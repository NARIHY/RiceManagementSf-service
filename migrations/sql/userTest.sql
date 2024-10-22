# Adding new user  
INSERT INTO user (email,roles,password, created_at, updated_at) VALUES 
('test@narihy.mg','["ROLE_CLIENT"]', '$2y$13$53/sTEBSQCV/4xITqVo8furweb/6YIa4qkKGyDpkzFH43A0AO9Uja', NOW(), NOW());

SELECT * from user;