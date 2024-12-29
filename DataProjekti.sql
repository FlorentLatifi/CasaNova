CREATE DATABASE Projekti

use Projekti

CREATE TABLE users (
    id INT PRIMARY KEY IDENTITY(1,1),
    emri VARCHAR(100),
    mbiemri VARCHAR(100),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    role VARCHAR(50) CHECK (role IN ('USER', 'ADMIN')),
    created_at DATETIME DEFAULT GETDATE()
);
UPDATE users
SET role = 'admin' 
WHERE role = 'ADMIN';

CREATE TABLE roles (
    id INT PRIMARY KEY IDENTITY(1,1),
    name VARCHAR(50) UNIQUE NOT NULL
);
INSERT INTO roles (name) VALUES ('USER'), ('admin'), ('SUPERADMIN');

ALTER TABLE users ADD role_id INT;

-- Shto lidhjen 'FOREIGN KEY'
ALTER TABLE users
ADD CONSTRAINT fk_role FOREIGN KEY (role_id) REFERENCES roles(id);

-- Hiq kolonën ekzistuese 'role' nëse nuk është më e nevojshme
ALTER TABLE users DROP COLUMN role;

SELECT *
FROM users

GRANT INSERT ON dbo.users TO Diar;
GRANT SELECT ON dbo.users TO Diar;

SELECT name 
FROM sys.check_constraints 
WHERE parent_object_id = OBJECT_ID('users') AND definition LIKE '%role%';

ALTER TABLE users DROP CONSTRAINT CK__users__role__38996AB5;

ALTER TABLE users ADD CONSTRAINT fk_role FOREIGN KEY (role_id) REFERENCES roles(id);

ALTER TABLE users DROP CONSTRAINT fk_role;

UPDATE users
SET role_id = (SELECT id FROM roles WHERE name = users.role);

select* 
from roles

UPDATE users
SET role_id = (SELECT id FROM roles WHERE name = 'SUPERADMIN')
WHERE email = 'diarcanhasi@hotmail.com';

GRANT INSERT ON dbo.roles TO Diar;
GRANT SELECT ON dbo.roles TO Diar;