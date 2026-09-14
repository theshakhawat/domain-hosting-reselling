<?php

namespace Tests\Feature;

use App\Models\DomainPricing;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\HostingPlan;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminContentManagementTest extends TestCase
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

    public function test_admin_can_view_dashboard(): void
    {
        Visitor::create([
            'ip_address' => '103.100.20.5',
            'country' => 'Bangladesh',
            'country_code' => 'BD',
            'city' => 'Dhaka',
            'device_type' => 'Desktop',
            'operating_system' => 'Windows 11',
            'browser' => 'Chrome',
            'visited_route' => '/',
            'hits' => 5,
            'last_activity_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Admin Control');
        $response->assertSee('Traffic Trend (Last 7 Days)');
        $response->assertSee('Latest Visitors');
        $response->assertSee('103.100.20.5');
        $response->assertSee('dashboardTrafficChart');
    }

    public function test_admin_can_view_plans_index_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/plans');

        $response->assertStatus(200);
        $response->assertSee('Hosting Packages');
        $response->assertSee(route('admin.profile.edit'));
    }

    public function test_admin_can_create_hosting_plan(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/plans', [
            'name' => 'Custom Ultra NVMe',
            'category' => 'shared',
            'tagline' => 'High throughput dedicated cluster',
            'monthly_price' => 750,
            'yearly_price' => 7500,
            'storage' => '50 GB NVMe',
            'bandwidth' => '1 TB Bandwidth',
            'cpu' => '2 vCPU',
            'ram' => '4 GB RAM',
            'features_raw' => "Feature A\nFeature B",
            'is_popular' => '1',
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/plans');
        $this->assertDatabaseHas('hosting_plans', [
            'name' => 'Custom Ultra NVMe',
            'monthly_price' => 750,
        ]);
    }

    public function test_admin_can_update_hosting_plan(): void
    {
        $plan = HostingPlan::create([
            'name' => 'Old Plan',
            'category' => 'cloud',
            'monthly_price' => 500,
            'yearly_price' => 5000,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/plans/{$plan->id}", [
            'name' => 'Updated Plan',
            'category' => 'cloud',
            'monthly_price' => 600,
            'yearly_price' => 6000,
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/plans');
        $this->assertDatabaseHas('hosting_plans', [
            'id' => $plan->id,
            'name' => 'Updated Plan',
            'monthly_price' => 600,
        ]);
    }

    public function test_admin_can_manage_domain_tlds(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/domains', [
            'tld' => '.tech',
            'price' => 999,
            'renewal_price' => 1299,
            'badge' => 'New',
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/domains');
        $this->assertDatabaseHas('domain_pricings', [
            'tld' => '.tech',
            'price' => 999,
        ]);
    }

    public function test_admin_can_update_site_settings(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/settings', [
            'site_name' => 'NEXUSHOST PRO',
            'hero_pill' => 'Enterprise Ready',
            'hero_title' => 'Ultra Fast Cloud',
            'promo_code' => 'SAVE50',
            'promo_discount' => '50',
        ]);

        $response->assertRedirect('/admin/settings');
        $this->assertEquals('NEXUSHOST PRO', SiteSetting::get('site_name'));
        $this->assertEquals('SAVE50', SiteSetting::get('promo_code'));
    }

    public function test_public_homepage_renders_with_database_content(): void
    {
        HostingPlan::create([
            'name' => 'Starter NVMe',
            'category' => 'shared',
            'monthly_price' => 299,
            'yearly_price' => 2990,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        DomainPricing::create([
            'tld' => '.com',
            'price' => 1290,
            'renewal_price' => 1450,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Feature::create([
            'title' => 'LiteSpeed Enterprise',
            'icon' => 'fa-solid fa-bolt',
            'description' => 'Fast caching webserver',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Testimonial::create([
            'client_name' => 'Rahim Chowdhury',
            'role' => 'Founder',
            'rating' => 5,
            'review_text' => 'Outstanding speed and uptime.',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Faq::create([
            'question' => 'What is web hosting?',
            'answer' => 'Hosting server space for sites.',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        SiteSetting::set('hero_title', 'Build Faster. Host Smarter.');

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Starter NVMe');
        $response->assertSee('.com');
        $response->assertSee('LiteSpeed Enterprise');
        $response->assertSee('Outstanding speed and uptime.');
        $response->assertSee('What is web hosting?');
        $response->assertSee('Build Faster. Host Smarter.');
    }

    public function test_admin_can_update_why_choose_us_settings_and_renders_on_homepage(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/settings', [
            'why_choose_title' => 'Why Fortune 500 Companies Choose NEXUSHOST',
            'why_choose_subtitle' => 'Unrivaled infrastructure with millisecond latency worldwide.',
            'why_choose_badge_1' => '99.999% SLA Verified',
            'why_choose_badge_2' => 'Zero Downtime Architecture',
            'why_choose_1_title' => 'Ultra NVMe Gen4 Storage',
            'why_choose_1_desc' => '7,000 MB/s read/write speeds for instant queries.',
        ]);

        $response->assertRedirect('/admin/settings');
        $this->assertEquals('Why Fortune 500 Companies Choose NEXUSHOST', SiteSetting::get('why_choose_title'));
        $this->assertEquals('99.999% SLA Verified', SiteSetting::get('why_choose_badge_1'));

        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('Why Fortune 500 Companies Choose NEXUSHOST');
        $homeResponse->assertSee('Unrivaled infrastructure with millisecond latency worldwide.');
        $homeResponse->assertSee('99.999% SLA Verified');
        $homeResponse->assertSee('Ultra NVMe Gen4 Storage');
        $homeResponse->assertSee('7,000 MB/s read/write speeds for instant queries.');
    }
}
