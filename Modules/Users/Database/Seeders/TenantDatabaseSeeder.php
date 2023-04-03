<?php

namespace Modules\Users\Database\Seeders;

use App\Models\Tenant;
use Faker\Factory;
use Faker\Guesser\Name;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $faker = new Factory();
        $name = Str::snake($faker::create()->name('male'));

        $tenant = Tenant::create([
            'id' => $name
        ]);

        $tenant->domains()->create(['domain' => $name]);

    }
}
