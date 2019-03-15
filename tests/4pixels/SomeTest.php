<?php

namespace Tests\Feature;

use App\Department;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SomeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $response = $this->json('POST', '/login', [
            'email' => 'admin@test.loc',
            'password' => 'password',
        ]);

        $response->assertRedirect('home');
    }

    public function testDepartmentsUpdate()
    {
        $department = Department::first();

        $this->json('POST', '/login', [
            'email' => 'admin@test.loc',
            'password' => 'password',
        ]);

        $file = UploadedFile::fake()->image('logo-test.jpg');

        $response = $this->json('POST', '/departments/' . $department->id, [
            'name' => $department->name,
            'description' => $department->description,
            'logo' => $file,
        ]);

        $response->assertStatus(302);

        Storage::disk('local')->assertExists('public/logo/logo-test.jpg');

        Storage::disk('local')->assertMissing('missing.jpg');
    }
}
