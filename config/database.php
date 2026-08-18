<?php
// XAMPP/MySQL configuration. Change only these values if your setup differs.
$host = 'localhost';
$db   = 'smart_transit';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Idempotent Part 2/3 extension. Existing tables/data are preserved.
    $pdo->exec("CREATE TABLE IF NOT EXISTS driver_assignments (
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
    ) ENGINE=InnoDB");

    $pdo->exec("CREATE TABLE IF NOT EXISTS trips (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        bus_id INT UNSIGNED NOT NULL,
        driver_id INT UNSIGNED NOT NULL,
        route_id INT UNSIGNED NOT NULL,
        start_time DATETIME NOT NULL,
        end_time DATETIME NULL,
        status ENUM('scheduled','active','completed','cancelled') NOT NULL DEFAULT 'scheduled',
        FOREIGN KEY (bus_id) REFERENCES buses(id) ON DELETE CASCADE,
        FOREIGN KEY (driver_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE,
        INDEX idx_trip_status(status),
        INDEX idx_trip_bus(bus_id)
    ) ENGINE=InnoDB");

    $pdo->exec("CREATE TABLE IF NOT EXISTS live_locations (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        bus_id INT UNSIGNED NOT NULL,
        route_id INT UNSIGNED NOT NULL,
        latitude DECIMAL(10,7) NOT NULL,
        longitude DECIMAL(10,7) NOT NULL,
        status ENUM('on_route','stopped','offline','emergency') NOT NULL DEFAULT 'on_route',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (bus_id) REFERENCES buses(id) ON DELETE CASCADE,
        FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE,
        INDEX idx_live_bus(bus_id),
        INDEX idx_live_updated(updated_at)
    ) ENGINE=InnoDB");

    $pdo->exec("CREATE TABLE IF NOT EXISTS vehicle_conditions (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        bus_id INT UNSIGNED NOT NULL,
        driver_id INT UNSIGNED NOT NULL,
        condition_status ENUM('Good','Needs Attention','Maintenance Required') NOT NULL,
        notes VARCHAR(500) NULL,
        reported_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (bus_id) REFERENCES buses(id) ON DELETE CASCADE,
        FOREIGN KEY (driver_id) REFERENCES users(id) ON DELETE CASCADE,
        INDEX idx_condition_bus(bus_id),
        INDEX idx_condition_date(reported_at)
    ) ENGINE=InnoDB");

    $pdo->exec("CREATE TABLE IF NOT EXISTS emergency_reports (
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
        FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE,
        INDEX idx_emergency_status(status),
        INDEX idx_emergency_severity(severity)
    ) ENGINE=InnoDB");

    $pdo->exec("CREATE TABLE IF NOT EXISTS activity_logs (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED NULL,
        action VARCHAR(150) NOT NULL,
        entity_type VARCHAR(50) NULL,
        entity_id INT UNSIGNED NULL,
        details VARCHAR(500) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
        INDEX idx_activity_date(created_at)
    ) ENGINE=InnoDB");
    // Final patch: passenger occupancy / boarding records.
    $pdo->exec("CREATE TABLE IF NOT EXISTS bus_occupancy (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        bus_id INT UNSIGNED NOT NULL,
        passenger_id INT UNSIGNED NOT NULL,
        boarded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        exited_at TIMESTAMP NULL DEFAULT NULL,
        FOREIGN KEY (bus_id) REFERENCES buses(id) ON DELETE CASCADE,
        FOREIGN KEY (passenger_id) REFERENCES users(id) ON DELETE CASCADE,
        INDEX idx_occupancy_bus_active (bus_id, exited_at),
        INDEX idx_occupancy_passenger_active (passenger_id, exited_at)
    ) ENGINE=InnoDB");

    // Add GPS accuracy/explicit last_updated fields to the existing live location table.
    $cols = $pdo->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
                         WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'live_locations'")
                 ->fetchAll(PDO::FETCH_COLUMN);
    if (!in_array('accuracy', $cols, true)) {
        $pdo->exec("ALTER TABLE live_locations ADD COLUMN accuracy DECIMAL(8,2) NULL AFTER longitude");
    }
    if (!in_array('last_updated', $cols, true)) {
        $pdo->exec("ALTER TABLE live_locations ADD COLUMN last_updated DATETIME NULL AFTER updated_at");
        $pdo->exec("UPDATE live_locations SET last_updated = updated_at WHERE last_updated IS NULL");
        $pdo->exec("ALTER TABLE live_locations MODIFY last_updated DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
    }


} catch (PDOException $e) {
    die("Database connection failed. Please check config/database.php and make sure MySQL is running.");
}
?>
