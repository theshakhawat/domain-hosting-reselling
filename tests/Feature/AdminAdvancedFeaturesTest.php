<?php

namespace Tests\Feature;

use App\Models\HostingPlan;
use App\Models\PlanCategory;
use App\Models\SiteSetting;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAdvancedFeaturesTest extends TestCase
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

    public function test_system_refresh_clears_cache_and_links_storage(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/system/refresh');

        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }

    public function test_admin_can_update_header_footer_and_section_toggles(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/settings', [
            'has_section_toggles' => '1',
            'site_name' => 'SUPERHOST BD',
            'header_announcement_text' => 'Updated Special Offer',
            'header_announcement_badge' => 'FLASH',
            'header_cta_text' => 'Join Now',
            'footer_copyright' => '© 2026 SuperHost BD Ltd.',
            'footer_address' => 'Banani, Dhaka',
            'footer_facebook' => 'https://facebook.com/superhost',
            'section_hero_enabled' => '1',
            'section_plans_enabled' => '1',
            // section_domain_enabled is omitted to simulate unchecking
        ]);

        $response->assertRedirect('/admin/settings');
        $this->assertEquals('SUPERHOST BD', SiteSetting::get('site_name'));
        $this->assertEquals('Updated Special Offer', SiteSetting::get('header_announcement_text'));
        $this->assertEquals('© 2026 SuperHost BD Ltd.', SiteSetting::get('footer_copyright'));
        $this->assertEquals('1', SiteSetting::get('section_hero_enabled'));
        $this->assertEquals('0', SiteSetting::get('section_domain_enabled'));
    }

    public function test_disabled_section_is_hidden_from_homepage(): void
    {
        SiteSetting::set('section_plans_enabled', '0');
        SiteSetting::set('section_bundle_enabled', '0');
        SiteSetting::set('section_domain_enabled', '0');
        SiteSetting::set('section_hero_enabled', '1');

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('id="hosting-plans"', false);
        $response->assertDontSee('id="bundle"', false);
        $response->assertDontSee('id="domain-search"', false);
        // Assert that corresponding navbar and drawer links are also omitted
        $response->assertDontSee('Launch Bundle', false);
        $response->assertDontSee('Shared Hosting', false);
        $response->assertDontSee('Domain Search', false);
        $response->assertSee('id="hero"', false);
    }

    public function test_visitor_tracking_middleware_records_visit(): void
    {
        $this->get('/', [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.0.0 Safari/537.36',
        ]);

        $this->assertDatabaseHas('visitors', [
            'visited_route' => '/',
            'device_type' => 'Desktop',
            'operating_system' => 'Windows 10/11',
            'browser' => 'Google Chrome',
        ]);
    }

    public function test_beacon_endpoint_updates_screen_resolution(): void
    {
        // First, record visitor via GET
        $this->get('/');

        // Send beacon POST with screen resolution
        $response = $this->postJson('/api/track-visitor', [
            'screen_resolution' => '1920x1080',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'ok']);

        $this->assertDatabaseHas('visitors', [
            'screen_resolution' => '1920x1080',
        ]);
    }

    public function test_admin_can_view_visitors_analytics_page(): void
    {
        Visitor::create([
            'ip_address' => '103.100.20.5',
            'country' => 'Bangladesh',
            'country_code' => 'BD',
            'city' => 'Dhaka',
            'isp' => 'AmberIT Broadband',
            'device_type' => 'Mobile',
            'operating_system' => 'Android',
            'browser' => 'Google Chrome',
            'screen_resolution' => '390x844',
            'visited_route' => '/',
            'method' => 'GET',
            'hits' => 3,
            'last_activity_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/visitors');

        $response->assertStatus(200);
        $response->assertSee('Visitor Traffic', false);
        $response->assertSee('103.100.20.5');
        $response->assertSee('AmberIT Broadband');
        $response->assertSee('390x844');
    }

    public function test_admin_can_create_custom_plan_category(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/categories', [
            'name' => 'Reseller Turbo Hosting',
            'slug' => 'reseller-turbo',
            'badge' => 'White Label',
            'sort_order' => 5,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('plan_categories', [
            'name' => 'Reseller Turbo Hosting',
            'slug' => 'reseller-turbo',
            'badge' => 'White Label',
        ]);
    }

    public function test_custom_category_and_its_plans_render_on_homepage(): void
    {
        // 1. Admin creates a plan with a new custom category inline
        $response = $this->actingAs($this->admin)->post('/admin/plans', [
            'name' => 'Alpha Reseller Pro',
            'category' => 'custom',
            'new_category_name' => 'Managed WordPress',
            'monthly_price' => 1200,
            'yearly_price' => 12000,
            'badge' => 'WP Rocket Included',
            'storage' => '100 GB NVMe',
            'bandwidth' => 'Unlimited',
            'features_raw' => "10 WP Installs\nLiteSpeed Cache",
            'is_popular' => '1',
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/plans');

        // Verify category was auto-created
        $this->assertDatabaseHas('plan_categories', [
            'slug' => 'managed-wordpress',
        ]);

        // Verify plan was created
        $this->assertDatabaseHas('hosting_plans', [
            'name' => 'Alpha Reseller Pro',
            'category' => 'managed-wordpress',
            'monthly_price' => 1200,
        ]);

        // 2. Public visits homepage
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);

        // Verify category tab button exists on homepage
        $homeResponse->assertSee('Managed WordPress', false);
        $homeResponse->assertSee('data-category="managed-wordpress"', false);

        // Verify custom plan card exists on homepage
        $homeResponse->assertSee('Alpha Reseller Pro', false);
        $homeResponse->assertSee('1,200', false);
        $homeResponse->assertSee('WP Rocket Included', false);
    }

    public function test_admin_can_update_plan_category_and_cascades_to_plans(): void
    {
        $category = PlanCategory::create([
            'name' => 'Old Category',
            'slug' => 'old-category',
            'badge' => 'Old Badge',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $plan = HostingPlan::create([
            'name' => 'Plan Under Category',
            'category' => 'old-category',
            'monthly_price' => 500,
            'yearly_price' => 5000,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/categories/{$category->id}", [
            'name' => 'Updated Category',
            'slug' => 'new-category-slug',
            'badge' => 'Super Fast',
            'sort_order' => 2,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('plan_categories', [
            'id' => $category->id,
            'name' => 'Updated Category',
            'slug' => 'new-category-slug',
            'badge' => 'Super Fast',
            'sort_order' => 2,
        ]);

        $this->assertDatabaseHas('hosting_plans', [
            'id' => $plan->id,
            'category' => 'new-category-slug',
        ]);
    }

    public function test_admin_can_delete_plan_category_and_reassigns_plans(): void
    {
        $defaultCat = PlanCategory::create([
            'name' => 'Shared Hosting',
            'slug' => 'shared',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $toDelete = PlanCategory::create([
            'name' => 'Temporary Category',
            'slug' => 'temp-cat',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $plan = HostingPlan::create([
            'name' => 'Temp Plan',
            'category' => 'temp-cat',
            'monthly_price' => 300,
            'yearly_price' => 3000,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/categories/{$toDelete->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('plan_categories', [
            'id' => $toDelete->id,
        ]);

        $this->assertDatabaseHas('hosting_plans', [
            'id' => $plan->id,
            'category' => 'shared',
        ]);
    }
}
