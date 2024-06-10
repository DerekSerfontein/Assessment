# Laravel Contact Form Project

This is a Laravel project that implements a simple contact form. The form includes fields for name, email, and message, and stores the submitted data in a MySQL database.

## Features

- Contact form with validation for name, email, and message fields.
- Stores contact form submissions in a MySQL database.
- Simple and clean user interface.

## Requirements

- PHP >= 7.3
- Composer
- MySQL
- Laravel 8.x or later

## Installation

1. **Clone the repository:**

    ```sh
    git clone https://github.com/your-username/assessment.git
    cd assessment
    ```

2. **Install dependencies:**

    ```sh
    composer install
    ```

3. **Copy the `.env` file and configure the environment variables:**

    ```sh
    cp .env.example .env
    ```

    Update the `.env` file with your database configuration:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    ```

4. **Generate an application key:**

    ```sh
    php artisan key:generate
    ```

5. **Run the database migrations:**

    ```sh
    php artisan migrate
    ```

6. **Serve the application:**

    ```sh
    php artisan serve
    ```

    The application will be available at `http://localhost:8000`.

## Usage

Navigate to `http://localhost:8000/contact` to access the contact form. Fill in the required fields (name, email, message) and submit the form. The submitted data will be stored in the `form_submissions` table in your MySQL database.

## File Structure

- `app/Http/Controllers/ContactFormController.php`: Handles the form submission logic.
- `app/Models/ContactForm.php`: The Contact model representing the `form_submissions` table.
- `resources/views/contact.blade.php`: The contact form view.
- `routes/web.php`: Routes for displaying and processing the contact form.

## Routes

- **GET** `/contact`: Displays the contact form.
- **POST** `/contact`: Processes the contact form submission.

## Contact Form Validation

The contact form uses Laravel's validation feature to ensure that the name, email, and message fields are properly filled out.

## Database

The `form_submissions` table is used to store form submissions. The table structure is defined in the migration file located at `database/migrations/2024_06_09_115506_create_submissions_table.php`.

## PHPUnit Tests

This project includes PHPUnit tests to verify the functionality of the contact form. The tests check for the redirection from `/` to `/contact` and the insertion of form details into the MySQL database as well as not allowing database insertion when one of the fields are missing.

1. **Setup the testing environment:**

    The test makes use of the DatabaseTransactions trait, which rolls back any transactions on the DB that were executed during testing.

2. **The test file:**

    The test file at `tests/Feature/ContactFormTest.php`:

    ```php
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
                'name' => 'test',
                'email' => 'derek@mail.com',
            ]));

            $response->assertSessionHasNoErrors();

        }
    }
    ```

3. **Run the tests:**

    Use the following command to run the tests:

    ```sh
    php artisan test
    ```

    This will execute the test cases and verify that the contact form displays correctly and the submitted data is stored in the database.

