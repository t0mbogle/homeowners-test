# Homeowners

## Getting started

Start server with `php -S 127.0.0.1:8000`

Then in your chosen browser navigate to http://localhost:8000/server/HomeownersController.php to see the output.

## Tests

If composer is not installed, you will need to install composer before being able to run the test suite.

Cd into `/server` folder

Run `composer install`

Run `vendor/bin/phpunit` to run the test suite

## Given more time

- Create a real api endpoint that returns the JSON data from HomeownersController
- Create a simple UI to display the users with an option to upload a different csv file
- Create a User class
