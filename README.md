

```markdown
# Workshop App

A Laravel-based custom furniture pre-order management system. This app enables users to configure custom furniture products (dimensions, materials, colors, etc.) and manage the full order workflow.

## Features

- **User Authentication** using Laravel Breeze
- **Role & Permission** with Spatie
- **Dynamic Product Configuration**
- **Interactive Datatables**
- **Order Tracking System**

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/bangayee/workshop-app.git
   cd workshop-app
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   npm run build
   ```

3. Set up environment variables:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Link storage:
   ```bash
   php artisan storage:link
   ```

5. Seed the database (optional for initial testing):
   ```bash
   php artisan db:seed
   ```

6. Serve the application:
   ```bash
   php artisan serve
   ```

## Testing Credentials

- **Email:** `admin@gmail.com`
- **Password:** `12345678`

## Tech Stack

- Laravel 10.x
- Laravel Breeze (Tailwind + Alpine)
- Spatie Permission
- Laravel Datatables
- Vite + Blade
- MySQL

## License

MIT License
```

