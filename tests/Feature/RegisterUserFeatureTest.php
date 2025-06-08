<?php

namespace Tests\Feature;

use App\Http\Controllers\WhatsAppController;
use App\Models\UniversityUsers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegisterUserFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_successfully()
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('avatar.jpg');

        // Mock WhatsApp check to always return 'valid'
        $this->mock(WhatsappController::class, function ($mock) {
            $mock->shouldReceive('check')->andReturn(response()->json(['status' => 'valid']));
        });

        $response = $this->post('/users/store', [
            'full_name' => 'Test User',
            'user_name' => 'testuser123',
            'phone' => '01234567890',
            'whatsup_number' => '+201118295474',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'confirm_password' => 'password123',
            'address' => "fake address",
            'student_img' => $image,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Student registered successfully!',
        ]);

        $this->assertDatabaseHas('students', [
            'user_name' => 'testuser123',
            'email' => 'testuser@example.com',
        ]);
    }
}
