<?php

namespace Tests\Feature;

use App\Models\UniversityUsers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EditUserFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_profile()
    {
        Storage::fake('public');

        $user = UniversityUsers::factory()->create([
            'password' => bcrypt('password123'),
            'user_role' => 'student',
        ]);


        $newImage = UploadedFile::fake()->image('new.jpg');

        $response = $this->post('/users/update/' . $user->id, [
            'full_name' => 'Updated Name',
            'phone' => '01122334455',
            'whatsup_number' => '+201122334455',
            'email' => 'updated@example.com',
            'address' => 'New Address',
            'user_role' => 'student',
            'password' => 'password123',
            'student_img' => $newImage,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'User updated successfully!',
        ]);

        $this->assertDatabaseHas('students', [
            'id' => $user->id,
            'email' => 'updated@example.com',
            'full_name' => 'Updated Name',
        ]);
    }
}
