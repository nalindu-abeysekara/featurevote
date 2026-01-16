# FeatureVote

A modern feature voting board application that allows users to submit, vote on, and discuss feature requests. Built with CodeIgniter 4, Alpine.js, HTMX, and Tailwind CSS.

## Features

- **User Authentication** - Secure login, registration, and email verification via CodeIgniter Shield
- **Feature Requests** - Submit and browse feature requests with rich descriptions
- **Voting System** - Upvote features you want to see implemented
- **Comments** - Discuss feature requests with other users
- **Categories** - Organize requests by category
- **Status Tracking** - Track request status (Open, Under Review, Planned, In Progress, Completed)
- **Admin Dashboard** - Moderate requests, manage categories, and update statuses
- **Dark Mode** - Toggle between light and dark themes
- **Responsive Design** - Works great on desktop and mobile devices
- **Real-time Updates** - HTMX-powered interactions without full page reloads

## Tech Stack

- **Backend**: PHP 8.1+ with CodeIgniter 4
- **Authentication**: CodeIgniter Shield
- **Frontend**: Alpine.js for reactivity, HTMX for AJAX
- **Styling**: Tailwind CSS
- **Build Tool**: Vite

## Requirements

- PHP 8.1 or higher
- MySQL 5.7+ or SQLite 3
- Composer
- Node.js 18+ and npm

## Quick Start

### 1. Clone the repository

```bash
git clone https://github.com/nalindu-abeysekara/featurevote.git
cd featurevote
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Configure environment

Create a `.env` file in the project root:

```env
CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = featurevote
database.default.username = root
database.default.password = your_password
database.default.DBDriver = MySQLi

app.baseURL = 'http://localhost:8080/'
```

### 4. Create database

```bash
mysql -u root -p -e "CREATE DATABASE featurevote CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
```

### 5. Run Shield setup

```bash
php spark shield:setup
```

### 6. Run migrations

```bash
php spark migrate --all
```

### 7. Seed initial data

```bash
php spark db:seed InitialSeeder
```

### 8. Create an admin user

```bash
php spark shield:user create
php spark shield:user addgroup admin your-username
```

### 9. Build frontend assets

For development (with hot reload):
```bash
npm run dev
```

For production:
```bash
npm run build
```

### 10. Start the server

```bash
php spark serve
```

Visit **http://localhost:8080** in your browser.

## Development

Run both servers in separate terminals for development:

```bash
# Terminal 1 - Vite dev server (hot reload for CSS/JS)
npm run dev

# Terminal 2 - PHP development server
php spark serve
```

## Project Structure

```
featurevote/
├── app/
│   ├── Config/         # Application configuration
│   ├── Controllers/    # HTTP controllers
│   ├── Database/
│   │   ├── Migrations/ # Database schema migrations
│   │   └── Seeds/      # Database seeders
│   ├── Filters/        # Request filters (auth, admin)
│   ├── Helpers/        # Custom helper functions
│   ├── Models/         # Eloquent-style models
│   └── Views/          # Blade-like view templates
├── public/             # Web root (index.php, assets)
├── resources/
│   ├── css/            # Tailwind CSS source
│   └── js/             # Alpine.js & HTMX setup
├── writable/           # Cache, logs, sessions, uploads
├── tailwind.config.js  # Tailwind configuration
└── vite.config.js      # Vite build configuration
```

## License

MIT License

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.
