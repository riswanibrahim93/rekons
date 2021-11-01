<?php

namespace Database\Seeders;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $c = new CreateNewUser();
        $c->create(
            [
                'name' => 'admin',
                'email' => 'bsi_admin@gmail.com',
                'role' =>1,
                'password' => '123456',
                'email_verified_at' => now()
            ]
        );
        $c->create(
            [
                'name' => 'admin',
                'role'=>2,
                'email' => 'eka_admin@gmail.com',
                'password' => '123456',
                'email_verified_at' => now()
            ]
        );
    }
}
