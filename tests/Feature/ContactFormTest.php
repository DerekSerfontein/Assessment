<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

use App\Models\ContactForm;

class ContactFormTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test that / returns the /contact view.
     */
    public function test_home_route(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee("Contact Form");

    }

    /**
     * Test the submission of the Contact Form and database addition.
     */
    public function test_form_submission_database(): void
    {
        $submission = ContactForm::factory()->create();

        $this->assertDatabaseHas('form_submissions', [
            'email' => $submission->email,
        ]);

    }

    /**
     * Test the submission of the Contact Form missing name.
     */
    public function test_form_submission_missing_name(): void
    {
        $this->withoutMiddleware();

        $response = $this->post(route('contact.submit',[
            // 'name' => 'test',
            'email' => 'derek@mail.com',
            'message' => 'This is a message'
        ]));

        $response->assertSessionHasNoErrors();

    }

    /**
     * Test the submission of the Contact Form missing email.
     */
    public function test_form_submission_missing_email(): void
    {
        $this->withoutMiddleware();

        $response = $this->post(route('contact.submit',[
            'name' => 'test',
            // 'email' => 'derek@mail.com',
            'message' => 'This is a message'
        ]));

        $response->assertSessionHasNoErrors();

    }

    /**
     * Test the submission of the Contact Form missing message.
     */
    public function test_form_submission_missing_message(): void
    {
        $this->withoutMiddleware();

        $response = $this->post(route('contact.submit',[
            // 'message' => 'This is a message',
            'name' => 'test',
            'email' => 'derek@mail.com',
        ]));

        $response->assertSessionHasNoErrors();

    }
}
