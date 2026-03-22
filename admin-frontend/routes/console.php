<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('pca:admin-frontend-status', function () {
    $this->info('PCA Admin Frontend Status:');
    $this->line('Service: Admin Panel');
    $this->line('Version: 1.0.0');
    $this->line('Environment: ' . config('app.env'));
    $this->line('Database: ' . config('database.default'));
    $this->line('Cache: ' . config('cache.default'));
})->purpose('Display PCA admin frontend service status');