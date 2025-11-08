# Dalsoop.com - WordPress with Docker Compose on Coolify

## Project Overview

WordPress website deployed on Coolify using Docker Compose with MySQL database.

- **Repository**: https://github.com/jeonghanyun/dalsoop.com
- **Domain**: https://www.dalsoop.com
- **Deployment Platform**: Coolify (https://coolify.dalsoop.com)

## Architecture

### Technology Stack
- **WordPress**: 6.4 with PHP 8.2 and Apache
- **Database**: MySQL 8.0
- **Deployment**: Docker Compose on Coolify
- **Web Server**: Apache (built into WordPress image)

### Services
1. **wordpress** - WordPress application container
   - Image: `wordpress:6.4-php8.2-apache`
   - Port: 80
   - Depends on: MySQL database with health check

2. **db** - MySQL database container
   - Image: `mysql:8.0`
   - Port: 3306 (internal only)
   - Health check: `mysqladmin ping`

## Deployment Configuration

### Coolify Settings
- **Build Pack**: Docker Compose
- **Docker Compose Location**: `/docker-compose.yml`
- **Base Directory**: `/`

### Environment Variables
Configured in Coolify (not in repository):
- `DB_PASSWORD` - WordPress database password
- `DB_ROOT_PASSWORD` - MySQL root password

### Volumes
- `wordpress_data` - WordPress core files and uploads
- `db_data` - MySQL database files
- `./wp-content` - WordPress themes, plugins, uploads (git tracked)

## Repository Structure

```
dalsoop.com/
├── docker-compose.yml          # Docker Compose configuration
├── .env.example               # Environment variable template
├── .gitignore                 # Git ignore rules
├── README.md                  # Deployment documentation
├── CLAUDE.md                  # This file - Claude Code context
├── index.php                  # WordPress entry point
└── wp-content/                # WordPress customizations
    ├── themes/                # Custom themes
    ├── plugins/               # Custom plugins
    └── uploads/               # Media uploads
```

## Deployment Process

### Initial Setup
1. Repository linked to Coolify via GitHub Deploy Key
2. Docker Compose build pack selected
3. Environment variables configured in Coolify
4. Domain `www.dalsoop.com` mapped to application

### Deployment Steps
1. Push changes to GitHub `main` branch
2. Coolify automatically detects changes
3. Pulls latest code from repository
4. Builds and starts Docker Compose services
5. Health checks ensure database is ready before WordPress starts
6. Application becomes available at https://www.dalsoop.com

### Manual Deployment
Use Coolify UI:
1. Navigate to application configuration
2. Click "Redeploy" button
3. Monitor deployment logs

## Development Workflow

### Local Development
```bash
# Clone repository
git clone https://github.com/jeonghanyun/dalsoop.com.git
cd dalsoop.com

# Copy environment template
cp .env.example .env

# Edit .env with your database passwords
# DB_PASSWORD=your_secure_password
# DB_ROOT_PASSWORD=your_root_password

# Start services
docker-compose up -d

# Access WordPress at http://localhost
# Complete WordPress installation wizard
```

### Making Changes
1. Edit theme files in `wp-content/themes/`
2. Add/modify plugins in `wp-content/plugins/`
3. Test changes locally with `docker-compose up -d`
4. Commit and push to GitHub
5. Coolify automatically deploys changes

### Database Management
```bash
# Access MySQL container
docker-compose exec db mysql -u wordpress -p

# Backup database
docker-compose exec db mysqldump -u wordpress -p wordpress > backup.sql

# Restore database
docker-compose exec -T db mysql -u wordpress -p wordpress < backup.sql
```

## Troubleshooting

### Common Issues

**503 Error - No Available Server**
- Check if containers are running: Coolify Logs page
- Verify environment variables are set correctly
- Check Docker Compose logs for startup errors
- Ensure MySQL healthcheck is passing before WordPress starts

**Database Connection Errors**
- Verify `DB_PASSWORD` matches in Coolify environment variables
- Check MySQL container logs for initialization errors
- Ensure database service is healthy before WordPress starts

**WordPress Installation Loop**
- Clear browser cache and cookies
- Check if `wp-config.php` exists in wordpress_data volume
- Verify database credentials in Coolify environment variables

### Log Access
- **Coolify Deployment Logs**: Monitor deployment progress and errors
- **Container Logs**: View real-time logs from wordpress and db containers
- **MySQL Logs**: Check database initialization and connection logs

## Security Notes

### Current Security Measures
- Database passwords stored as Coolify environment variables (not in repository)
- `.env` file excluded from git via `.gitignore`
- Docker volumes isolated from repository code
- MySQL only accessible within Docker network (no external exposure)

### Security Improvements Needed
- [ ] Configure WordPress salts and security keys
- [ ] Enable HTTPS/SSL certificates
- [ ] Implement automated database backups
- [ ] Configure WordPress security headers
- [ ] Set up fail2ban for brute force protection
- [ ] Regular WordPress core/plugin/theme updates

## Maintenance

### Regular Tasks
- [ ] Update WordPress core, themes, and plugins
- [ ] Monitor database size and optimize tables
- [ ] Review and clean up uploaded media files
- [ ] Check for security updates
- [ ] Backup database and wp-content regularly

### Backup Strategy
1. **Database**: Automated daily MySQL dumps
2. **Files**: Git-tracked wp-content directory
3. **Volumes**: Docker volume backups for wordpress_data

## Coolify Integration

### GitHub Deploy Key
SSH public key added to repository as deploy key:
```
ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQCr4obTvRpbhg2+g13+0aK1tnpgJGeSrpYjdTvDH2Eecd3QPQScAJff0fZ37wC+EHQwYcsP0WU9CJY0XbvOHQSBWf2sbA3o+lHNyKk4kt/8nlEOpPlyyxQBE0uUz636plCpydi4D9z9FgyL5GWeWIDWefunHUyaEOfKLkNfpnJT3d1YK2hqCkJZYt4diXMNGwhYPTi8l6UfRLUKjRbNyMRP90Vtbvq07AWo5zZtOSQGLNOv5+UDvhV/nieKAGbw57W8pRWVyY/SFa16vDr9D+Fd+v4+szda0VxQlFBnxGgr6Qn5yrkZoYqZqJTjeaaxsNIErG/y+hcfnVw++BubpOfZ coolify-generated-ssh-key
```

### Coolify Dashboard Access
- **URL**: https://coolify.dalsoop.com
- **Project**: My first project
- **Environment**: production
- **Application**: jeonghanyun/dalsoop.com:main

### Automated Deployments
- Coolify monitors `main` branch for changes
- Automatic deployment on git push
- Deployment logs available in Coolify dashboard

## Future Improvements

### Performance Optimization
- [ ] Configure Redis for object caching
- [ ] Enable PHP OPcache in WordPress container
- [ ] Implement CDN for static assets
- [ ] Optimize database queries and indexes

### Monitoring & Logging
- [ ] Set up application performance monitoring
- [ ] Configure log aggregation
- [ ] Enable error tracking and alerting
- [ ] Monitor resource usage and scaling needs

### Infrastructure
- [ ] Implement staging environment
- [ ] Set up automated testing pipeline
- [ ] Configure blue-green deployments
- [ ] Implement automated rollback on failure

## Resources

- [Docker Compose Documentation](https://docs.docker.com/compose/)
- [WordPress Docker Hub](https://hub.docker.com/_/wordpress)
- [MySQL Docker Hub](https://hub.docker.com/_/mysql)
- [Coolify Documentation](https://coolify.io/docs)
- [WordPress Codex](https://codex.wordpress.org/)

## Contact & Support

For issues or questions about this deployment:
1. Check Coolify deployment logs
2. Review Docker Compose configuration
3. Verify environment variables in Coolify
4. Check GitHub repository issues
5. Contact system administrator

---

**Last Updated**: 2025-11-08
**Deployment Status**: In Progress (503 Error - Debugging Required)
**Claude Code Integration**: E2E automation with Playwright
