# Smart Transit Navigation System — Part 1

University CSE project foundation using HTML5, CSS3, Vanilla JavaScript, PHP and MySQL.

## Requirements
- XAMPP (Apache + MySQL + PHP)
- Modern web browser

## Installation
1. Copy the `smart-transit` folder into `C:\xampp\htdocs\`.
2. Start Apache and MySQL from XAMPP.
3. Open phpMyAdmin.
4. Import `database/schema.sql`.
5. Import `database/seed.sql`.
6. Check `config/database.php` and update credentials if your MySQL setup is different.
7. Open `http://localhost/smart-transit/`.

## Demo accounts
The seed uses the password:

`password`

Accounts:
- admin@smarttransit.com
- driver1@smarttransit.com
- passenger@smarttransit.com

Change these credentials for any real deployment.

## Part 1 features
- Responsive landing page
- Passenger registration/login/logout
- PHP sessions and role authorization
- MySQL database
- Passenger dashboard
- Routes and route details
- Bus list and details
- Schedule filtering
- Notices
- Driver/admin authentication foundations
- JSON API foundation
- Demo data
- CSRF token on authentication forms
- Prepared SQL statements and output escaping

## Future parts
Part 2: Leaflet/OpenStreetMap, maps, live tracking, GPS, ETA and full driver workflow.

Part 3: Full admin dashboard and management.

Part 4: Integration, notifications, security improvements, testing and final polish.

## Important
The route, bus and stop data are demonstration data. They are not official transport authority data.
