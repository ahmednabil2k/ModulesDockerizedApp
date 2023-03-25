<?php

function centralMigrations() :array
{
    // For central database migrations
    $modules = activeModules();
    $paths = [];

    foreach ($modules as $module) {
        $paths[] = base_path("Modules/$module/Database/Migrations");
    }
    return $paths;
}
function tenantsMigrations() :array
{
    $modules = activeModules();
    if (empty($modules))
        return [];

    $migrations = [];
    foreach ($modules as $name) {
        $migrations[] = base_path("Modules/$name/Database/Migrations/Tenant");
    }

    return $migrations;
}

function activeModules(): array
{
    return  array_keys(
        array_filter(
            json_decode(
                file_get_contents(base_path('modules_statuses.json')),
                true
            ),
            function ($item){
                return $item;
            }
        )
    );
}

function modules(): array
{
    return  array_keys(
        array_filter(
            json_decode(
                file_get_contents(base_path('modules_statuses.json')),
                true
            )
        )
    );
}
