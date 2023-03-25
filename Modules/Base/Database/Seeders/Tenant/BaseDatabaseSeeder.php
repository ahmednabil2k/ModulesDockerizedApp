<?php

namespace Modules\Base\Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Modules\Auth\Database\Seeders\Tenant\AuthDatabaseSeeder;
use Modules\Auth\Database\Seeders\Tenant\PassportDatabaseSeeder;
use Modules\Roles\Database\Seeders\Tenant\RolesDatabaseSeeder;
use Modules\Users\Database\Seeders\Tenant\UsersDatabaseSeeder;

class BaseDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(PassportDatabaseSeeder::class);
        $this->call(AuthDatabaseSeeder::class);
        $this->call(RolesDatabaseSeeder::class);
        $this->call(UsersDatabaseSeeder::class);
    }
}
