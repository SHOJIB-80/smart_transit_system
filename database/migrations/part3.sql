
/* Part 2 + Part 3 extension tables. Safe for existing installations. */
CREATE TABLE IF NOT EXISTS driver_assignments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    driver_id INT UNSIGNED NOT NULL,
    bus_id INT UNSIGNED NOT NULL,
    route_id INT UNSIGNED NOT NULL,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY active_driver (driver_id,status),
    UNIQUE KEY active_bus (bus_id,status),
    FOREIGN KEY (driver_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (bus_id) REFERENCES buses(id) ON DELETE CASCADE,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS trips (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    bus_id INT UNSIGNED NOT NULL,
    driver_id INT UNSIGNED NOT NULL,
    route_id INT UNSIGNED NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NULL,
    status ENUM('scheduled','active','completed','cancelled') NOT NULL DEFAULT 'scheduled',
    FOREIGN KEY (bus_id) REFERENCES buses(id) ON DELETE CASCADE,
    FOREIGN KEY (driver_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS live_locations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    bus_id INT UNSIGNED NOT NULL,
    route_id INT UNSIGNED NOT NULL,
    latitude DECIMAL(10,7) NOT NULL,
    longitude DECIMAL(10,7) NOT NULL,
    status ENUM('on_route','stopped','offline','emergency') NOT NULL DEFAULT 'on_route',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (bus_id) REFERENCES buses(id) ON DELETE CASCADE,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS vehicle_conditions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    bus_id INT UNSIGNED NOT NULL,
    driver_id INT UNSIGNED NOT NULL,
    condition_status ENUM('Good','Needs Attention','Maintenance Required') NOT NULL,
    notes VARCHAR(500) NULL,
    reported_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bus_id) REFERENCES buses(id) ON DELETE CASCADE,
    FOREIGN KEY (driver_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS emergency_reports (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    driver_id INT UNSIGNED NOT NULL,
    bus_id INT UNSIGNED NOT NULL,
    route_id INT UNSIGNED NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    severity ENUM('Low','Medium','High','Critical') NOT NULL DEFAULT 'Medium',
    status ENUM('New','Investigating','Resolved') NOT NULL DEFAULT 'New',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    resolved_at DATETIME NULL,
    FOREIGN KEY (driver_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (bus_id) REFERENCES buses(id) ON DELETE CASCADE,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS activity_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NULL,
    action VARCHAR(150) NOT NULL,
    entity_type VARCHAR(50) NULL,
    entity_id INT UNSIGNED NULL,
    details VARCHAR(500) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

/* Demo driver assignment for Part 2/3 */
INSERT INTO driver_assignments (driver_id,bus_id,route_id,status)
SELECT u.id,b.id,r.id,'active'
FROM users u JOIN buses b ON b.bus_number='ST-101' JOIN routes r ON r.route_code='R-01'
WHERE u.email='driver1@smarttransit.com'
ON DUPLICATE KEY UPDATE route_id=VALUES(route_id), status='active';
