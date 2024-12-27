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

SELECT *
FROM users

GRANT INSERT ON dbo.users TO Diar;
GRANT SELECT ON dbo.users TO Diar;