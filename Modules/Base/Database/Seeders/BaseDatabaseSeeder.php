<?php

namespace Modules\Base\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Auth\Database\Seeders\AuthDatabaseSeeder;
use Modules\Roles\Database\Seeders\RolesDatabaseSeeder;
use Modules\Users\Database\Seeders\TenantDatabaseSeeder;
use Modules\Users\Database\Seeders\UsersDatabaseSeeder;

class BaseDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // For central Database
        Model::unguard();

        $this->call(TenantDatabaseSeeder::class);
        $this->call(AuthDatabaseSeeder::class);
        $this->call(RolesDatabaseSeeder::class);
        $this->call(UsersDatabaseSeeder::class);
    }
}
