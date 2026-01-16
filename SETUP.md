# FeatureVote - Setup Guide

## Requirements

- PHP 8.1+
- MySQL 5.7+ or SQLite 3
- Composer
- Node.js 18+ & npm

## Quick Setup

### 1. Install PHP Dependencies

```bash
composer install
```

### 2. Install Node Dependencies

```bash
npm install
```

### 3. Configure Environment

Copy the `.env` file and update database settings:

```bash
# Edit .env file with your database credentials
database.default.hostname = localhost
database.default.database = featurevote
database.default.username = root
database.default.password = your_password
```

### 4. Create Database

```bash
mysql -u root -p -e "CREATE DATABASE featurevote CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
```

### 5. Run Shield Setup

This will publish Shield's migrations and configuration:

```bash
php spark shield:setup
```

### 6. Run Migrations

```bash
php spark migrate --all
```

### 7. Seed Initial Data

```bash
php spark db:seed InitialSeeder
```

### 8. Create Admin User

```bash
php spark shield:user create
```

Then add to admin group:

```bash
php spark shield:user addgroup admin your-username
```

### 9. Build Frontend Assets

For development:
```bash
npm run dev
```

For production:
```bash
npm run build
```

### 10. Start Development Server

```bash
php spark serve
```

Visit: http://localhost:8080

---

## Development

### Running Vite Dev Server

Keep the Vite dev server running for hot-reload:

```bash
npm run dev
```

### Running PHP Server

In another terminal:

```bash
php spark serve
```

---

## Project Structure

```
featurevote/
├── app/
│   ├── Config/         # Configuration files
│   ├── Controllers/    # HTTP controllers
│   ├── Database/
│   │   ├── Migrations/ # Database migrations
│   │   └── Seeds/      # Database seeders
│   ├── Filters/        # Request filters
│   ├── Helpers/        # Helper functions
│   ├── Models/         # Database models
│   └── Views/          # View templates
├── public/             # Public assets
├── resources/
│   ├── css/           # Tailwind CSS
│   └── js/            # JavaScript (Alpine.js, HTMX)
├── writable/          # Cache, logs, uploads
├── .env               # Environment config
├── composer.json      # PHP dependencies
├── package.json       # Node dependencies
├── tailwind.config.js # Tailwind config
└── vite.config.js     # Vite config
```

---

## Features

### Day 1 (Foundation)
- [x] CodeIgniter 4 setup
- [x] Database migrations
- [x] Models with relationships
- [x] Shield authentication (login, register, logout)
- [x] Email verification flow
- [x] Basic Tailwind layout

### Day 2 (Public Features)
- [ ] Public board page
- [ ] Request cards with votes
- [ ] Sorting & filtering
- [ ] Request detail page
- [ ] HTMX vote button
- [ ] Submit request form

### Day 3 (Admin Features)
- [ ] Admin dashboard
- [ ] Moderation queue
- [ ] Request management
- [ ] Category management
- [ ] Comments

### Day 4 (Polish)
- [ ] Dark mode
- [ ] Mobile responsive
- [ ] Roadmap page
- [ ] Email notifications
- [ ] Installer wizard
