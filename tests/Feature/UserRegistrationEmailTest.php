<?php

namespace Tests\Feature;

use App\Http\Controllers\WhatsAppController;
use App\Mail\NewUserRegistered;
use App\Models\UniversityUsers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;


class UserRegistrationEmailTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        //  disable middleware for these tests to diable CSRF
        $this->withoutMiddleware();
    }
    use RefreshDatabase;

    public function test_emails_are_sent_to_admins_when_user_registers(): void
    {
        Mail::fake();

        UniversityUsers::factory()->count(1)->create([
            'user_role' => 'admin',
            'email' => 'admin@example.com',
        ]);

        // Mock WhatsApp verification
        $this->mock(WhatsAppController::class, function ($mock) {
            $mock->shouldReceive('check')
                ->andReturn(response()->json(['status' => 'valid']));
        });

        $response = $this->postJson('/users/store', [
            'full_name' => 'Test User',
            'user_name' => 'testuser',
            'phone' => '0123456789',
            'whatsup_number' => '+20123456789',
            'address' => 'Cairo',
            'email' => 'test@example.com',
            'password' => 'password123',
            'confirm_password' => 'password123',
            'student_img' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Student registered successfully!'
            ]);

        Mail::assertSent(NewUserRegistered::class, 1);
    }

    public function test_no_email_sent_if_validation_fails(): void
    {
        Mail::fake();

        $response = $this->postJson('/users/store', [
            // missing required fields
        ]);

        $response->assertStatus(422);
        Mail::assertNothingSent();
    }
}
