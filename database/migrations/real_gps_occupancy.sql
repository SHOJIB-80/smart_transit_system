-- Final Patch: Real GPS tracking + passenger occupancy.
-- Run this once against the existing smart_transit database if desired.
USE smart_transit;

CREATE TABLE IF NOT EXISTS bus_occupancy (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    bus_id INT UNSIGNED NOT NULL,
    passenger_id INT UNSIGNED NOT NULL,
    boarded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    exited_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (bus_id) REFERENCES buses(id) ON DELETE CASCADE,
    FOREIGN KEY (passenger_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_occupancy_bus_active (bus_id, exited_at),
    INDEX idx_occupancy_passenger_active (passenger_id, exited_at)
) ENGINE=InnoDB;

SET @has_accuracy = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='live_locations' AND COLUMN_NAME='accuracy'
);
SET @sql = IF(@has_accuracy=0,
    'ALTER TABLE live_locations ADD COLUMN accuracy DECIMAL(8,2) NULL AFTER longitude',
    'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @has_last_updated = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='live_locations' AND COLUMN_NAME='last_updated'
);
SET @sql = IF(@has_last_updated=0,
    'ALTER TABLE live_locations ADD COLUMN last_updated DATETIME NULL AFTER updated_at',
    'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

UPDATE live_locations SET last_updated=updated_at WHERE last_updated IS NULL;
ALTER TABLE live_locations MODIFY last_updated DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;
