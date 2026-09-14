<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitorCleanupTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@nexus.com',
            'is_admin' => true,
            'status' => true,
        ]);
    }

    public function test_admin_can_delete_individual_visitor_record(): void
    {
        $visitor = Visitor::create([
            'ip_address' => '192.168.1.100',
            'country' => 'Bangladesh',
            'country_code' => 'BD',
            'city' => 'Dhaka',
            'device_type' => 'Desktop',
            'operating_system' => 'Windows 10/11',
            'browser' => 'Chrome',
            'visited_route' => '/',
            'hits' => 5,
            'last_activity_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/visitors/{$visitor->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('visitors', [
            'id' => $visitor->id,
        ]);
    }

    public function test_admin_can_clear_all_visitor_records(): void
    {
        Visitor::create([
            'ip_address' => '192.168.1.1',
            'visited_route' => '/',
            'device_type' => 'Desktop',
            'operating_system' => 'Windows',
            'browser' => 'Chrome',
            'last_activity_at' => now(),
        ]);

        Visitor::create([
            'ip_address' => '192.168.1.2',
            'visited_route' => '/contact',
            'device_type' => 'Mobile',
            'operating_system' => 'iOS',
            'browser' => 'Safari',
            'last_activity_at' => now(),
        ]);

        $this->assertDatabaseCount('visitors', 2);

        $response = $this->actingAs($this->admin)->delete('/admin/visitors-clear-all');

        $response->assertRedirect();
        $this->assertDatabaseCount('visitors', 0);
    }
}
