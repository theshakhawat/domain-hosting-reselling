<?php

namespace Tests\Feature;

use App\Models\AdminNotification;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ContactAndNotificationTest extends TestCase
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

    public function test_public_user_can_view_contact_page(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('Open a Support Inquiry', false);
        $response->assertSee('Submit Ticket', false);
    }

    public function test_public_user_can_submit_contact_form_with_screenshot(): void
    {
        $tempFile = UploadedFile::fake()->image('error_screenshot.jpg', 600, 400);

        $response = $this->post('/contact', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone' => '+8801712345678',
            'subject' => 'SSL Certificate Issue',
            'issue_type' => 'Technical Support',
            'description' => 'My SSL is showing expired since this morning on my domain.',
            'screenshot' => $tempFile,
        ]);

        $response->assertRedirect('/contact');
        $response->assertSessionHas('ticket_submitted', true);
        $response->assertSessionHas('ticket_no');

        // Verify database entry
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone' => '+8801712345678',
            'subject' => 'SSL Certificate Issue',
            'issue_type' => 'Technical Support',
            'status' => 'new',
        ]);

        // Verify AdminNotification was created
        $this->assertDatabaseHas('admin_notifications', [
            'type' => 'contact_form',
            'is_read' => false,
        ]);

        // Clean up created file in public/uploads/screenshots if created
        $contact = ContactMessage::where('email', 'johndoe@example.com')->first();
        $this->assertNotNull($contact);
        $this->assertNotNull($contact->screenshot);
        if ($contact->screenshot && File::exists(public_path($contact->screenshot))) {
            File::delete(public_path($contact->screenshot));
        }
    }

    public function test_contact_form_validates_required_fields(): void
    {
        $response = $this->post('/contact', [
            'name' => '',
            'email' => 'invalid-email',
            'subject' => '',
            'description' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'subject', 'description']);
    }

    public function test_admin_can_view_contact_messages_list(): void
    {
        $ticket = ContactMessage::create([
            'ticket_no' => 'TKT-123456',
            'name' => 'Sara Connor',
            'email' => 'sara@example.com',
            'phone' => '01800000000',
            'subject' => 'Billing inquiry',
            'issue_type' => 'Billing & Invoicing',
            'description' => 'Need an updated tax invoice.',
            'status' => 'new',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/contacts');

        $response->assertStatus(200);
        $response->assertSee('TKT-123456');
        $response->assertSee('Sara Connor');
        $response->assertSee('Billing & Invoicing');
    }

    public function test_admin_can_view_contact_details_page(): void
    {
        $ticket = ContactMessage::create([
            'ticket_no' => 'TKT-777888',
            'name' => 'John Wick',
            'email' => 'john@continental.com',
            'phone' => '+1 555-0199',
            'subject' => 'Continental high availability hosting',
            'issue_type' => 'Technical Support',
            'description' => 'Need bulletproof server infrastructure.',
            'status' => 'new',
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/contacts/{$ticket->id}");

        $response->assertStatus(200);
        $response->assertSee('TKT-777888');
        $response->assertSee('John Wick');
        $response->assertSee('john@continental.com');
        $response->assertSee('Need bulletproof server infrastructure.');

        // Status auto-transitions to 'seen' when viewed
        $this->assertEquals('seen', $ticket->fresh()->status);
    }

    public function test_admin_can_update_contact_status(): void
    {
        $ticket = ContactMessage::create([
            'ticket_no' => 'TKT-987654',
            'name' => 'Michael Scott',
            'email' => 'michael@dunder.com',
            'subject' => 'Server downtime',
            'issue_type' => 'Technical Support',
            'description' => 'Server is returning 500 error.',
            'status' => 'new',
        ]);

        $response = $this->actingAs($this->admin)->patch("/admin/contacts/{$ticket->id}/status", [
            'status' => 'fixed',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contact_messages', [
            'id' => $ticket->id,
            'status' => 'fixed',
        ]);
    }

    public function test_admin_can_delete_contact_message(): void
    {
        $ticket = ContactMessage::create([
            'ticket_no' => 'TKT-444555',
            'name' => 'Dwight Schrute',
            'email' => 'dwight@dunder.com',
            'subject' => 'Beet server upgrade',
            'issue_type' => 'Other Inquiry',
            'description' => 'Need more RAM for farms.',
            'status' => 'seen',
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/contacts/{$ticket->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('contact_messages', [
            'id' => $ticket->id,
        ]);
    }

    public function test_admin_can_view_and_manage_notifications(): void
    {
        $notif = AdminNotification::create([
            'type' => 'contact_form',
            'title' => 'New Support Ticket #TKT-1001',
            'message' => 'Jim Halpert submitted a ticket: Prank complaint',
            'link' => '/admin/contacts',
            'is_read' => false,
        ]);

        // 1. View notifications page
        $response = $this->actingAs($this->admin)->get('/admin/notifications');
        $response->assertStatus(200);
        $response->assertSee('New Support Ticket #TKT-1001');

        // 2. Mark as read
        // 2. Mark as read via PATCH and GET
        $readResponse = $this->actingAs($this->admin)->patch("/admin/notifications/{$notif->id}/read");
        $readResponse->assertRedirect('/admin/contacts');

        $this->assertDatabaseHas('admin_notifications', [
            'id' => $notif->id,
            'is_read' => true,
        ]);

        // Test GET method as used in dropdown links
        $notifGet = AdminNotification::create([
            'type' => 'contact_form',
            'title' => 'GET Notif',
            'message' => 'Test GET link',
            'link' => '/admin/contacts',
            'is_read' => false,
        ]);

        $getResponse = $this->actingAs($this->admin)->get("/admin/notifications/{$notifGet->id}/read");
        $getResponse->assertRedirect('/admin/contacts');
        $this->assertEquals(true, $notifGet->fresh()->is_read);

        // 3. Mark all read
        $notif2 = AdminNotification::create([
            'type' => 'contact_form',
            'title' => 'New Ticket #2',
            'message' => 'Another message',
            'is_read' => false,
        ]);

        $this->actingAs($this->admin)->post('/admin/notifications/mark-all-read');
        $this->assertDatabaseHas('admin_notifications', [
            'id' => $notif2->id,
            'is_read' => true,
        ]);

        // 4. Delete notification
        $this->actingAs($this->admin)->delete("/admin/notifications/{$notif->id}");
        $this->assertDatabaseMissing('admin_notifications', [
            'id' => $notif->id,
        ]);

        // 5. Clear all notifications
        $this->actingAs($this->admin)->delete('/admin/notifications-clear-all');
        $this->assertDatabaseCount('admin_notifications', 0);
    }
}
