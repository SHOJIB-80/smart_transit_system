# 🚌 Smart Transit Navigation System

A modern, full-stack PHP web application for managing public transportation. Features real-time bus tracking, driver management, passenger bookings, and emergency reporting capabilities with a responsive, professional UI.

**Status**: 🟢 Active Development | **Last Updated**: August 2026

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Quick Start](#quick-start)
- [Project Structure](#project-structure)
- [Database Schema](#database-schema)
- [Authentication](#authentication)
- [API Endpoints](#api-endpoints)
- [Key Improvements](#key-improvements)
- [Troubleshooting](#troubleshooting)
- [License](#license)

---

## 🎯 Overview

Smart Transit Navigation System is a comprehensive transportation management platform designed for educational purposes and real-world deployment. It provides:

- **Multi-role access control** (Admin, Driver, Passenger)
- **Real-time GPS tracking** for buses
- **Live location updates** with accuracy metrics
- **Emergency reporting** system for drivers
- **Vehicle condition monitoring**
- **Trip management** with detailed logging
- **Passenger occupancy tracking**
- **Comprehensive activity logging**
- **Professional, responsive UI** with modern design patterns

The system is built with PHP, MySQL, and vanilla JavaScript, utilizing PDO prepared statements for security and optimized database schema with proper indexing.

---

## ✨ Features

### 🔐 Authentication & Authorization
- Secure user registration and login with session management
- Role-based access control (Admin, Driver, Passenger)
- CSRF token protection on all forms
- Session regeneration on login
- Password verification using PHP password functions
- User status management (active/inactive)

### 📍 Real-Time Tracking
- **Live location updates** with GPS coordinates (latitude, longitude)
- **Accuracy metrics** for location precision
- **Bus status indicators** (on_route, stopped, offline, emergency)
- **Timestamps** for location updates
- Database-backed tracking for persistence

### 🚗 Driver Features
- Driver authentication and profile management
- Route assignment interface
- Active trip tracking
- **Emergency reporting** system
  - Severity levels (Low, Medium, High, Critical)
  - Status tracking (New, Investigating, Resolved)
  - Automatic logging with timestamps
- **Vehicle condition reports**
  - Pre-trip vehicle condition assessment
  - Condition status (Good, Needs Attention, Maintenance Required)
  - Notes and detailed reporting
- Passenger management on assigned routes
- Schedule tracking and trip history

### 👤 Passenger Features
- Browse available routes and real-time schedules
- View detailed bus information and specifications
- Track live bus locations on routes
- Advanced route search and filtering
- Booking management interface
- Passenger occupancy tracking (boarding/exiting)
- Favorite routes management
- System announcements and notices

### 👨‍💼 Admin Features
- Comprehensive dashboard with system overview
- Bus fleet management and specifications
- Route creation and management
- User management and role assignment
- Activity monitoring and logging
- Emergency report management
- System-wide statistics and analytics
- Configuration management

### 📊 Data Management
- **Driver Assignments**: Track active driver-bus-route assignments
- **Trips**: Full trip lifecycle management (scheduled → active → completed/cancelled)
- **Live Locations**: Real-time GPS updates with accuracy tracking
- **Vehicle Conditions**: Pre-trip and ongoing condition monitoring
- **Emergency Reports**: Critical incident tracking and resolution
- **Activity Logs**: Comprehensive audit trail of all system actions
- **Bus Occupancy**: Passenger boarding and exit tracking
- 100+ pre-configured demo records

### 🎨 Frontend
- Modern, responsive landing page with animations
- Mobile-optimized design (works on all screen sizes)
- Professional color scheme and visual hierarchy
- Smooth scrolling and interactive elements
- Accessibility-focused design
- Floating card animations and visual effects
- Professional dashboard layouts for each user role

---

## 🛠️ Tech Stack

| Component | Technology | Notes |
|-----------|-----------|-------|
| **Frontend** | HTML5, CSS3, Vanilla JavaScript | Responsive, no framework dependencies |
| **Backend** | PHP 7.0+ | PDO with prepared statements |
| **Database** | MySQL 5.7+ | Normalized schema with indexes |
| **Server** | Apache (XAMPP) | .htaccess configuration included |
| **Sessions** | PHP Sessions | Secure server-side storage |
| **Security** | Password hashing, CSRF tokens | Best practices implemented |

---

## 🚀 Quick Start

### Prerequisites
- **XAMPP** (Apache, MySQL, PHP 7.0+) - [Download](https://www.apachefriends.org/)
- **Modern browser** (Chrome 90+, Firefox 88+, Safari 14+, Edge 90+)
- **Disk space**: ~200MB
- **RAM**: 2GB minimum

### Installation Steps

#### 1. Clone Repository
```bash
git clone https://github.com/SHOJIB-80/smart_transit_system.git
cd smart_transit_system
```

#### 2. Move to XAMPP
- **Windows**: Copy folder to `C:\xampp\htdocs\smart_transit_system`
- **Linux**: Copy folder to `/opt/lampp/htdocs/smart_transit_system`
- **macOS**: Copy folder to `/Applications/XAMPP/htdocs/smart_transit_system`

#### 3. Start XAMPP Services
- Open XAMPP Control Panel
- Start **Apache** module
- Start **MySQL** module

#### 4. Setup Database
1. Open `http://localhost/phpmyadmin/`
2. Create new database: `smart_transit`
3. Import database initialization:
   - Go to **Import** tab
   - The database schema and tables will be created automatically when you access the application for the first time

#### 5. Access Application
Open in your browser:
```
http://localhost/smart_transit_system/
```

---

## 📁 Project Structure

```
smart_transit_system/
├── admin/                       # Admin dashboard & management
│   ├── dashboard.php           # Admin overview & statistics
│   ├── users.php               # User management
│   ├── routes.php              # Route management
│   ├── buses.php               # Bus fleet management
│   └── emergency-reports.php   # Emergency incident tracking
│
├── driver/                      # Driver portal
│   ├── dashboard.php           # Driver home & active trips
│   ├── assignments.php         # Route assignments
│   ├── emergency-report.php    # Report emergency incidents
│   ├── vehicle-condition.php   # Pre-trip condition assessment
│   └── passengers.php          # Passenger management
│
├── passenger/                   # Passenger interface
│   ├── dashboard.php           # Passenger home
│   ├── browse-routes.php       # Route browsing & search
│   ├── tracking.php            # Live bus tracking
│   ├── bookings.php            # Booking management
│   └── profile.php             # User profile & preferences
│
├── api/                         # REST API endpoints (foundation)
│   ├── routes.php              # Route API
│   ├── buses.php               # Bus API
│   ├── schedules.php           # Schedule API
│   ├── trips.php               # Trip API
│   ├── locations.php           # Live location API
│   └── emergency.php           # Emergency API
│
├── assets/                      # Static files
│   ├── css/                    # Stylesheets
│   ├── js/                     # JavaScript files
│   └── images/                 # Images and icons
│
├── config/                      # Configuration files
│   ├── database.php            # Database connection & schema creation
│   ├── config.php              # Application configuration
│   └── constants.php           # App constants
│
├── database/                    # Database files (reference)
│   ├── schema.sql              # Database schema documentation
│   └── seed.sql                # Sample data
│
├── includes/                    # Shared PHP includes
│   ├── header.php              # HTML header with navigation
│   ├── footer.php              # HTML footer
│   ├── navbar.php              # Navigation bar component
│   ├── auth.php                # Authentication functions
│   ├── db.php                  # Database utility functions
│   └── functions.php           # General utility functions
│
├── index.php                    # Landing page
├── login.php                    # Login page
├── register.php                 # Registration page
├── logout.php                   # Logout handler
├── about.php                    # About page
├── .htaccess                    # Apache configuration
├── .env.example                 # Environment template
└── README.md                    # This file
```

---

## 🗄️ Database Schema

### Core Tables

#### `users`
- User accounts with roles (Admin, Driver, Passenger)
- Email, phone, encrypted passwords
- Status tracking (active/inactive)

#### `roles`
- Role definitions (Admin, Driver, Passenger)
- Permission management

#### `routes`
- Transit routes with start/end points
- Distance and duration information
- Route status

#### `buses`
- Bus fleet information
- Registration numbers, capacity
- Current status and condition

#### `schedules`
- Route schedules and timings
- Departure and arrival times
- Frequency information

#### `stops`
- Bus stops and stations
- GPS coordinates
- Stop sequences

#### `driver_assignments` ⭐ **NEW**
- Active driver-bus-route assignments
- Unique constraints for single active driver per bus
- Status tracking (active/inactive)

#### `trips` ⭐ **NEW**
- Complete trip lifecycle management
- Start/end times
- Status: scheduled, active, completed, cancelled
- Indexed for quick lookup

#### `live_locations` ⭐ **NEW**
- Real-time GPS coordinates
- Latitude, longitude, accuracy
- Bus status (on_route, stopped, offline, emergency)
- Automatic timestamp updates

#### `vehicle_conditions` ⭐ **NEW**
- Pre-trip and ongoing vehicle assessment
- Condition status: Good, Needs Attention, Maintenance Required
- Driver notes and observations
- Automatic reporting

#### `emergency_reports` ⭐ **NEW**
- Driver emergency incident reporting
- Severity levels: Low, Medium, High, Critical
- Status tracking: New, Investigating, Resolved
- Automatic resolution timestamp

#### `activity_logs` ⭐ **NEW**
- Comprehensive audit trail
- User actions and system events
- Entity tracking (what was changed)
- Automatic timestamps

#### `bus_occupancy` ⭐ **NEW**
- Passenger boarding/exiting records
- Current occupancy tracking
- Boarded and exited timestamps
- Query optimization for active passengers

#### Additional Tables
- `bookings` - Passenger bookings
- `fare_rates` - Pricing information
- `announcements` - System notifications
- `user_sessions` - Session management

---

## 🔐 Authentication

### How It Works
1. Users register with email and password
2. Passwords are hashed using PHP's `password_hash()` function
3. On login, credentials are verified against stored hash
4. Session is created with user details (ID, name, email, role)
5. CSRF tokens protect all form submissions
6. Session ID is regenerated on successful login

### Demo Accounts
⚠️ **Change these credentials before production use!**

ADMIN
admin@smarttransit.com
Admin@12345

DRIVER
driver@smarttransit.com
Driver@12345

PASSENGER
shojib@gmail.com
newnewnew

### Security Features
- Prepared statements (PDO) prevent SQL injection
- Password hashing prevents plain-text storage
- CSRF tokens on all forms
- Session regeneration after login
- Activity logging for audit trails
- Role-based access control on all pages

---

## 📡 API Endpoints

### Base URL
```
http://localhost/smart_transit_system/api/
```

### Available Endpoints (JSON Response)

#### Routes
```
GET    /routes.php              - Get all routes
GET    /routes.php?id=1         - Get specific route
POST   /routes.php              - Create route (Admin only)
```

#### Buses
```
GET    /buses.php               - Get all buses
GET    /buses.php?id=1          - Get specific bus info
POST   /buses.php               - Create bus entry (Admin only)
```

#### Trips
```
GET    /trips.php               - Get all trips
GET    /trips.php?status=active - Filter by status
POST   /trips.php               - Create trip
```

#### Live Locations
```
GET    /locations.php           - Get latest locations
GET    /locations.php?bus_id=1  - Get bus location
POST   /locations.php           - Update location (Driver only)
```

#### Emergency Reports
```
GET    /emergency.php           - Get reports
POST   /emergency.php           - Create report (Driver only)
```

### Response Format
```json
{
  "success": true,
  "data": [...],
  "message": "Operation successful"
}
```

---

## 🔄 Key Improvements (Latest Updates)

### Phase 2: Real-Time Tracking ✅
- ✅ Live GPS location tracking with accuracy metrics
- ✅ Real-time bus status indicators
- ✅ Trip management system
- ✅ Automatic location timestamp updates
- ✅ Bus occupancy tracking

### Phase 3: Emergency & Maintenance 🟢
- ✅ Emergency reporting system for drivers
- ✅ Severity-based incident categorization
- ✅ Vehicle condition pre-trip assessment
- ✅ Maintenance tracking
- ✅ Resolution timeline tracking

### Phase 4: Monitoring & Logging 🟢
- ✅ Comprehensive activity logs
- ✅ Admin audit trails
- ✅ Driver assignment tracking
- ✅ Passenger occupancy records
- ✅ Database-backed persistence

### Database Enhancements
- ✅ Optimized schema with proper indexes
- ✅ Foreign key constraints for data integrity
- ✅ ENUM types for status/state management
- ✅ Automatic timestamp management
- ✅ Unique constraints for business logic
- ✅ Cascade delete rules

---

## 🐛 Troubleshooting

### Common Issues

**Q: "Database connection failed" error**
- Verify MySQL is running in XAMPP
- Check `config/database.php` settings match your setup
- Ensure database `smart_transit` exists
- Verify database user/password

**Q: Blank page on first load**
- Check browser console for JavaScript errors
- Enable PHP error reporting in `config/database.php`
- Verify Apache is running
- Check file permissions

**Q: Login not working**
- Clear browser cookies/session
- Verify demo account credentials
- Check database connection
- Review `config/database.php` for correct host/password

**Q: Images/CSS not loading**
- Verify `assets/` folder structure
- Check .htaccess configuration
- Ensure XAMPP server is running
- Check browser console for 404 errors

**Q: Real-time tracking not updating**
- Verify `live_locations` table exists
- Check for JavaScript console errors
- Ensure API endpoints are accessible
- Verify database connection

### Debug Mode
Enable error reporting in `config/database.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Support Resources
- GitHub Issues: [SHOJIB-80/smart_transit_system/issues](https://github.com/SHOJIB-80/smart_transit_system/issues)
- Check code comments and documentation
- Review database schema in `database/` folder
- Test with demo accounts first

---

## 📊 Project Statistics

- **Language Composition**: PHP 84.3%, Hack 15.5%, JavaScript 0.2%
- **Database Tables**: 15+
- **Indexed Columns**: 20+
- **Demo Records**: 100+
- **API Endpoints**: 6+
- **Responsive Breakpoints**: Mobile, Tablet, Desktop
- **PHP Files**: 30+
- **Development Status**: 🟢 Active

---

## 🏆 Features Highlights

| Feature | Status | Details |
|---------|--------|---------|
| User Authentication | ✅ Complete | Secure with CSRF protection |
| Role-Based Access | ✅ Complete | Admin, Driver, Passenger roles |
| Real-Time Tracking | ✅ Complete | GPS with accuracy metrics |
| Emergency Reporting | ✅ Complete | Multi-level severity tracking |
| Trip Management | ✅ Complete | Full lifecycle from schedule to completion |
| Vehicle Conditions | ✅ Complete | Pre-trip and ongoing assessment |
| Activity Logging | ✅ Complete | Comprehensive audit trails |
| Occupancy Tracking | ✅ Complete | Passenger boarding/exit records |
| Responsive UI | ✅ Complete | Mobile, tablet, desktop |
| Admin Dashboard | ✅ Complete | System overview and management |
| Driver Portal | ✅ Complete | Assignments and reporting |
| Passenger Dashboard | ✅ Complete | Bookings and tracking |

---

## 📄 License

This project is licensed under the **MIT License** - educational use permitted.

### MIT License Summary
✅ Use for educational purposes  
✅ Modify and improve the code  
✅ Distribute copies  
✅ Include in personal/commercial projects  
⚠️ No warranty provided

---

## 📞 Support & Contact

### Troubleshooting Steps
1. Verify XAMPP services are running (Apache + MySQL)
2. Check database connection in `config/database.php`
3. Clear browser cache and cookies
4. Check browser console for errors
5. Review PHP error logs

### Reporting Issues
When reporting issues, please include:
- Error message or screenshot
- Steps to reproduce
- Browser and PHP version
- Database state if applicable

### Contributing
We welcome contributions! Please:
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

---

**Developed by**: SHOJIB-80  
**Repository**: [GitHub](https://github.com/SHOJIB-80/smart_transit_system)  
**Status**: 🟢 Active Development  
**Last Updated**: August 2026

---

## 🎯 Upcoming Roadmap

- 🔄 **Phase 5**: Map Integration (Leaflet/OpenStreetMap)
- 🔄 **Phase 6**: Push Notifications
- 🔄 **Phase 7**: Advanced Analytics
- 🔄 **Phase 8**: Mobile App
- 🔄 **Phase 9**: AI-based Route Optimization
- 🔄 **Phase 10**: Production Hardening & Deployment
