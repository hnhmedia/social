# VPS Deployment Guide - GenuinSocial

This guide will help you deploy the GenuinSocial application on a VPS server.

## Prerequisites

- VPS server with at least 2GB RAM
- Ubuntu 20.04/22.04 or similar Linux distribution
- Root or sudo access
- Domain name pointed to your VPS IP (optional but recommended)

## Option 1: Quick Deployment with Docker (Recommended)

### Step 1: Connect to Your VPS

```bash
ssh root@your-vps-ip
# or
ssh username@your-vps-ip
```

### Step 2: Install Docker and Docker Compose

```bash
# Update system packages
sudo apt update && sudo apt upgrade -y

# Install Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Install Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

# Verify installation
docker --version
docker-compose --version
```

### Step 3: Upload Project Files

**Method A: Using Git (Recommended)**
```bash
cd /var/www
sudo git clone https://github.com/hnhmedia/social.git genuinsocial
cd genuinsocial
```

**Method B: Using SCP from your local machine**
```bash
# Run this on your local machine
scp -r d:\genuinsocial username@your-vps-ip:/var/www/
```

**Method C: Using SFTP Client**
- Use FileZilla, WinSCP, or similar
- Connect to your VPS
- Upload the entire project folder to `/var/www/genuinsocial`

### Step 4: Configure Environment

```bash
cd /var/www/genuinsocial

# Copy environment file
cp .env.example .env

# Edit the .env file with your actual values
sudo nano .env
```

Update these values in `.env`:
```env
DB_HOST=db
DB_NAME=si_socialmedia
DB_USER=si_user
DB_PASS=your_secure_password_here
DB_PREFIX=si_

SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USERNAME=your-email@gmail.com
SMTP_PASSWORD=your-app-password
SMTP_FROM=your-email@gmail.com
SMTP_FROM_NAME=GenuinSocial

PAYPAL_MODE=live
PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_CLIENT_SECRET=your_paypal_client_secret

APP_URL=https://yourdomain.com
```

### Step 5: Update Docker Compose (if needed)

```bash
# Edit docker-compose.yml if you need to change ports or settings
sudo nano docker-compose.yml
```

### Step 6: Import Database Schema

```bash
# Start only the database container first
docker-compose up -d db

# Wait for database to be ready (about 30 seconds)
sleep 30

# Import the database schema
docker-compose exec db mysql -u si_user -p si_socialmedia < admin_sgmlocal.sql

# Import additional backend schemas
docker-compose exec db mysql -u si_user -p si_socialmedia < backend/si_admin_users.sql
```

### Step 7: Start All Services

```bash
# Start all containers
docker-compose up -d

# Check if containers are running
docker-compose ps

# View logs
docker-compose logs -f
```

### Step 8: Set Permissions

```bash
sudo chown -R www-data:www-data /var/www/genuinsocial
sudo chmod -R 755 /var/www/genuinsocial
```

### Step 9: Access Your Application

- Frontend: `http://your-vps-ip` or `http://yourdomain.com`
- Admin Panel: `http://your-vps-ip/backend` or `http://yourdomain.com/backend`

Default admin credentials (change after first login):
- Username: admin
- Password: Check your database or setup.php

---

## Option 2: Manual Deployment (Without Docker)

### Step 1: Connect to VPS and Update System

```bash
ssh root@your-vps-ip
sudo apt update && sudo apt upgrade -y
```

### Step 2: Install LAMP Stack

```bash
# Install Apache
sudo apt install apache2 -y

# Install MySQL
sudo apt install mysql-server -y

# Install PHP 8.1 and required extensions
sudo apt install php8.1 php8.1-cli php8.1-common php8.1-mysql php8.1-zip php8.1-gd php8.1-mbstring php8.1-curl php8.1-xml php8.1-bcmath -y

# Enable Apache modules
sudo a2enmod rewrite
sudo a2enmod headers
sudo systemctl restart apache2
```

### Step 3: Secure MySQL

```bash
sudo mysql_secure_installation
```

### Step 4: Create Database and User

```bash
sudo mysql -u root -p
```

In MySQL prompt:
```sql
CREATE DATABASE si_socialmedia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'si_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON si_socialmedia.* TO 'si_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Step 5: Upload Project Files

```bash
cd /var/www/html
sudo rm -rf *  # Remove default Apache files

# Using Git
sudo git clone https://github.com/hnhmedia/social.git .

# Or upload via SCP/SFTP to /var/www/html/
```

### Step 6: Configure Environment

```bash
cd /var/www/html
sudo cp .env.example .env
sudo nano .env
```

Update the `.env` file with your database credentials and other settings.

### Step 7: Import Database

```bash
mysql -u si_user -p si_socialmedia < admin_sgmlocal.sql
mysql -u si_user -p si_socialmedia < backend/si_admin_users.sql
```

### Step 8: Configure Apache

```bash
sudo nano /etc/apache2/sites-available/000-default.conf
```

Update the configuration:
```apache
<VirtualHost *:80>
    ServerAdmin admin@yourdomain.com
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
    DocumentRoot /var/www/html

    <Directory /var/www/html>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

Restart Apache:
```bash
sudo systemctl restart apache2
```

### Step 9: Set Permissions

```bash
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html
sudo chmod -R 775 /var/www/html/uploads  # If you have an uploads directory
```

### Step 10: Setup SSL with Let's Encrypt (Recommended)

```bash
sudo apt install certbot python3-certbot-apache -y
sudo certbot --apache -d yourdomain.com -d www.yourdomain.com
```

---

## Post-Deployment Configuration

### 1. Access Admin Panel Setup

Visit: `http://yourdomain.com/backend/setup.php`

This will guide you through:
- Creating the first admin user
- Configuring database tables
- Setting up initial settings

### 2. Secure the Backend

After setup is complete:
```bash
# Remove or restrict access to setup.php
sudo rm /var/www/html/backend/setup.php
# or
sudo chmod 000 /var/www/html/backend/setup.php
```

### 3. Configure Cron Jobs (Optional)

For automated tasks, add cron jobs:
```bash
sudo crontab -e
```

Add these lines:
```cron
# Clean old sessions daily at 2 AM
0 2 * * * php /var/www/html/cron/cleanup.php

# Process pending orders every 5 minutes
*/5 * * * * php /var/www/html/cron/process_orders.php
```

### 4. Setup Firewall

```bash
# Allow HTTP and HTTPS
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw allow 22/tcp  # SSH
sudo ufw enable
sudo ufw status
```

### 5. Configure PayPal

1. Log in to admin panel
2. Go to Settings
3. Enter your PayPal credentials:
   - Client ID
   - Client Secret
   - Set mode to 'live' or 'sandbox'

---

## Monitoring and Maintenance

### Check Application Logs

**With Docker:**
```bash
docker-compose logs -f app
docker-compose logs -f db
```

**Without Docker:**
```bash
# Apache logs
sudo tail -f /var/log/apache2/error.log
sudo tail -f /var/log/apache2/access.log

# PHP logs
sudo tail -f /var/log/php8.1-fpm.log
```

### Backup Database

**With Docker:**
```bash
docker-compose exec db mysqldump -u si_user -p si_socialmedia > backup_$(date +%Y%m%d).sql
```

**Without Docker:**
```bash
mysqldump -u si_user -p si_socialmedia > backup_$(date +%Y%m%d).sql
```

### Update Application

```bash
cd /var/www/html  # or /var/www/genuinsocial for Docker
git pull origin main

# If using Docker
docker-compose down
docker-compose up -d --build

# If not using Docker
sudo systemctl restart apache2
```

---

## Troubleshooting

### Database Connection Issues

1. Check `.env` file has correct credentials
2. Verify database exists and user has permissions
3. Check if MySQL is running:
   ```bash
   sudo systemctl status mysql
   # or for Docker
   docker-compose ps
   ```

### Permission Errors

```bash
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html
```

### Apache Not Starting

```bash
# Check configuration syntax
sudo apache2ctl configtest

# Check what's using port 80
sudo netstat -tulpn | grep :80

# View Apache errors
sudo journalctl -u apache2 -n 50
```

### Docker Container Issues

```bash
# Restart containers
docker-compose restart

# Rebuild containers
docker-compose down
docker-compose up -d --build

# Check container logs
docker-compose logs app
docker-compose logs db
```

### 404 Errors / Routing Issues

1. Ensure `.htaccess` file exists in root directory
2. Verify Apache mod_rewrite is enabled:
   ```bash
   sudo a2enmod rewrite
   sudo systemctl restart apache2
   ```

### Email Not Sending

1. Check SMTP settings in `.env`
2. For Gmail, use App Password (not regular password)
3. Verify port 587 is not blocked by firewall

---

## Security Checklist

- [ ] Change default admin password
- [ ] Remove or restrict `setup.php` access
- [ ] Setup SSL certificate (HTTPS)
- [ ] Configure firewall rules
- [ ] Keep system and packages updated
- [ ] Use strong database passwords
- [ ] Setup regular backups
- [ ] Monitor error logs
- [ ] Disable directory listing
- [ ] Set proper file permissions

---

## Support

For issues or questions:
- Check error logs first
- Review this documentation
- Contact: smmexpert52@gmail.com
- GitHub: https://github.com/hnhmedia/social

---

## Quick Command Reference

```bash
# Docker Commands
docker-compose up -d          # Start services
docker-compose down           # Stop services
docker-compose restart        # Restart services
docker-compose logs -f        # View logs
docker-compose ps             # List containers

# System Commands
sudo systemctl start apache2   # Start Apache
sudo systemctl stop apache2    # Stop Apache
sudo systemctl restart apache2 # Restart Apache
sudo systemctl status mysql    # Check MySQL status

# File Permissions
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html

# Database Backup
mysqldump -u si_user -p si_socialmedia > backup.sql

# Update from Git
git pull origin main
```
