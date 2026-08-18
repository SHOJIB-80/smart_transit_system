USE smart_transit;

-- Part 4 authentication repair.
-- Safely resets ONLY the existing demo admin (ID 1) and driver (ID 2).
-- Passwords are bcrypt hashes generated with PHP password_hash(PASSWORD_DEFAULT).
UPDATE users
SET email = 'admin@smarttransit.com',
    password = '$2y$12$S.brbJLXvqllj/j9NTVM4ONXm3lYT0CLDgq4IwJDhGyuRagWzbyCW',
    role = 'admin',
    status = 'active'
WHERE id = 1;

UPDATE users
SET email = 'driver@smarttransit.com',
    password = '$2y$12$FI3DtIBkGXqCkQBVo/G0h.4wJGrCiwaeAAdG46yWHt6JS0fBHBo42',
    role = 'driver',
    status = 'active'
WHERE id = 2;
