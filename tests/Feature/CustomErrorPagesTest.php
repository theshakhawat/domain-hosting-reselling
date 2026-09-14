<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomErrorPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_404_page_renders_with_custom_futuristic_design(): void
    {
        $response = $this->get('/non-existent-cluster-endpoint-'.uniqid());

        $response->assertStatus(404);
        $response->assertSee('404');
        $response->assertSee('Cluster Node Or Page Not Found');
        $response->assertSee('system_diagnostic.log');
        $response->assertSee('Return to Homepage');
        $response->assertSee('Contact Technical Support');
    }

    public function test_403_view_renders_correctly(): void
    {
        $view = $this->view('errors.403');

        $view->assertSee('403');
        $view->assertSee('FORBIDDEN');
        $view->assertSee('Access Denied / Clearance Required');
        $view->assertSee('firewall_guard.log');
        $view->assertSee('SECURITY FIREWALL RESTRICTION');
    }

    public function test_500_view_renders_correctly(): void
    {
        $view = $this->view('errors.500');

        $view->assertSee('500');
        $view->assertSee('SERVER_ERROR');
        $view->assertSee('Server Encountered An Anomaly');
        $view->assertSee('kernel_crash_report.log');
        $view->assertSee('Reload Page');
    }

    public function test_419_view_renders_correctly(): void
    {
        $view = $this->view('errors.419');

        $view->assertSee('419');
        $view->assertSee('EXPIRED');
        $view->assertSee('Page Session Has Expired');
    }

    public function test_503_view_renders_correctly(): void
    {
        $view = $this->view('errors.503');

        $view->assertSee('503');
        $view->assertSee('MAINTENANCE');
        $view->assertSee('System Upgrades In Progress');
    }
}
