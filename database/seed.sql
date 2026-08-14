USE smart_transit;

INSERT INTO users (name,email,phone,password,role,status) VALUES
('System Administrator','admin@smarttransit.com','01700000001','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC4Qh1fKc7z5Jv5wF6bK','admin','active'),
('Demo Driver','driver1@smarttransit.com','01700000002','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC4Qh1fKc7z5Jv5wF6bK','driver','active'),
('Demo Passenger','passenger@smarttransit.com','01700000003','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC4Qh1fKc7z5Jv5wF6bK','passenger','active')
ON DUPLICATE KEY UPDATE name=VALUES(name);

INSERT INTO buses (bus_number,registration_number,bus_type,capacity,women_only,status) VALUES
('ST-101','DHAKA-101','Standard',45,0,'active'),
('ST-102','DHAKA-102','AC Bus',40,0,'active'),
('ST-103','DHAKA-103','Standard',50,1,'active'),
('ST-104','DHAKA-104','Mini Bus',30,0,'maintenance'),
('ST-105','DHAKA-105','Standard',45,0,'active')
ON DUPLICATE KEY UPDATE bus_type=VALUES(bus_type);

INSERT INTO routes (route_name,route_code,starting_point,ending_point,description,status) VALUES
('Mirpur to Motijheel','R-01','Mirpur','Motijheel','Demonstration route from Mirpur toward Motijheel.','active'),
('Uttara to Farmgate','R-02','Uttara','Farmgate','Demonstration route from Uttara toward Farmgate.','active'),
('Mohammadpur to Gulistan','R-03','Mohammadpur','Gulistan','Demonstration route connecting Mohammadpur and Gulistan.','active'),
('Dhanmondi to Airport','R-04','Dhanmondi','Airport','Demonstration route from Dhanmondi toward the Airport.','active')
ON DUPLICATE KEY UPDATE description=VALUES(description);

INSERT INTO stops (route_id,stop_name,stop_order,latitude,longitude)
SELECT id,'Mirpur 10',1,NULL,NULL FROM routes WHERE route_code='R-01'
UNION ALL SELECT id,'Agargaon',2,NULL,NULL FROM routes WHERE route_code='R-01'
UNION ALL SELECT id,'Farmgate',3,NULL,NULL FROM routes WHERE route_code='R-01'
UNION ALL SELECT id,'Shahbag',4,NULL,NULL FROM routes WHERE route_code='R-01'
UNION ALL SELECT id,'Motijheel',5,NULL,NULL FROM routes WHERE route_code='R-01';

INSERT INTO stops (route_id,stop_name,stop_order,latitude,longitude)
SELECT id,'Uttara',1,NULL,NULL FROM routes WHERE route_code='R-02'
UNION ALL SELECT id,'Airport',2,NULL,NULL FROM routes WHERE route_code='R-02'
UNION ALL SELECT id,'Banani',3,NULL,NULL FROM routes WHERE route_code='R-02'
UNION ALL SELECT id,'Mohakhali',4,NULL,NULL FROM routes WHERE route_code='R-02'
UNION ALL SELECT id,'Farmgate',5,NULL,NULL FROM routes WHERE route_code='R-02';

INSERT INTO stops (route_id,stop_name,stop_order,latitude,longitude)
SELECT id,'Mohammadpur',1,NULL,NULL FROM routes WHERE route_code='R-03'
UNION ALL SELECT id,'Asad Gate',2,NULL,NULL FROM routes WHERE route_code='R-03'
UNION ALL SELECT id,'Dhanmondi',3,NULL,NULL FROM routes WHERE route_code='R-03'
UNION ALL SELECT id,'Shahbag',4,NULL,NULL FROM routes WHERE route_code='R-03'
UNION ALL SELECT id,'Gulistan',5,NULL,NULL FROM routes WHERE route_code='R-03';

INSERT INTO stops (route_id,stop_name,stop_order,latitude,longitude)
SELECT id,'Dhanmondi',1,NULL,NULL FROM routes WHERE route_code='R-04'
UNION ALL SELECT id,'Kalabagan',2,NULL,NULL FROM routes WHERE route_code='R-04'
UNION ALL SELECT id,'Farmgate',3,NULL,NULL FROM routes WHERE route_code='R-04'
UNION ALL SELECT id,'Mohakhali',4,NULL,NULL FROM routes WHERE route_code='R-04'
UNION ALL SELECT id,'Airport',5,NULL,NULL FROM routes WHERE route_code='R-04';

INSERT INTO schedules (route_id,bus_id,departure_time,arrival_time,operating_days,status)
SELECT r.id,b.id,'07:00:00','09:00:00','Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday','active'
FROM routes r JOIN buses b ON b.bus_number='ST-101' WHERE r.route_code='R-01'
UNION ALL
SELECT r.id,b.id,'08:00:00','09:30:00','Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday','active'
FROM routes r JOIN buses b ON b.bus_number='ST-102' WHERE r.route_code='R-02'
UNION ALL
SELECT r.id,b.id,'07:30:00','09:00:00','Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday','active'
FROM routes r JOIN buses b ON b.bus_number='ST-103' WHERE r.route_code='R-03'
UNION ALL
SELECT r.id,b.id,'06:30:00','08:30:00','Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday','active'
FROM routes r JOIN buses b ON b.bus_number='ST-105' WHERE r.route_code='R-04';

INSERT INTO notices (title,message,notice_type,priority,status) VALUES
('Welcome to SmartTransit','This is a demonstration service notice for Part 1 of the project.','information','low','active'),
('Route information is demonstrational','The routes and stops currently shown are sample data and are not official transport authority information.','warning','medium','active'),
('Future emergency alerts','The full emergency management workflow will be added in a later development stage.','information','low','active');
