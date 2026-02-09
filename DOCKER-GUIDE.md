# Docker Deployment Guide

This guide explains how to deploy the CBM Auto Car Service application using Docker and Docker Compose.

## Prerequisites

- Docker Engine 20.10 or higher
- Docker Compose 2.0 or higher
- Git (for cloning the repository)

## Quick Start

1. **Clone the repository** (if not already done):
```bash
git clone <repository-url>
cd car-service
```

2. **Create environment file**:
```bash
cp .env.example .env
```

3. **Configure environment variables** in `.env`:
```env
# Application
APP_KEY=base64:your-generated-key-here
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=db
DB_DATABASE=car_service
DB_USERNAME=root
DB_PASSWORD=your-secure-password

# Redis (already configured)
CACHE_STORE=redis
SESSION_DRIVER=redis
REDIS_HOST=redis

# Admin Account (created on first run)
ADMIN_EMAIL=admin@cbmauto.com
ADMIN_PASSWORD=your-secure-admin-password
ADMIN_NAME=Admin

# Email (configure for production)
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-email-password
MAIL_FROM_ADDRESS=noreply@cbmauto.com
```

4. **Generate application key**:
```bash
# If you don't have one yet
docker run --rm -v $(pwd):/app -w /app php:8.4-cli php artisan key:generate --show
```

5. **Start the services**:
```bash
docker-compose up -d
```

6. **Access the application**:
- Application: http://localhost:8000
- Admin login: Use credentials from ADMIN_EMAIL and ADMIN_PASSWORD

## Services

The Docker Compose setup includes:

- **app**: Laravel application (PHP 8.4 with Apache)
- **db**: MySQL 8.0 database
- **redis**: Redis 8.0 for caching and sessions

## Service Management

### Start services
```bash
docker-compose up -d
```

### Stop services
```bash
docker-compose down
```

### View logs
```bash
# All services
docker-compose logs -f

# Specific service
docker-compose logs -f app
docker-compose logs -f db
docker-compose logs -f redis
```

### Restart services
```bash
docker-compose restart
```

### Rebuild after code changes
```bash
docker-compose up -d --build
```

## Database Management

### Run migrations
```bash
docker-compose exec app php artisan migrate
```

### Seed database
```bash
docker-compose exec app php artisan db:seed
```

### Access MySQL CLI
```bash
docker-compose exec db mysql -u root -p
```

### Backup database
```bash
docker-compose exec db mysqldump -u root -p car_service > backup.sql
```

### Restore database
```bash
docker-compose exec -T db mysql -u root -p car_service < backup.sql
```

## Redis Management

### Connect to Redis CLI
```bash
docker-compose exec redis redis-cli
```

### Clear Redis cache
```bash
docker-compose exec redis redis-cli FLUSHALL
```

### Monitor Redis
```bash
docker-compose exec redis redis-cli MONITOR
```

## Application Management

### Clear application cache
```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear
docker-compose exec app php artisan route:clear
```

### Create admin user manually
```bash
docker-compose exec app php artisan user:create-admin admin@example.com --password=password
```

### Run artisan commands
```bash
docker-compose exec app php artisan <command>
```

## Storage Permissions

If you encounter permission issues with storage:

```bash
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

## Production Deployment

### Environment Configuration

1. Set `APP_ENV=production` and `APP_DEBUG=false`
2. Use strong passwords for database and admin
3. Configure proper email settings
4. Set correct `APP_URL`
5. Enable SSL/HTTPS

### Security Recommendations

1. **Use secrets management**: Don't commit `.env` to version control
2. **Regular backups**: Schedule automated database backups
3. **Update images**: Keep Docker images updated
   ```bash
   docker-compose pull
   docker-compose up -d
   ```
4. **Monitor logs**: Set up log aggregation
5. **Firewall**: Only expose necessary ports

### Performance Optimization

1. **Redis configuration**: Already optimized with persistence enabled
2. **MySQL tuning**: Add custom MySQL configuration if needed
3. **PHP opcache**: Enabled by default in production
4. **CDN**: Consider using CDN for static assets

## Custom Configuration

### Ports

Change application port by setting in `.env`:
```env
APP_PORT=8080
```

Then access at: http://localhost:8080

### MySQL Configuration

Create `docker/mysql.cnf` for custom MySQL settings:
```cnf
[mysqld]
max_connections=200
innodb_buffer_pool_size=1G
```

Update `docker-compose.yml`:
```yaml
db:
  volumes:
    - ./docker/mysql.cnf:/etc/mysql/conf.d/custom.cnf
```

### Redis Configuration

For production Redis tuning, update `docker-compose.yml`:
```yaml
redis:
  command: redis-server --appendonly yes --maxmemory 256mb --maxmemory-policy allkeys-lru
```

## Troubleshooting

### Application won't start
```bash
# Check logs
docker-compose logs app

# Verify environment
docker-compose exec app php artisan env

# Test database connection
docker-compose exec app php artisan migrate:status
```

### Database connection failed
```bash
# Check database is running
docker-compose ps db

# Verify database credentials in .env
# Ensure DB_HOST=db (not localhost or 127.0.0.1)
```

### Redis connection failed
```bash
# Check Redis is running
docker-compose ps redis

# Test Redis connection
docker-compose exec redis redis-cli ping

# Verify REDIS_HOST=redis in .env
```

### Permission errors
```bash
# Fix storage permissions
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

## Health Checks

All services include health checks:

```bash
# Check service health
docker-compose ps

# Healthy services show (healthy) status
```

## Data Persistence

Data is persisted in Docker volumes:
- `db-data`: MySQL database
- `redis-data`: Redis persistence
- `./storage`: Application storage (host mount)
- `./database`: SQLite files if used (host mount)

## Scaling

To run multiple app instances behind a load balancer:

```yaml
services:
  app:
    deploy:
      replicas: 3
```

Note: Requires Docker Swarm or Kubernetes for orchestration.

## Monitoring

Recommended monitoring stack:
- Prometheus + Grafana for metrics
- ELK Stack for logs
- Redis monitoring with RedisInsight

## Backup Strategy

### Automated backups

Create a backup script `backup.sh`:
```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
docker-compose exec -T db mysqldump -u root -p$DB_PASSWORD car_service > "backups/db_$DATE.sql"
tar -czf "backups/storage_$DATE.tar.gz" storage/
```

Schedule with cron:
```bash
0 2 * * * /path/to/backup.sh
```

## Support

For issues or questions:
- Check logs: `docker-compose logs -f`
- Review environment variables
- Verify network connectivity between services
- Check Docker and Docker Compose versions
