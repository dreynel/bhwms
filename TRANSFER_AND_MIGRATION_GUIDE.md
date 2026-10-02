# BHWMS Computer Transfer & Database Migration Guide

**Barangay Health Worker Management System (BHWMS)**  
*Barangay Poblacion, Municipality of New Lucena, Province of Iloilo*

---

## 📌 Quick Start (Transfer to Another Computer)

When transferring this project folder to another laptop or desktop (for capstone presentation, defense, or evaluation), follow these simple steps:

### Option 1: One-Click Automated Setup (Easiest & Recommended)

1. **Copy the `BHWMS` folder** to the new computer (e.g., inside `C:\xampp\htdocs\BHWMS` or any directory).
2. **Start MySQL and Apache** (via XAMPP Control Panel or MySQL Windows Service).
3. **Double-click `setup.bat`** in the project root folder.
   - It automatically creates `.env` with MySQL configuration.
   - It connects to MySQL and creates `bhwms_db` if it doesn't exist.
   - It runs all migrations and populates clean demonstration data.
4. **Double-click `run.bat`** to start the local server and automatically open the application in your browser (`http://127.0.0.1:8000`).

---

### Option 2: Command Line Setup

Open PowerShell or Command Prompt inside the `BHWMS` folder and run:

```bash
# 1. Copy environment file (if .env doesn't exist)
copy .env.example .env

# 2. Run automated MySQL initialization, migration, and seeder
php artisan bhwms:setup --fresh

# 3. Start local development server
php artisan serve
```

Then visit **[http://127.0.0.1:8000](http://127.0.0.1:8000)** in your web browser.

---

## 🔑 Demonstration Accounts

All demo accounts use the standard password: `password`

| Role | Name | Email | Password | Scope / Purok Assignment |
| :--- | :--- | :--- | :--- | :--- |
| **Punong Barangay (Admin)** | Hon. Jose R. Maravilla | `admin@newlucena.gov.ph` | `password` | Complete Barangay Admin Access |
| **Health Supervisor** | Dr. Maria Santos, MD | `supervisor@newlucena.gov.ph` | `password` | Municipal Health Supervision |
| **BHW Worker 1** | Ana Garcia | `bhw1@newlucena.gov.ph` | `password` | Assigned: Purok 1 & Purok 2 |
| **BHW Worker 2** | Maria Clara | `bhw2@newlucena.gov.ph` | `password` | Assigned: Purok 3 & Purok 4 |
| **BHW Worker 3** | Juana Dela Cruz | `bhw3@newlucena.gov.ph` | `password` | Assigned: Purok 5 |

> **Tip for Defense:** On the login page, you can click the quick-fill buttons (`Punong Barangay`, `Health Supervisor`, `BHW Ana`) to auto-fill credentials instantly without typing.

---

## ⚙️ MySQL Database Configuration

In `.env`, the database connection parameters are configured as:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bhwms_db
DB_USERNAME=root
DB_PASSWORD=007622
```

> **Note on Different Passwords:** If MySQL on the new computer uses a blank password (default XAMPP `DB_PASSWORD=`) or a custom password, simply change `DB_PASSWORD` in your `.env` and run `php artisan bhwms:setup --fresh`.

---

## 🛠️ Software Architecture & OOP Concepts Implemented

1. **Repository Pattern & Dependency Injection (SOLID: DIP & SRP):**
   - [`HouseholdRepositoryInterface`](app/Contracts/HouseholdRepositoryInterface.php) implemented by [`HouseholdRepository`](app/Repositories/HouseholdRepository.php).
   - [`ResidentRepositoryInterface`](app/Contracts/ResidentRepositoryInterface.php) implemented by [`ResidentRepository`](app/Repositories/ResidentRepository.php).
   - Injected into [`HouseholdController`](app/Http/Controllers/HouseholdController.php) and [`ResidentController`](app/Http/Controllers/ResidentController.php) via constructor injection.

2. **Interface Segregation & Mathematical Domain Modeling:**
   - [`GeoCalculatorInterface`](app/Contracts/GeoCalculatorInterface.php) implemented by [`GeoLocationService`](app/Services/GeoLocationService.php) utilizing the Haversine spherical distance formula for GPS validation.

3. **Domain Value Objects (Encapsulation & Immutability):**
   - [`GeoCoordinates`](app/ValueObjects/GeoCoordinates.php): Encapsulates latitude, longitude, and accuracy radius.
   - [`HealthVitals`](app/ValueObjects/HealthVitals.php): Encapsulates blood pressure, weight, temperature, and blood glucose metrics.
   - [`IsoEvaluationResult`](app/ValueObjects/IsoEvaluationResult.php): Encapsulates ISO/IEC 25010 8-characteristic mean calculation and verbal interpretation.

4. **Service Provider Registration (IoC Container):**
   - All interfaces are bound in [`AppServiceProvider`](app/Providers/AppServiceProvider.php).

---

## 🧪 Running Automated Tests

To verify 100% test integrity on any computer:

```bash
php artisan test
```

All unit and feature tests will execute against an in-memory or database test runner.
