<?php

use App\Department;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->deleteTables();
        $this->call(UsersTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
    }

    public function deleteTables() {
        Department::truncate();
        User::truncate();
    }
}
