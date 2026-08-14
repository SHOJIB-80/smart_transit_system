# 🚌 Smart Transit Navigation System

A comprehensive university CSE project for a public transportation management and navigation system. Built with modern web technologies, this system provides real-time route tracking, passenger booking, and driver management capabilities.

## 📋 Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Demo Accounts](#demo-accounts)
- [Project Roadmap](#project-roadmap)
- [Important Notes](#important-notes)
- [License](#license)
- [Contributing](#contributing)
- [Support](#support)

## 🎯 Overview

Smart Transit Navigation System is a multi-phase educational project designed to demonstrate full-stack web development concepts. Part 1 establishes the foundation with user authentication, database management, and a responsive user interface for passengers, drivers, and administrators.

## ✨ Features

### Part 1 - Foundation (Current)
- 🎨 Responsive landing page with modern design
- 👤 User authentication system (registration, login, logout)
- 🔐 PHP session management with role-based authorization
- 📊 MySQL database with prepared statements
- 🛡️ Security features (CSRF tokens, output escaping, prepared statements)
- 👨‍💼 Passenger dashboard with personalized experience
- 🛣️ Route browsing and detailed route information
- 🚌 Bus listings and specifications
- ⏰ Schedule filtering and availability checking
- 📢 System notices and announcements
- 🔧 Driver/admin authentication foundations
- 📡 JSON API foundation for future enhancements
- 📦 Comprehensive demo data for testing

### Upcoming Features
- **Part 2**: Live tracking with Leaflet/OpenStreetMap, GPS integration, real-time ETA, and full driver workflow
- **Part 3**: Complete admin dashboard with comprehensive management tools
- **Part 4**: Integration, push notifications, security hardening, automated testing, and production polish

## 🛠️ Tech Stack

| Category | Technology |
|----------|-----------|
| **Frontend** | HTML5, CSS3, Vanilla JavaScript |
| **Backend** | PHP 7+ |
| **Database** | MySQL |
| **Server** | Apache (XAMPP) |
| **Maps (Future)** | Leaflet, OpenStreetMap |

## 📦 Requirements

- **XAMPP** (includes Apache, MySQL, PHP)
- **Modern Web Browser** (Chrome, Firefox, Safari, Edge)
- **Disk Space**: ~100MB
- **RAM**: 2GB minimum

## 🚀 Installation

### Step-by-Step Setup

1. **Download & Setup XAMPP**
   - Download XAMPP from https://www.apachefriends.org/
   - Install with Apache and MySQL components

2. **Clone/Download Project**
   ```bash
   git clone https://github.com/SHOJIB-80/smart_transit_system.git
   # or download as ZIP and extract
   ```

3. **Copy to XAMPP**
   - Copy the `smart-transit` folder to `C:\xampp\htdocs\` (Windows)
   - Or `/opt/lampp/htdocs/` (Linux)
   - Or `/Applications/XAMPP/htdocs/` (macOS)

4. **Start Services**
   - Open XAMPP Control Panel
   - Start **Apache** and **MySQL** modules

5. **Setup Database**
   - Open http://localhost/phpmyadmin/
   - Create a new database named `smart_transit`
   - Import database files in order:
     ```
     1. database/schema.sql (creates tables)
     2. database/seed.sql (populates demo data)
     ```

6. **Configure Database Connection**
   - Edit `config/database.php`
   - Update credentials if your MySQL setup differs:
     ```php
     $host = 'localhost';
     $user = 'root';
     $password = '';  // Default XAMPP password is empty
     $database = 'smart_transit';
     ```

7. **Access Application**
   - Open http://localhost/smart-transit/ in your browser
   - System should load with demo data ready

## 👤 Demo Accounts

### Default Credentials
Password for all demo accounts: `password`

| Email | Role | Purpose |
|-------|------|---------|
| `admin@smarttransit.com` | Administrator | Full system access, management tools |
| `driver1@smarttransit.com` | Driver | Route assignment, passenger management |
| `passenger@smarttransit.com` | Passenger | Booking, schedule checking, support |

⚠️ **Security Notice**: Change all credentials immediately before any production deployment.

## 🗺️ Project Roadmap

### Phase 1: Foundation ✅
- User authentication and authorization
- Basic dashboard interfaces
- Route and schedule management
- Database architecture

### Phase 2: Real-Time Tracking (Upcoming)
- Leaflet map integration
- OpenStreetMap integration
- GPS tracking capabilities
- Real-time ETA calculations
- Complete driver workflow
- Live bus location updates

### Phase 3: Admin Management (Upcoming)
- Comprehensive admin dashboard
- User management tools
- Route management interface
- Bus fleet management
- System analytics and reporting

### Phase 4: Polish & Production (Upcoming)
- Integrated notification system
- Enhanced security measures
- Automated testing suite
- Performance optimization
- API documentation
- Deployment preparation

## ⚠️ Important Notes

### Demo Data
- All route, bus, and stop data are **demonstration/sample data only**
- This data is **NOT** official transportation authority data
- Not suitable for real-world transportation services without proper licensing
- For production use, integrate with actual transit authority data sources

### Browser Compatibility
- Modern browsers (Chrome 90+, Firefox 88+, Safari 14+, Edge 90+)
- Requires JavaScript enabled
- Mobile-responsive design included

### Database Backup
- Regular backups recommended for development
- Export database via phpMyAdmin for version control

## 📄 License

This project is licensed under the **MIT License**.

### MIT License Summary
You are free to:
- ✅ Use this project for educational purposes
- ✅ Modify and improve the code
- ✅ Distribute copies of the project
- ✅ Include in personal or commercial projects

### Full License Terms
```
MIT License

Copyright (c) 2025 SHOJIB-80

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

For the full license text, see [LICENSE](./LICENSE) file.

## 🤝 Contributing

Contributions are welcome! Here's how you can help:

1. **Fork** the repository
2. **Create** a feature branch (`git checkout -b feature/AmazingFeature`)
3. **Commit** your changes (`git commit -m 'Add AmazingFeature'`)
4. **Push** to the branch (`git push origin feature/AmazingFeature`)
5. **Open** a Pull Request with detailed description

### Development Guidelines
- Follow PSR-12 PHP coding standards
- Add comments for complex logic
- Test changes thoroughly before submitting
- Update documentation for new features

## 📞 Support

### Troubleshooting

**Apache/MySQL not starting?**
- Check if ports 80 and 3306 are available
- Try running XAMPP as Administrator
- Check XAMPP error logs

**Database import fails?**
- Ensure database is created first
- Check MySQL version compatibility
- Verify SQL file syntax

**Application shows blank page?**
- Enable error reporting in `config/database.php`
- Check browser console for JavaScript errors
- Verify PHP version (7.0+ required)

### Getting Help
- Check existing issues and discussions
- Review documentation and comments in code
- Test with demo accounts first

## 📚 Project Structure

```
smart-transit/
├── config/              # Configuration files
├── database/            # SQL schema and seed files
├── public/              # Static files (CSS, JS, images)
├── views/               # HTML templates
├── src/                 # PHP application logic
├── README.md            # This file
└── LICENSE              # MIT License
```

## 📈 Statistics

- **Lines of Code**: 5000+
- **Database Tables**: 10+
- **Demo Records**: 100+
- **Total Development Time**: Ongoing educational project

---

**Developed by**: SHOJIB-80  
**Last Updated**: 2025  
**Status**: 🟢 Active Development

Made with ❤️ for educational purposes
