<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('Sign in to Admin Portal');
    }

    public function test_unauthenticated_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_authenticate_using_the_login_screen(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@nexus.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
            'status' => true,
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@nexus.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/admin/dashboard');
    }

    public function test_admin_cannot_authenticate_with_invalid_password(): void
    {
        User::factory()->create([
            'email' => 'admin@nexus.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
            'status' => true,
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@nexus.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_inactive_admin_cannot_authenticate(): void
    {
        User::factory()->create([
            'email' => 'inactive@nexus.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
            'status' => false,
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'inactive@nexus.com',
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_admin_can_logout(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'status' => true,
        ]);

        $response = $this->actingAs($admin)->post('/admin/logout');

        $this->assertGuest();
        $response->assertRedirect('/admin/login');
    }
}
