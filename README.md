# 🚌 Smart Transit Navigation System

A comprehensive full-stack web application for public transportation management and navigation. Built with modern web technologies, this educational project demonstrates professional development practices including responsive design, secure authentication, database management, and API development.

## 📋 Table of Contents
- [Overview](#overview)
- [Features](#features)
- [What's New](#whats-new)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Requirements](#requirements)
- [Installation](#installation)
- [Demo Accounts](#demo-accounts)
- [API Documentation](#api-documentation)
- [Database Schema](#database-schema)
- [Project Roadmap](#project-roadmap)
- [Important Notes](#important-notes)
- [Contributing](#contributing)
- [License](#license)
- [Support](#support)

## 🎯 Overview

Smart Transit Navigation System is a multi-phase educational project designed to demonstrate full-stack web development. With a focus on user experience and security, it provides a complete ecosystem for passengers, drivers, and administrators to manage public transportation efficiently.

The system features a modern, responsive UI with a professional dashboard system, role-based access control, and comprehensive route management capabilities.

## ✨ Features

### ✅ Implemented Features

#### User Management & Authentication
- 🔐 Secure user registration and login system
- 🎯 Role-based authorization (Admin, Driver, Passenger)
- 👤 User profile management
- 🔑 Session management with security considerations
- 🛡️ CSRF token protection
- 📝 Password security best practices

#### Frontend Experience
- 🎨 Modern, responsive landing page with smooth animations
- 📱 Mobile-optimized design
- 🎭 Professional visual hierarchy and color scheme
- ⚡ Smooth scrolling and interactive elements
- 🌓 Accessibility-focused design
- 💫 Floating card animations and visual effects

#### Passenger Features
- 🛣️ Browse available routes and schedules
- 🚌 View detailed bus information and specifications
- ⏰ Real-time schedule filtering and availability checking
- 🎟️ Booking interface (foundation ready)
- 📢 System announcements and notices
- 🔍 Advanced search capabilities
- ❤️ Favorite routes management (foundation)

#### Admin Dashboard
- 📊 Administrative control panel
- 🚌 Bus fleet management
- 🛣️ Route management and creation
- 👥 User management tools
- 📈 System monitoring capabilities
- 🔧 Configuration management

#### Driver Portal
- 📍 Driver authentication and profile
- 🗺️ Route assignment interface
- 👥 Passenger management
- 📊 Schedule tracking
- 💼 Professional driver dashboard

#### Backend Infrastructure
- 🗄️ MySQL database with normalized schema
- 📋 10+ database tables with relationships
- 🔒 Prepared statements for SQL injection prevention
- 📦 RESTful API foundation
- 🛡️ Security best practices implementation
- 💾 Efficient data management

#### Data Management
- 📦 Comprehensive demo data (100+ records)
- 🔄 Database seeding system
- 📊 Sample routes, buses, and schedules
- 👤 Pre-configured test accounts
- 📝 Easy database initialization

### 🚀 Upcoming Features

#### Phase 2: Real-Time Tracking
- 🗺️ Leaflet map integration
- 🌍 OpenStreetMap API integration
- 📍 GPS tracking capabilities
- ⏱️ Real-time ETA calculations
- 📡 Live bus location updates
- 🔴 Live tracking status indicator
- 📱 Mobile tracking app

#### Phase 3: Enhanced Admin Dashboard
- 📊 Advanced analytics and reporting
- 📈 System statistics and KPIs
- 👥 User activity monitoring
- 💰 Financial reporting (future)
- 📋 Route efficiency analysis
- 🎯 Performance metrics

#### Phase 4: Production Polish
- 🔔 Push notification system
- 🔐 Enhanced security measures
- ✅ Automated testing suite
- ⚡ Performance optimization
- 📖 API documentation
- 🚀 Deployment automation
- 🔄 CI/CD pipeline

## 🆕 What's New

Recent updates include:
- ✨ Enhanced frontend UI with modern design patterns
- 📁 Expanded directory structure (admin, driver, passenger, api, assets)
- 🎨 Improved styling and visual components
- 🔧 New PHP configuration files
- 📚 Additional database capabilities
- 🚀 API endpoint foundation
- 💡 Enhanced functionality for all user roles

## 🛠️ Tech Stack

| Category | Technology | Version |
|----------|-----------|---------|
| **Frontend** | HTML5, CSS3, Vanilla JavaScript | Latest |
| **Backend** | PHP | 7.0+ |
| **Database** | MySQL | 5.7+ |
| **Server** | Apache (XAMPP) | Latest |
| **Maps (Future)** | Leaflet, OpenStreetMap | TBD |
| **API** | RESTful JSON | - |

## 📁 Project Structure

```
smart-transit-system/
├── admin/                    # Admin panel and management tools
│   ├── dashboard.php        # Admin dashboard
│   ├── users.php           # User management
│   ├── routes.php          # Route management
│   └── ...
├── driver/                   # Driver portal
│   ├── dashboard.php        # Driver dashboard
│   ├── assignments.php      # Route assignments
│   └── passengers.php       # Passenger management
├── passenger/               # Passenger dashboard
│   ├── dashboard.php        # Passenger home
│   ├── browse-routes.php    # Route browsing
│   ├── bookings.php         # Booking management
│   └── profile.php          # User profile
├── api/                      # REST API endpoints
│   ├── routes.php           # Route API
│   ├── buses.php            # Bus API
│   ├── schedules.php        # Schedule API
│   └── bookings.php         # Booking API
├── assets/                   # Static files
│   ├── css/                 # Stylesheets
│   ├── js/                  # JavaScript files
│   └── images/              # Images and icons
├── config/                   # Configuration files
│   ├── database.php         # Database configuration
│   ├── constants.php        # Application constants
│   └── settings.php         # Settings
├── database/                 # Database files
│   ├── schema.sql           # Database schema
│   ├── seed.sql             # Sample data
│   └── migrations/          # Database migrations
├── includes/                 # Shared PHP includes
│   ├── header.php           # Header component
│   ├── footer.php           # Footer component
│   ├── navbar.php           # Navigation bar
│   ├── auth.php             # Authentication functions
│   ├── db.php               # Database functions
│   └── functions.php        # Utility functions
├── index.php                 # Landing page
├── login.php                 # Login page
├── register.php              # Registration page
├── logout.php                # Logout handler
├── about.php                 # About page
├── .htaccess                 # Apache configuration
├── .env.example              # Environment variables template
└── README.md                 # This file
```

## 📦 Requirements

- **XAMPP** (Apache, MySQL, PHP 7.0+)
- **Modern Web Browser** (Chrome 90+, Firefox 88+, Safari 14+, Edge 90+)
- **Disk Space**: ~150MB
- **RAM**: 2GB minimum
- **JavaScript**: Enabled in browser

## 🚀 Installation

### Step 1: Download & Setup XAMPP
```bash
# Download from https://www.apachefriends.org/
# Install with Apache and MySQL components
```

### Step 2: Clone Repository
```bash
git clone https://github.com/SHOJIB-80/smart_transit_system.git
# Or download as ZIP and extract
```

### Step 3: Move to XAMPP
- **Windows**: Copy folder to `C:\xampp\htdocs\`
- **Linux**: Copy folder to `/opt/lampp/htdocs/`
- **macOS**: Copy folder to `/Applications/XAMPP/htdocs/`

### Step 4: Start Services
- Open XAMPP Control Panel
- Start **Apache** module
- Start **MySQL** module

### Step 5: Setup Database
1. Open `http://localhost/phpmyadmin/`
2. Create new database: `smart_transit`
3. Import database files in order:
   ```
   1. database/schema.sql    (Create tables)
   2. database/seed.sql      (Add demo data)
   ```

### Step 6: Configure Database Connection
Edit `config/database.php`:
```php
$host = 'localhost';
$user = 'root';
$password = '';           // Default XAMPP password
$database = 'smart_transit';
```

### Step 7: Access Application
Open in browser: `http://localhost/smart_transit_system/`

## 👤 Demo Accounts

╔══════════════════════════════════════════╗
║        SMART TRANSIT TEST ACCOUNTS       ║
╠══════════════════════════════════════════╣
║ ADMIN                                    ║
║ Email:    admin@smarttransit.com         ║
║ Password: Admin@12345                    ║
║ Redirect: admin/dashboard.php             ║
╠══════════════════════════════════════════╣
║ DRIVER                                   ║
║ Email:    driver@smarttransit.com        ║
║ Password: Driver@12345                   ║
║ Redirect: driver/dashboard.php            ║
╠══════════════════════════════════════════╣
║ PASSENGER                                ║
║ Email:    shojib@gmail.com     ║
║ Password: Passenger@12345                ║
║ Redirect: passenger/dashboard.php         ║
╚══════════════════════════════════════════╝

⚠️ **Security**: Change all credentials before any production use.

## 📡 API Documentation

### Base URL
```
http://localhost/smart_transit_system/api/
```

### Endpoints (Foundation Ready)

#### Routes API
```
GET    /api/routes.php           - Get all routes
GET    /api/routes.php?id=1      - Get specific route
POST   /api/routes.php           - Create route (Admin)
PUT    /api/routes.php?id=1      - Update route (Admin)
DELETE /api/routes.php?id=1      - Delete route (Admin)
```

#### Buses API
```
GET    /api/buses.php            - Get all buses
GET    /api/buses.php?id=1       - Get specific bus
POST   /api/buses.php            - Create bus (Admin)
```

#### Schedules API
```
GET    /api/schedules.php        - Get all schedules
GET    /api/schedules.php?route_id=1  - Get route schedules
```

#### Bookings API
```
GET    /api/bookings.php         - Get user bookings
POST   /api/bookings.php         - Create booking (Passenger)
```

**Response Format**: JSON
```json
{
  "success": true,
  "data": [...],
  "message": "Operation successful"
}
```

## 🗄️ Database Schema

### Core Tables
- **users** - User accounts and credentials
- **roles** - User roles (Admin, Driver, Passenger)
- **routes** - Transit routes and paths
- **buses** - Bus fleet information
- **schedules** - Route schedules and timings
- **stops** - Bus stops and locations
- **bookings** - Passenger bookings
- **fare_rates** - Pricing information
- **announcements** - System notifications
- **user_sessions** - Session management

## 🗺️ Project Roadmap

### Phase 1: Foundation ✅
- [x] User authentication system
- [x] Role-based access control
- [x] Landing page and UI
- [x] Passenger dashboard
- [x] Admin dashboard
- [x] Driver portal
- [x] Database design
- [x] API foundation

### Phase 2: Real-Time Tracking 🔄
- [ ] Leaflet map integration
- [ ] OpenStreetMap API
- [ ] GPS tracking
- [ ] Real-time ETA
- [ ] Live updates
- [ ] Mobile optimization

### Phase 3: Admin Management 🚀
- [ ] Advanced analytics
- [ ] Report generation
- [ ] Performance monitoring
- [ ] Financial management
- [ ] User activity logs

### Phase 4: Production Ready ⭐
- [ ] Comprehensive testing
- [ ] Security hardening
- [ ] Performance tuning
- [ ] Documentation
- [ ] Deployment guides
- [ ] CI/CD pipeline

## ⚠️ Important Notes

### Demo Data
- All routes, buses, and stop data are **sample/demonstration only**
- NOT official transportation authority data
- Not suitable for production without proper licensing
- Integrate with real transit authority APIs for production

### Browser Support
- Modern browsers only (Chrome 90+, Firefox 88+, Safari 14+, Edge 90+)
- Requires JavaScript enabled
- Responsive design for all screen sizes
- Mobile-friendly interface

### Security Considerations
- All passwords should be changed after deployment
- Enable HTTPS in production
- Update all dependencies regularly
- Regular security audits recommended
- Database backups essential for production

### Database Management
- Regular backups recommended
- Export via phpMyAdmin for version control
- Monitor database growth
- Optimize queries for performance

## 🤝 Contributing

We welcome contributions! Follow these steps:

1. **Fork** the repository
2. **Create** feature branch: `git checkout -b feature/YourFeature`
3. **Commit** changes: `git commit -m 'Add YourFeature'`
4. **Push** to branch: `git push origin feature/YourFeature`
5. **Open** Pull Request with detailed description

### Code Standards
- Follow PSR-12 PHP coding standards
- Comment complex logic
- Test all changes thoroughly
- Update documentation
- Ensure responsive design

### Commit Message Format
```
feat: Add new feature description
fix: Fix bug description
docs: Update documentation
style: Code style changes
refactor: Code refactoring
```

## 📄 License

This project is licensed under the **MIT License** - see [LICENSE](./LICENSE) for details.

### MIT License Summary
✅ Use for educational purposes  
✅ Modify and improve the code  
✅ Distribute copies  
✅ Include in personal/commercial projects  

⚠️ No warranty provided

## 📞 Support

### Troubleshooting

**Q: Apache/MySQL won't start?**
- Verify ports 80 and 3306 are available
- Run XAMPP as Administrator
- Check XAMPP error logs

**Q: Database import fails?**
- Ensure database exists first
- Check MySQL version compatibility
- Verify file permissions

**Q: Blank page displayed?**
- Check browser console for errors
- Verify PHP version (7.0+ required)
- Enable error reporting in `config/database.php`

**Q: Login not working?**
- Verify demo account credentials
- Clear browser cookies
- Check database connection
- Review session settings

### Resources
- Check [GitHub Issues](https://github.com/SHOJIB-80/smart_transit_system/issues)
- Review code comments and documentation
- Test with demo accounts first
- Enable debug mode for troubleshooting

### Reporting Issues
- Provide detailed error messages
- Include browser console output
- Specify steps to reproduce
- Attach relevant screenshots

## 📊 Project Statistics

- **Language**: PHP, HTML5, CSS3, JavaScript
- **Database Tables**: 10+
- **Demo Records**: 100+
- **Lines of Code**: 5000+
- **API Endpoints**: 15+
- **Responsive Breakpoints**: Mobile, Tablet, Desktop
- **Development Status**: Active

## 🏆 Key Highlights

✨ **Professional Design** - Modern, clean UI  
🔐 **Secure** - Industry security practices  
📱 **Responsive** - Works on all devices  
⚡ **Performant** - Optimized for speed  
📚 **Well-Documented** - Clear code comments  
🧪 **Testable** - Demo data ready  
🚀 **Scalable** - Foundation for growth  

---

**Developed by**: SHOJIB-80  
**Last Updated**: 2025  
**Status**: 🟢 Active Development  
**Repository**: [GitHub](https://github.com/SHOJIB-80/smart_transit_system)
