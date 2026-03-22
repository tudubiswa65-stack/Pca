# Padmabati Computer Academy - Monorepo Infrastructure

This monorepo contains the complete infrastructure setup for Padmabati Computer Academy's digital platform.

## Services Overview

### 1. Backend (Student API) - Port 8000
- **Path**: `/backend`
- **Purpose**: Student API backend with authentication, course management, and assignments
- **Health Check**: `http://localhost:8000/api/health`
- **Framework**: Laravel 11 + PHP 8.2

### 2. Frontend (Public + Student Portal) - Port 8001  
- **Path**: `/frontend`
- **Purpose**: Public website and student portal interface
- **Health Check**: `http://localhost:8001/api/health`
- **Framework**: Laravel 11 + Inertia.js + Vue 3

### 3. Admin Backend (Admin API) - Port 8002
- **Path**: `/admin-backend`
- **Purpose**: Admin API with IP restrictions and comprehensive management features
- **Health Check**: `http://localhost:8002/api/health`
- **Framework**: Laravel 11 + PHP 8.2

### 4. Admin Frontend (Admin Panel) - Port 8003
- **Path**: `/admin-frontend`  
- **Purpose**: Administrative panel for managing students, courses, and analytics
- **Health Check**: `http://localhost:8003/api/health`
- **Framework**: Laravel 11 + Inertia.js + Vue 3

## Infrastructure Components

### Docker Configuration
- **Multi-stage builds** with Node.js 20 (Alpine) + PHP 8.2-FPM (Alpine)
- **Nginx** as reverse proxy with security headers
- **Supervisord** for process management
- **PHP Extensions**: PDO PostgreSQL, Redis, GD, BCMath, OPcache
- **Production optimizations**: OPcache enabled, composer optimized autoloader

### Database & Cache
- **PostgreSQL 15**: Primary database
- **Redis 7**: Session storage, caching, and queue management

### Security Features
- **CORS** configuration per service
- **Admin IP restrictions** for admin services
- **Security headers**: HSTS, XSS Protection, Content Type Options, etc.
- **File access protection**: `.env`, `.git`, `vendor`, `storage` blocked

### Environment Variables
Each service has a comprehensive `.env.example` with:
- Database configuration (PostgreSQL)
- Redis connection
- Supabase integration
- Email & SMS (Twilio) settings
- CORS origins
- Service-specific settings

## Quick Start

1. **Clone and setup**:
   ```bash
   cd /path/to/Pca
   cp backend/.env.example backend/.env
   cp frontend/.env.example frontend/.env
   cp admin-backend/.env.example admin-backend/.env
   cp admin-frontend/.env.example admin-frontend/.env
   ```

2. **Generate application keys** (when Laravel is fully installed):
   ```bash
   # For each service directory:
   php artisan key:generate
   ```

3. **Start with Docker Compose**:
   ```bash
   docker-compose up --build
   ```

4. **Access services**:
   - Student API: http://localhost:8000
   - Public/Student Portal: http://localhost:8001
   - Admin API: http://localhost:8002  
   - Admin Panel: http://localhost:8003
   - Database: localhost:5432 (postgres/postgres)
   - Redis: localhost:6379

## Railway Deployment

Each service includes `railway.toml` configuration for easy Railway deployment:
- Dockerfile builder
- Health checks on `/api/health`
- Automatic restarts on failure
- Environment variable injection

## Next Steps (Part 2+)

The infrastructure is now ready for:
- Laravel application development
- Database migrations and seeders
- Frontend component development
- API endpoint implementation
- Authentication system integration
- Payment gateway setup
- Real-time features with websockets

## Service Dependencies

```
PostgreSQL & Redis (Base Infrastructure)
    ↓
Backend (Student API) + Admin Backend (Admin API)
    ↓
Frontend (Student Portal) + Admin Frontend (Admin Panel)
```

All services include comprehensive Docker configurations, health checks, and are ready for both local development and production deployment on Railway.