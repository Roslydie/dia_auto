<?php

namespace Tests\Feature;

use App\Mail\ServiceRequestReceived;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ServiceRequestTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['mail.admin_address' => 'contact@revoryxandpartners.com']);
        Storage::fake('local');
    }

    public function test_a_service_request_is_saved_and_emailed_with_its_photos(): void
    {
        Mail::fake();

        $response = $this->postJson('/service-requests', [
            'service' => 'junk',
            'year' => '2012',
            'make' => 'Honda',
            'model' => 'Civic',
            'need' => 'The car does not start.',
            'name' => 'Alex Customer',
            'phone' => '(215) 555-0123',
            'email' => 'alex@example.com',
            'runs' => 'no',
            'zip' => '19153',
            'photos' => [new UploadedFile(
                resource_path('images/home-hero.webp'),
                'car.webp',
                'image/webp',
                UPLOAD_ERR_OK,
                true,
            )],
        ]);

        $response->assertCreated()
            ->assertJsonPath('message', 'Your request has been sent. We will get back to you soon.');

        $contact = Contact::firstOrFail();
        $this->assertSame('alex@example.com', $contact->email);
        $this->assertCount(1, $contact->photos);
        Storage::disk('local')->assertExists($contact->photos[0]);

        Mail::assertSent(ServiceRequestReceived::class, function (ServiceRequestReceived $mail) use ($contact) {
            return $mail->hasTo('contact@revoryxandpartners.com')
                && $mail->contact->is($contact)
                && count($mail->contact->photos) === 1;
        });
    }

    public function test_a_service_request_rejects_non_us_phone_numbers(): void
    {
        Mail::fake();

        $response = $this->postJson('/service-requests', [
            'service' => 'other',
            'name' => 'Alex Customer',
            'need' => 'I have a question.',
            'phone' => '12345',
            'email' => 'alex@example.com',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['phone']);

        $this->assertDatabaseCount('contacts', 0);
        Mail::assertNothingSent();
    }

    public function test_the_admin_email_embeds_uploaded_photos_inline(): void
    {
        $photoPath = (new UploadedFile(
            resource_path('images/home-hero.webp'),
            'car.webp',
            'image/webp',
            UPLOAD_ERR_OK,
            true,
        ))->store('service-requests', 'local');

        $contact = Contact::create([
            'service' => 'parts',
            'need' => 'Looking for a replacement part.',
            'phone' => '(267) 555-0123',
            'email' => 'alex@example.com',
            'photos' => [$photoPath],
        ]);

        $mailer = Mail::mailer('array');
        $mailer->to('contact@revoryxandpartners.com')->send(new ServiceRequestReceived($contact));

        $rawMessage = $mailer->getSymfonyTransport()
            ->messages()
            ->first()
            ->getOriginalMessage()
            ->toString();

        $this->assertStringContainsString('cid:', $rawMessage);
        $this->assertStringContainsString('Content-ID:', $rawMessage);
        $this->assertStringContainsString('Content-Disposition: attachment', $rawMessage);
        $this->assertStringContainsString('service-request-photo-1.webp', $rawMessage);
    }
}
