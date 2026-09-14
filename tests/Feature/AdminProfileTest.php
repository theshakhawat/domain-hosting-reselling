<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProfileTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Original Admin',
            'email' => 'admin@nexus.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'status' => true,
        ]);
    }

    public function test_guest_cannot_view_admin_profile(): void
    {
        $response = $this->get('/admin/profile');

        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_view_profile_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/profile');

        $response->assertStatus(200);
        $response->assertSee('Admin Profile & Security', false);
        $response->assertSee('Original Admin');
        $response->assertSee('admin@nexus.com');
    }

    public function test_admin_can_update_profile_info(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/profile', [
            'name' => 'Chief Technology Officer',
            'email' => 'cto@nexus.com',
            'phone_number' => '+880 1800-112233',
        ]);

        $response->assertRedirect('/admin/profile');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id,
            'name' => 'Chief Technology Officer',
            'email' => 'cto@nexus.com',
            'phone_number' => '+880 1800-112233',
        ]);
    }

    public function test_admin_can_change_password(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/profile', [
            'name' => 'Original Admin',
            'email' => 'admin@nexus.com',
            'current_password' => 'password',
            'new_password' => 'newSecretPass123!',
            'new_password_confirmation' => 'newSecretPass123!',
        ]);

        $response->assertRedirect('/admin/profile');
        $response->assertSessionHas('success');

        $this->admin->refresh();
        $this->assertTrue(Hash::check('newSecretPass123!', $this->admin->password));
    }

    public function test_admin_cannot_change_password_with_wrong_current_password(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/profile', [
            'name' => 'Original Admin',
            'email' => 'admin@nexus.com',
            'current_password' => 'wrong-old-password',
            'new_password' => 'newSecretPass123!',
            'new_password_confirmation' => 'newSecretPass123!',
        ]);

        $response->assertSessionHasErrors(['current_password']);
        $this->admin->refresh();
        $this->assertTrue(Hash::check('password', $this->admin->password));
    }

    public function test_admin_can_upload_profile_avatar(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.jpg', 200, 200);

        $response = $this->actingAs($this->admin)->put('/admin/profile', [
            'name' => 'Original Admin',
            'email' => 'admin@nexus.com',
            'profile_picture' => $file,
        ]);

        $response->assertRedirect('/admin/profile');
        $this->admin->refresh();

        $this->assertNotNull($this->admin->profile_picture);
        Storage::disk('public')->assertExists($this->admin->profile_picture);
    }
}
