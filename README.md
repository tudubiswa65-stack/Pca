# Padmabati Computer Academy - Multi-Service Infrastructure

This monorepo contains 4 independently deployable services for the Padmabati Computer Academy digital platform. Each service is a self-contained Laravel 11 application deployable directly on Railway using its own `railway.toml` and `Dockerfile`.

## Services Overview

| Service | Path | Purpose | Framework | Health Check |
|---------|------|---------|-----------|-------------|
| **Backend** | `/backend` | Student API (auth, courses, assignments) | Laravel 11 + PHP 8.2 | `/api/health` |
| **Frontend** | `/frontend` | Public website + Student portal | Laravel 11 + Inertia.js + Vue 3 | `/api/health` |
| **Admin Backend** | `/admin-backend` | Admin REST API (IP-restricted) | Laravel 11 + PHP 8.2 + Supabase | `/api/health` |
| **Admin Frontend** | `/admin-frontend` | Admin dashboard UI | Laravel 11 + Inertia.js + Vue 3 | `/api/health` |

## Repository Structure

```
Pca/
├── backend/              # Student API service
│   ├── Dockerfile        # Multi-stage Node + PHP build
│   ├── railway.toml      # Railway deployment config
│   ├── package.json      # build + start scripts
│   ├── .env.example      # Environment variable template
│   ├── docker/           # Nginx, PHP-FPM, Supervisord, start.sh
│   ├── app/              # Laravel application code
│   ├── routes/api.php    # API routes including /health
│   └── ...
├── frontend/             # Public + Student portal service
│   ├── Dockerfile
│   ├── railway.toml
│   ├── package.json      # build + start scripts (Vite)
│   ├── .env.example
│   ├── docker/
│   ├── routes/web.php    # Web routes
│   ├── routes/api.php    # API health check
│   └── ...
├── admin-backend/        # Admin API service
│   ├── Dockerfile
│   ├── railway.toml
│   ├── package.json
│   ├── .env.example
│   └── ...
└── admin-frontend/       # Admin panel UI service
    ├── Dockerfile
    ├── railway.toml
    ├── package.json      # build + start scripts (Vite)
    ├── .env.example
    └── ...
```

## Infrastructure Components

### Docker Configuration
Each service uses an identical multi-stage Docker build:
- **Stage 1** (Node.js 20 Alpine): Compiles Vite frontend assets
- **Stage 2** (PHP 8.2-FPM Alpine): Runs Laravel with Nginx + Supervisord
- **PHP Extensions**: PDO PostgreSQL, Redis, GD, BCMath, OPcache
- **Production optimizations**: OPcache enabled, composer optimized autoloader
- **Port**: Dynamically bound to `$PORT` (Railway injects this at runtime)

### Database & Cache
- **PostgreSQL**: Primary database (provision via Railway PostgreSQL plugin)
- **Redis**: Session storage, caching, and queue management (provision via Railway Redis plugin)

### Security Features
- **CORS** configuration per service
- **Admin IP restrictions** for admin services
- **Security headers**: HSTS, XSS Protection, Content Type Options, etc.
- **File access protection**: `.env`, `.git`, `vendor`, `storage` blocked via Nginx

---

## 🚀 Railway Deployment (Step-by-Step)

Each service deploys **independently** on Railway. Follow these steps for each of the 4 services.

> **Key concept**: In Railway, create one **Project** with 4 separate **Services**, each pointed at a different subdirectory of this repo.

### Prerequisites
- Railway account at [railway.app](https://railway.app)
- This repository connected to Railway via GitHub

---

### Step 1 — Create a Railway Project

1. Go to [railway.app/new](https://railway.app/new)
2. Click **"Deploy from GitHub repo"**
3. Select this repository (`toakasan3/Pca`)
4. Railway will create a Project

---

### Step 2 — Add PostgreSQL and Redis Plugins

In your Railway project:
1. Click **"+ New"** → **"Database"** → **"Add PostgreSQL"**
2. Click **"+ New"** → **"Database"** → **"Add Redis"**

Railway will automatically expose connection variables (`DATABASE_URL`, `REDIS_URL`, etc.) that you can reference in your services.

---

### Step 3 — Deploy Each Service

For **each** of the 4 services (`backend`, `frontend`, `admin-backend`, `admin-frontend`):

#### 3a. Add a New Service
1. In your Railway project, click **"+ New"** → **"GitHub Repo"**
2. Select this repo again (`toakasan3/Pca`)

#### 3b. Set the Root Directory
1. Go to the service's **Settings** tab
2. Under **"Source"**, set **"Root Directory"** to the service folder:
   - `backend` → set root to `backend`
   - `frontend` → set root to `frontend`
   - `admin-backend` → set root to `admin-backend`
   - `admin-frontend` → set root to `admin-frontend`
3. Railway will now find the `Dockerfile` and `railway.toml` inside that directory and use them automatically.

#### 3c. Configure Environment Variables
1. Go to the service's **Variables** tab
2. Click **"RAW Editor"** and paste the contents of the service's `.env.example`
3. Fill in all required values (see [Environment Variables](#environment-variables) section)

> ⚠️ **Important — `APP_KEY`**: Generate this **once** locally using `php artisan key:generate --show` (or `docker run --rm php:8.2-cli php -r "echo 'base64:'.base64_encode(random_bytes(32));"`) and store it as a permanent Railway variable. Do **not** leave it empty — `start.sh` will auto-generate one as a fallback, but this changes on every deployment and will invalidate all sessions and encrypted data.

#### 3d. Deploy
1. Click **"Deploy"** — Railway builds the Dockerfile and starts the container
2. The service is healthy when `GET /api/health` returns `{"status":"ok"}`

---

### Step 4 — Configure Service URLs

After all 4 services are deployed, update their `APP_URL` environment variables and CORS settings:

| Service | Suggested Variable | Example Value |
|---------|-------------------|---------------|
| backend | `APP_URL` | `https://pca-backend.up.railway.app` |
| frontend | `APP_URL` | `https://pca-frontend.up.railway.app` |
| admin-backend | `APP_URL` | `https://pca-admin-backend.up.railway.app` |
| admin-frontend | `APP_URL` | `https://pca-admin-frontend.up.railway.app` |

Update `CORS_ALLOWED_ORIGINS` in each backend service to point to the corresponding frontend URL.

---

## Environment Variables

Each service has a `.env.example` file. Key variables to configure:

### All Services
```env
APP_NAME="PCA Service Name"
APP_KEY=                        # REQUIRED: Generate once with `php artisan key:generate --show` and store permanently
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-service.up.railway.app

DB_CONNECTION=pgsql
DB_HOST=                        # From Railway PostgreSQL plugin
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=                    # From Railway PostgreSQL plugin

REDIS_URL=                      # From Railway Redis plugin
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### Backend Only
```env
TWILIO_SID=                     # For SMS OTP
TWILIO_TOKEN=
TWILIO_FROM=
CORS_ALLOWED_ORIGINS=https://pca-frontend.up.railway.app
```

### Admin Backend Only
```env
CORS_ADMIN_ORIGINS=https://pca-admin-frontend.up.railway.app
ADMIN_ALLOWED_IPS=              # Comma-separated IP whitelist (leave empty to allow all)
```

### Supabase (Optional — Admin Backend)
```env
SUPABASE_URL=
SUPABASE_ANON_KEY=
SUPABASE_SERVICE_KEY=
```

---

## Local Development (Without Docker)

> **Note on `npm start`**: For PHP backend services (`backend`, `admin-backend`), `npm start` runs `php artisan serve` as a local development convenience only. On Railway with `builder = "DOCKERFILE"`, Railway builds and runs the Dockerfile directly — `npm start` is never invoked. The production server (Nginx + PHP-FPM via Supervisord) is managed entirely by the Dockerfile's `CMD` (`/start.sh`).

### Prerequisites
- PHP 8.2+, Composer, Node.js 20+, PostgreSQL, Redis

```bash
# Clone the repo
git clone https://github.com/toakasan3/Pca.git
cd Pca

# Setup each service individually
cd backend
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
npm install && npm run build
php artisan serve --port=8000

# Repeat for other services on different ports
```

### Local Development with Docker (per-service)

Each service can be built and run independently:

```bash
# Backend service
cd backend
docker build -t pca-backend .
docker run -p 8000:8080 --env-file .env pca-backend

# Frontend service
cd frontend
docker build -t pca-frontend .
docker run -p 8001:8080 --env-file .env pca-frontend

# Admin Backend
cd admin-backend
docker build -t pca-admin-backend .
docker run -p 8002:8080 --env-file .env pca-admin-backend

# Admin Frontend
cd admin-frontend
docker build -t pca-admin-frontend .
docker run -p 8003:8080 --env-file .env pca-admin-frontend
```

---

## Service Dependencies

```
External Services: PostgreSQL + Redis (Railway plugins)
           ↓
Backend (Student API)  ←→  Admin Backend (Admin API)
           ↓                        ↓
Frontend (Student Portal)   Admin Frontend (Admin Panel)
```

All 4 services connect independently to the same PostgreSQL and Redis instances. There are no direct service-to-service dependencies at the infrastructure level.

---

## Troubleshooting Railway Deployments

| Error | Cause | Fix |
|-------|-------|-----|
| `Railpack could not determine how to build` | Root Directory not set | Set Root Directory to the service subfolder (e.g., `backend`) in Railway service Settings |
| `Health check failed` | App not yet started | Increase `healthcheckTimeout` in `railway.toml` or check service logs |
| `APP_KEY not set` | Missing env var | `start.sh` auto-generates it, or set manually in Railway Variables tab |
| Database connection error | Wrong DB env vars | Copy values from Railway PostgreSQL plugin's Connect tab |
| `502 Bad Gateway` | PHP-FPM not running | Check Railway service logs — Supervisord manages both Nginx and PHP-FPM |