<?php

namespace Tests\Feature;

use App\Models\UniversityUsers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class StudentValidationDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_name_is_required()
    {
        $response = $this->post('/users', [
            'full_name' => 'Test User',
            'phone' => '0123456789',
            'whatsup_number' => '0123456789',
            'address' => 'Cairo',
            'email' => 'test@example.com',
            'student_img' => UploadedFile::fake()->image('photo.jpg'),
        ]);

        $response->assertStatus(422);     // The request was well-formed (valid JSON, proper HTTP),
                                       //  but Unprocessable Entity as the data could not be processed — usually due to validation errors.
        $response->assertJsonValidationErrors(['user_name']);
    }

    public function test_email_must_be_valid()
    {
        $response = $this->post('/users', [
            'user_name' => 'testuser',
            'full_name' => 'Test User',
            'phone' => '0123456789',
            'whatsup_number' => '0123456789',
            'address' => 'Cairo',
            'email' => 'not-an-email',
            'student_img' => UploadedFile::fake()->image('photo.jpg'),
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_image_must_be_valid_type()
    {
        $response = $this->post('/users', [
            'user_name' => 'testuser',
            'full_name' => 'Test User',
            'phone' => '0123456789',
            'whatsup_number' => '0123456789',
            'address' => 'Cairo',
            'email' => 'test@example.com',
            'student_img' => UploadedFile::fake()->create('document.pdf', 100),
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['student_img']);
    }

    public function test_all_fields_are_required()
    {
        //if student want to submit with nodata
        $response = $this->post('/users', []);
        // Assert that validation fails on the all fields

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'user_name',
            'full_name',
            'phone',
            'whatsup_number',
            'email',
        ]);
    }
    public function test_it_returns_error_when_user_name_is_not_unique()
    {
        // Create a student with a specific user_name
        UniversityUsers::factory()->create([
            'user_name' => 'ahmed11'
        ]);

        // Try to create another student with the same user_name
        $response = $this->post('/users', [
            'user_name' => 'ahmed11',
            'full_name' => 'Ahmed Mohamed',
            'phone' => '0123456789',
            'whatsup_number' => '0123456789',
            'address' => 'Cairo, Egypt',
            'email' => 'Ahmed@example.com',
            'student_img' => UploadedFile::fake()->image('photo.jpg'),
        ]);

        // Assert that validation fails on the 'user_name' field
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['user_name']);

    }
}
