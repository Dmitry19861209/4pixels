<?php

use App\Department;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $users = User::all();

        $department = Department::create([
            'name' => 'First department',
            'description' => 'First department description.',
            'logo' => '4pixels-logo.jpg',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $users[0]->departments()->save($department);

        foreach ($users as $user) {
            $department = factory(Department::class, 1)->create();
            $user->departments()->save($department[0]);
        }
    }
}
