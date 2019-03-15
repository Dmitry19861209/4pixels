<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Create users.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.loc',
            'password' => bcrypt('password'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        factory(User::class, 15)->create();
    }
}
