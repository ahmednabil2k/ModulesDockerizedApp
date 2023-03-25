<?php

namespace Modules\Auth\Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\ClientRepository;

class PassportDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $client = new ClientRepository();

        $client->createPasswordGrantClient(
            null,
            'Reach-password-grant-client',
            'http://localhost:8000'
        );

        $client->createPersonalAccessClient(
            null,
            'Reach-personal-access-client',
            'http://localhost:8000'
        );
    }
}
