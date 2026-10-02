@echo off
title BHWMS - Barangay Health Worker Management System
color 0a
echo ================================================================
echo    STARTING BHWMS LOCAL SERVER
echo    URL: http://127.0.0.1:8000
echo ================================================================
echo.
echo Launching default browser...
start http://127.0.0.1:8004
echo.
echo Starting Laravel Artisan development server...
echo (Press CTRL+C to stop the server)
echo.
php artisan serve --host=127.0.0.1 --port=8004
