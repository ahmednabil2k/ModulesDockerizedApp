<?php

namespace Modules\Roles\Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RolesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
    }
}
