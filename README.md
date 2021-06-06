<h1 align="center">AUTO EMERGENCY ASSISTANT SYSTEM - AEAS</h1>

## About AEAS

AEAS is a web application which aim is to help users navigate their way out of any emergency they encounter. It is built upon the [Laravel Framework](https://laravel.com/) which uses the MVC architecture. The following are some of the features of this application:

-   Registration and login for both normal users and mechanics.
-   Uses basic [Google Maps Javascript API](https://developers.google.com/maps)
    -   [Distance Matrix API](https://developers.google.com/maps/documentation/javascript/distancematrix)
    -   [Places API](https://developers.google.com/maps/documentation/javascript/places)
    -   [Directions API](https://developers.google.com/maps/documentation/javascript/directions)
    -   [Geolocation API](https://developers.google.com/maps/documentation/geolocation)
    -   [Geocoding API](https://developers.google.com/maps/documentation/javascript/geocoding)

*   Multi-Auth -- Reference - [Dev Marketer on YouTube](https://www.youtube.com/playlist?list=PLwAKR305CRO9S6KVHMJYqZpjPzGPWuQ7Q)
*   E-Commerce section for ordering automobile spare parts.

# Installing Dependencies

Prior to this time, make sure to have [composer](https://getcomposer.org/) up and running in your machine. Now run `composer install` to install the dependencies in the the composer.json file also run `npm install` command to install the dependencies in the package.json file. Note that you must have [Node JS](https://nodejs.org/) runtime env running in your machine.

# Integrating Google Maps

Please note taht before using Google Maps, you must first create a google account, which will be used to access the [Google Cloud Platform](https://developers.google.com/maps).

After creating your account, you proceed to getting your [API KEY](https://developers.google.com/maps/documentation/javascript/get-api-key) which will be used in the project. Follow the instructions on the page carefully to create one.

After getting your API KEY, head over to the [custom.js](public\js\custom.js), search for the word `key` and set the value to your API KEY. Also head over to the [layouts directory](resources\views\layouts) and replace "YOUR_API_KEY" in the [app.blade.php](resources\views\layouts\app.blade.php) file and also the [app.blade.php](resources\views\layouts\auth\app.blade.php) file inside the auth directory

# Database

In the phpMyAdmin of your web server, create a new database and call it `autoEmergency`. Do not create a tables as you'll need to run migrations to create them for you.

In your terminal, run the `php artisan migrate` command to run the migrations in the [migrartions directory](database\migrations).

Refer to the web.php file in the routes directory for the routes.

### Developer - [ovichincodes](https://www.linkedin.com/in/vitalis-onyemechalu-407242194/)
