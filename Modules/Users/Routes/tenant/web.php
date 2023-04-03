<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::prefix('users')->group(function() {
    Route::get('/test', function (){
        echo "hello world from tenants: " . request()->url();
    });
});
