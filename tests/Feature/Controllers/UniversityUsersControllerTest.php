<?php

namespace Tests\Feature\Controllers;

use App\Models\UniversityUsers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UniversityUsersControllerTest extends TestCase
{
    use RefreshDatabase;

    // Helper to create valid user data
    protected function validUserData($overrides = []): array
    {
        return array_merge([
            'full_name' => 'John Doe',
            'user_name' => 'johndoe',
            'phone' => '1234567890',
            'whatsup_number' => '1234567890',
            'address' => '123 Main St',
            'email' => 'john@example.com',
            'password' => 'password123',
            'confirm_password' => 'password123',
            'student_img' => UploadedFile::fake()->image('avatar.jpg'),
        ], $overrides);
    }

    // Helper to create valid update data
    protected function validUpdateData($overrides = []): array
    {
        return array_merge([
            'full_name' => 'Updated Name',
            'user_name' => 'updateduser',
            'phone' => '0987654321',
            'whatsup_number' => '0987654321',
            'address' => '456 Updated St',
            'email' => 'updated@example.com',
            'current_password' => 'password123',
            'password' => 'newpassword123',
            'confirm_password' => 'newpassword123',
            'student_img' => UploadedFile::fake()->image('new_avatar.jpg'),
        ], $overrides);
    }


    public function test_can_display_all_users()
    {
        UniversityUsers::factory()->count(3)->create();

        $response = $this->get(route('users.index'));

        $response->assertStatus(200);
        $response->assertViewIs('users.index');

        $response->assertViewHas('users');
        $users = $response->original->getData()['users'];
        $this->assertCount(3, $users);
    }


    public function test_can_show_register_form()
    {
        $response = $this->get(route('users.create'));

        $response->assertStatus(200);
        $response->assertViewIs('users.register');
    }


    public function test_can_store_new_user_with_valid_data()
    {
        $data = $this->validUserData();

        $response = $this->post(route('users.store'), $data);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('students', [
            'user_name' => $data['user_name'],
            'email' => $data['email'],
        ]);
    }


    public function test_fails_to_store_user_with_duplicate_email()
    {
        $existingUser = UniversityUsers::factory()->create();

        $data = $this->validUserData(['email' => $existingUser->email]);

        $response = $this->post(route('users.store'), $data);

        $response->assertSessionHasErrors('email');
    }


    public function test_can_show_single_user_profile()
    {
        $user = UniversityUsers::factory()->create();

        $response = $this->get(route('users.show', $user->id));

        $response->assertStatus(200);
        $response->assertViewIs('users.show');
        $response->assertViewHas('user', $user);
    }


    public function test_returns_404_if_user_not_found_on_show()
    {
        $this->get(route('users.show', 999))->assertNotFound();
    }


    public function test_can_show_edit_form_for_user()
    {
        $user = UniversityUsers::factory()->create();

        $response = $this->get(route('users.edit', $user->id));

        $response->assertStatus(200);
        $response->assertViewIs('users.edit');
        $response->assertViewHas('user', $user);
    }


    public function test_returns_404_if_user_not_found_on_edit()
    {
        $this->get(route('users.edit', 999))->assertNotFound();
    }


    public function test_can_update_user_with_valid_data()
    {
        $user = UniversityUsers::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $data = $this->validUpdateData();

        $response = $this->put(route('users.update', $user->id), $data);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('students', [
            'user_name' => $data['user_name'],
            'email' => $data['email'],
        ]);
        $this->assertTrue(Hash::check('newpassword123', UniversityUsers::find($user->id)->password));
    }


    public function test_fails_to_update_user_with_invalid_current_password()
    {
        $user = UniversityUsers::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $data = $this->validUpdateData([
            'current_password' => 'wrongpassword',
        ]);

        $response = $this->put(route('users.update', $user->id), $data);

        $response->assertSessionHasErrors('current_password');
    }


    /** @test */
    public function it_can_delete_a_user()
    {
        $user = UniversityUsers::factory()->create();

        // Confirm user exists before deleting
        $this->assertDatabaseHas('students', ['id' => $user->id]);

        $response = $this->delete(route('users.destroy', $user->id));

        $response->assertRedirect(route('users.index'));

        // Manually refresh and check existence
        $this->assertNull(UniversityUsers::find($user->id));
    }


    public function test_cannot_delete_nonexistent_user()
    {
        $this->delete(route('users.destroy', 999))->assertNotFound();
    }
}
