# 🧪 Lab Data Manager

A robust, enterprise-grade, containerized Laboratory Data Management System designed for high availability, security, and seamless orchestrations.

This repository leverages modern containerization and **Infrastructure-as-Code (IaC)** concepts using **Docker Compose**, **Nginx**, **PHP (Laravel 12.x)**, and **Vue.js 3 (Vite + Tailwind CSS)** to deliver a multi-service architecture ready for development and staging environments.

---

## 🏗 System Architecture & IaC Design

The system implements a decoupled microservices-oriented topology. Rather than running a monolithic stack, components are segregated into distinct, isolated containers with network policies and health/dependency configurations defined purely in code.

```
                      +-------------------+
                      |   Client Browser  |
                      +---------+---------+
                                |
                                | (Port 8080)
                                v
                      +---------+---------+
                      |    Nginx Proxy    |
                      +----+---------+----+
                           |         |
      (Proxy Pass /)       |         | (/api -> FastCGI)
      (Vite Dev Server)    |         |
                           v         v
                +----------+--+   +--+----------+
                |   Frontend  |   |     App     |
                |  (Vue/Vite) |   |  (PHP-FPM)  |
                +-------------+   +-----+-------+
                                        |
                                        | (Port 3306)
                                        v
                                  +-----+-------+
                                  |   Database  |
                                  |   (MySQL)   |
                                  +-----+-------+
                                        ^
                                        | (Port 3400)
                                  +-----+-------+
                                  | phpMyAdmin  |
                                  +-------------+
```

### Infrastructure Components & Port Mapping
The orchestrated services and their exposure matrix are declared in `docker-compose.yml`:

| Service Container Name | Technology | Internal Port | Exposed Port | Volumes & Storage | Purpose |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **nginx_lab_manager** | Nginx:Alpine | `80` | `8080` | `./nginx/conf.d/` mapped to `/etc/nginx/conf.d/` | Reverse proxy and request dispatcher. Routes `/api` to PHP-FPM, `/` to Vue dev server. |
| **vue_lab_manager** | Node:20-Alpine / Vue 3 | `5173` | `5173` | `./frontend:/app` (with `/app/node_modules` exclusion) | Modern interactive interface, hot-reloading reactive UI. |
| **app** | Custom PHP 8.2 FPM | `9000` | `9000` (internal proxy) | `./src:/var/www` | Core API business logic engine running Laravel. |
| **mysql** | MySQL (linux/arm64) | `3306` | `3306` | `./mysql/data:/var/lib/mysql`, `init.sql` entries | Persistent relational storage for lab registers, results, and parameters. |
| **phpmyadmin** | phpMyAdmin | `80` | `3400` | None | Interactive UI for database modeling and query troubleshooting. |

---

## 🛠 Features

* **Multi-Container Orchestration (IaC):** Entire infrastructure configuration is standardized in code, enabling immediate replication across different machines without manual installs.
* **Smart Reverse Proxy Routing:** Custom Nginx virtual host proxies requests dynamically. Frontend Vite assets, WebSockets (HMR), and API fastcgi routes are transparently managed through Port `8080`.
* **Robust Backend Framework:** Driven by Laravel 12.x, utilizing migrations, Eloquent ORM relationships, custom controllers, and robust API resources.
* **Component-Based Frontend UI:** Vue 3 framework complete with composition API, unified layout systems, Tailwind CSS utility style guidelines, and responsive tables.
* **Data Persistence & Isolation:** Dedicated database directory mounts prevent local data loss during container rebuilding. Seed structures are auto-executed on initial startup.

---

## 🚀 Deployment & Local Installation

### Prerequisites
* Docker Desktop & Compose installed.
* Ports `8080`, `5173`, `3306`, and `3400` available on the host machine.

### Installation Instructions

1. **Clone the Repository**
   ```bash
   git clone https://github.com/shashidas95/lab-data-manager.git
   cd lab-data-manager
   ```

2. **Configure Environment Parameters**
   Copy the default Laravel environment variables:
   ```bash
   cp src/.env.example src/.env
   ```

3. **Spin up the Docker Stack**
   ```bash
   docker-compose up -d --build
   ```
   *This single command builds local Dockerfiles, mounts source volumes, maps external ports, initiates the MySQL database, and loads the Nginx reverse-proxy.*

4. **Initialize App Key & Permissions (Backend)**
   Run key generator inside the running application container:
   ```bash
   docker compose exec app php artisan key:generate
   docker compose exec app php artisan migrate --seed
   ```

5. **Accessing the Services**
   - **Frontend App / Main Gateway:** [http://localhost:8080](http://localhost:8080)
   - **Interactive phpMyAdmin Interface:** [http://localhost:3400](http://localhost:3400)
   - **Backend API Status Check:** [http://localhost:8080/api/labs](http://localhost:8080/api/labs)

---

## 📂 Project Structure

```
.
├── docker-compose.yml       # Primary container orchestrator configurations
├── nginx/
│   └── conf.d/
│       └── default.conf     # Virtual host configuration for API and proxy passes
├── php/
│   └── Dockerfile           # Tailored PHP-FPM image containing composer, pdo_mysql, and pgsql
├── mysql/
│   ├── init.sql             # SQL DB initialization bootstrapping script
│   ├── db.sql               # Snapshot dump for database configuration and migration tables
│   └── data/                # Persisted MySQL state storage (gitignored)
├── frontend/
│   ├── Dockerfile           # Fast Node/Vite workspace builder
│   ├── src/                 # Reactive components, composables, views, and store modules
│   └── package.json         # Node.js frontend scripts and Tailwind/Vue configurations
└── src/
    ├── app/                 # Laravel Core Controllers, Models, and Providers
    ├── bootstrap/           # Boot and caching hooks
    ├── database/            # Migrations (offices, labs, units, parameters, samples, products)
    ├── routes/api.php       # Fully declared API endpoints
    └── phpunit.xml          # Back-end testing orchestrations
```

---

## 🔌 API Reference Guide

All backend routes are prefixed with `/api`. The main controller resources expose RESTful interfaces:

| HTTP Method | Route Endpoint | Purpose |
| :--- | :--- | :--- |
| **GET** | `/api/labs` | Retrieve lists of registered active laboratories. |
| **POST** | `/api/labs` | Create and store a new laboratory record. |
| **GET** | `/api/offices` | Retrieve regional offices and regulatory centers. |
| **GET** | `/api/products` | Retrieve registered chemical / item products. |
| **GET** | `/api/parameters` | List parameters checked (e.g., pH, concentration, density). |
| **GET** | `/api/samples` | List all lab test samples and tracking codes. |
| **GET** | `/api/public/verify/{id}` | Public endpoint for fast verification of sample validity. |

---

## 🧪 Testing and Verification

Ensure backend functionality remains stable. You can execute PHPUnit tests inside the app container:

```bash
docker compose exec app php artisan test
```

For running tests locally during development (outside Docker):
```bash
cd src
composer install
cp .env.example .env
php artisan key:generate
php artisan test
```

---

## 🔧 Troubleshooting & FAQ

#### 1. Missing Encryption Key Exception
If you get `No application encryption key has been specified`, simply execute:
```bash
docker compose exec app php artisan key:generate
```

#### 2. Connection refused to MySQL Database
Verify that the `DB_HOST` in `src/.env` matches the container service name:
```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=lab_data_manager
DB_USERNAME=root
DB_PASSWORD=shashi
```

#### 3. Storage Permission Denied (Laravel)
If PHP-FPM cannot write to the storage directories:
```bash
docker compose exec app chmod -R 777 storage bootstrap/cache
```

#### 4. Frontend hot reload fails (Vite WebSocket)
Ensure that Vite is run with `--host` to bind to internal Docker interfaces. This is configured automatically inside `frontend/Dockerfile` (`CMD ["npm", "run", "dev", "--", "--host"]`).

#### 5. Address already in use / Port 5173 is bound
If port `5173` is already in use on your host machine (e.g., by another local project or local Vite process), you can customize the mapped frontend host port using the `FRONTEND_PORT` environment variable before running Docker Compose:
```bash
FRONTEND_PORT=5174 docker compose up -d
```
Alternatively, you can define it in a `.env` file at the root of the repository:
```env
FRONTEND_PORT=5174
```
