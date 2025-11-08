# Dalsoop.com

WordPress website for dalsoop.com

## Deployment with Docker Compose

### Prerequisites
- Docker and Docker Compose installed
- Environment variables configured

### Quick Start

1. Copy environment template:
   ```bash
   cp .env.example .env
   ```

2. Edit `.env` and set secure passwords:
   ```bash
   DB_PASSWORD=your_secure_password
   DB_ROOT_PASSWORD=your_root_password
   ```

3. Start services:
   ```bash
   docker-compose up -d
   ```

4. Access WordPress installation:
   ```
   http://localhost
   ```

### Coolify Deployment

This project is configured for Coolify deployment with Docker Compose:

1. Set Environment Variables in Coolify:
   - `DB_PASSWORD`: Database user password
   - `DB_ROOT_PASSWORD`: Database root password

2. Build Pack: Docker Compose

3. Domain: www.dalsoop.com

### Services

- **WordPress**: Port 80 (WordPress 6.4 + PHP 8.2 + Apache)
- **MySQL**: Port 3306 (MySQL 8.0, internal only)

### Volumes

- `wordpress_data`: WordPress installation files
- `db_data`: MySQL database files
- `./wp-content`: Custom themes and plugins (Git tracked)

## Development

This is a WordPress installation. Custom themes and plugins should be added to:
- Themes: `/wp-content/themes/`
- Plugins: `/wp-content/plugins/`

## Requirements (Docker Compose)

- Docker 20.10 or greater
- Docker Compose 2.0 or greater

## License

WordPress is licensed under GPL v2 or later.
