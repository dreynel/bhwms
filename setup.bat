@echo off
title BHWMS - Barangay Health Worker Management System Setup
color 0b
echo ================================================================
echo    BARANGAY HEALTH WORKER MANAGEMENT SYSTEM (BHWMS)
echo    Automated Setup and Migration Script
echo    Municipality of New Lucena, Iloilo Province
echo ================================================================
echo.

:: Check for .env file
if not exist ".env" (
    echo [.env] not found. Copying .env.example to .env ...
    copy .env.example .env
    echo [.env] successfully created with default MySQL configuration.
) else (
    echo [.env] configuration file detected.
)
echo.

:: Check for PHP
where php >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERROR] PHP was not found in your system PATH!
    echo Please ensure PHP (e.g., in XAMPP C:\xampp\php) is added to your Environment PATH.
    pause
    exit /b 1
)

:: Run BHWMS Setup Artisan command
echo Running Database Initialization and Migrations...
php artisan bhwms:setup --fresh

echo.
echo ================================================================
echo Setup process finished. You can now start the server with:
echo run.bat
echo ================================================================
echo.
pause
