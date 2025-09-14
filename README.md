# Laravel Modular Base Architecture Project

Yo project chai Laravel 10 ma based modular architecture use garera banayako ho. Yo project ma clean code principles, repository pattern, service layer, ra DTOs use gariyako xa.

## 📋 Table of Contents
- [Requirements](#requirements)
- [Installation](#installation)
- [Project Structure](#project-structure)
- [Module Architecture](#module-architecture)
- [Usage](#usage)
- [Module Management](#module-management)
- [Database](#database)
- [Configuration](#configuration)
- [Development Guidelines](#development-guidelines)
- [API Documentation](#api-documentation)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)

## 🔧 Requirements

- PHP >= 8.1
- Composer
- MySQL/PostgreSQL
- Node.js & NPM (frontend assets ko lagi)
- Laravel 10.x

## 🚀 Installation

### Step 1: Project Clone/Download garne
```bash
git clone <repository-url>
cd project-amd
```

### Step 2: Dependencies Install garne
```bash
composer install
npm install
```

### Step 3: Environment Setup
```bash
# .env file copy garne
cp .env.example .env

# Application key generate garne
php artisan key:generate
```

### Step 4: Database Configuration
`.env` file ma database settings configure garne:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 5: Database Setup
```bash
# Migration run garne
php artisan migrate

# Seeders run garne (sample data ko lagi)
php artisan db:seed
```

### Step 6: Storage Link
```bash
php artisan storage:link
```

### Step 7: Server Start garne
```bash
php artisan serve
```

## 📁 Project Structure

```
project-amd/
├── app/
│   ├── Core/                    # Core utilities ra helpers
│   │   ├── DTOs/               # Data Transfer Objects
│   │   ├── Helpers/            # Helper functions
│   │   ├── Repositories/       # Base repository classes
│   │   ├── Services/           # Base service classes
│   │   └── Traits/             # Reusable traits
│   ├── Modules/                # Sabai modules yaha chan
│   │   ├── AuthManagement/     # Authentication module
│   │   ├── DashboardManagement/ # Dashboard module
│   │   └── UserManagement/     # User management module
│   ├── Enum/                   # Enum classes
│   ├── Constants/              # Application constants
│   └── Traits/                 # Global traits
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/               # Database seeders
├── resources/
│   ├── views/                 # Blade templates
│   ├── lang/                  # Language files (en, np)
│   └── js/css/               # Frontend assets
└── routes/                    # Route files
```

## 🏗️ Module Architecture

Har ek module ma yo structure follow gariyako xa:

```
ModuleName/
├── Controllers/          # HTTP Controllers
├── Models/              # Eloquent Models
├── Repositories/        # Data access layer
│   ├── Interfaces/      # Repository interfaces
│   └── Implementations/ # Repository implementations
├── Services/            # Business logic layer
│   ├── Interfaces/      # Service interfaces
│   └── Implementations/ # Service implementations
├── DTOs/               # Data Transfer Objects
├── Requests/           # Form request validation
├── Resources/          # API resources ra views
│   └── views/          # Module specific views
├── Routes/             # Module routes
├── Database/           # Module migrations ra seeders
├── Providers/          # Service providers
└── Config/             # Module configuration
```

## 📖 Usage

### Admin Panel Access
- URL: `http://localhost:8000/admin`
- Default Admin Credentials:
  - Email: admin@example.com
  - Password: password

### Available Routes
- `/` - Home page
- `/admin` - Admin dashboard
- `/admin/users` - User management
- `/admin/roles` - Role management
- `/admin/permissions` - Permission management

## 🔧 Module Management

### Naya Module Banaune
```bash
php artisan make:module ModuleName
```

Yo command le complete module structure banaucha:
- Controllers, Models, Services, Repositories
- Routes, Views, Migrations
- Service Provider

### Module Remove garne
```bash
php artisan module:remove ModuleName
```

### Module List herne
```bash
php artisan module:list
```

## 🗄️ Database

### Available Seeders
- `UserSeeder` - Admin user ra sample users
- `RoleSeeder` - User roles (Admin, User, etc.)
- `PermissionSeeder` - System permissions
- `CountriesTableSeeder` - Countries data
- `ProvinceSeeder` - Nepal ko provinces
- `DistrictSeeder` - Districts data
- `MunicipalitySeeder` - Municipality data

### Migration Commands
```bash
# Sabai migrations run garne
php artisan migrate

# Specific module ko migration
php artisan migrate --path=app/Modules/ModuleName/Database/Migrations

# Migration rollback
php artisan migrate:rollback

# Fresh migration with seeding
php artisan migrate:fresh --seed
```

## ⚙️ Configuration

### Environment Variables
```env
# Application
APP_NAME="Laravel Modular App"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_pass

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
```

### Custom Configuration Files
- `config/pagination_limits.php` - Pagination settings
- Module specific configs in each module's Config folder

## 👨💻 Development Guidelines

### Code Structure
1. **Repository Pattern** use garne - data access ko lagi
2. **Service Layer** use garne - business logic ko lagi
3. **DTOs** use garne - data transfer ko lagi
4. **Form Requests** use garne - validation ko lagi
5. **Traits** use garne - reusable code ko lagi

### Naming Conventions
- Controllers: `PascalCase` + `Controller` suffix
- Models: `PascalCase` (singular)
- Services: `PascalCase` + `Service` suffix
- Repositories: `PascalCase` + `Repository` suffix
- DTOs: `PascalCase` + `DTO` suffix

### Example: Naya Feature Add garne

1. **Model banayera**:
```bash
php artisan make:model Modules/YourModule/Models/YourModel
```

2. **Repository Interface ra Implementation**:
```php
// Interface
interface YourRepositoryInterface {
    public function getAll();
    public function create(array $data);
}

// Implementation
class YourRepository implements YourRepositoryInterface {
    // Implementation code
}
```

3. **Service Layer**:
```php
class YourService {
    public function __construct(
        private YourRepositoryInterface $repository
    ) {}
}
```

## 📚 API Documentation

### Authentication APIs
- `POST /api/login` - User login
- `POST /api/register` - User registration
- `POST /api/logout` - User logout
- `POST /api/refresh` - Token refresh

### User Management APIs
- `GET /api/users` - Get all users
- `POST /api/users` - Create user
- `PUT /api/users/{id}` - Update user
- `DELETE /api/users/{id}` - Delete user

## 🔍 Troubleshooting

### Common Issues

**1. Composer Install Error**
```bash
composer clear-cache
composer install --no-cache
```

**2. Permission Denied Error**
```bash
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

**3. Module Not Found Error**
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

**4. Database Connection Error**
- `.env` file ma database credentials check garne
- Database server running xa ki check garne
- Database exist xa ki check garne

### Useful Commands
```bash
# Cache clear garne
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize garne
php artisan optimize

# Queue work garne
php artisan queue:work

# Schedule run garne
php artisan schedule:work
```

## 🤝 Contributing

1. Fork the repository
2. Create feature branch: `git checkout -b feature/new-feature`
3. Commit changes: `git commit -am 'Add new feature'`
4. Push to branch: `git push origin feature/new-feature`
5. Submit Pull Request

### Code Standards
- PSR-12 coding standards follow garne
- Laravel best practices follow garne
- Proper documentation likhne
- Unit tests likhne (jaha possible xa)

### Pull Request Guidelines
- Clear description dine
- Screenshots include garne (UI changes ko lagi)
- Tests pass gareko confirm garne
- Code review ko lagi ready hune

## 📝 License

Yo project MIT license ma xa. Details ko lagi LICENSE file herne.

## 📞 Support

Kunai problem xa bhane:
1. GitHub Issues ma report garne
2. Documentation ramrari padne
3. Community ma help magne

---

**Note**: Yo documentation continuously update huncha. Latest version ko lagi repository check garne.