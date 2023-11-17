# Pizzerio

## About Pizzerio

Pizzerio is a site-service for ordering food delivery at home. The application has numerous features, some of which are described below:

- viewing the product and adding it to the cart
- viewing the cart
- order form
- viewing products by category
- authorisation
- roles
- administrator panel with the ability to create, update categories and products.
## Used technologies

Laravel, Vue.js(Composition API), Inertia.js, TypeScript, MySQL, NPM, Vite, Tailwind CSS, Sanctum, Intervention Image, PHPUnit, Laravel Breeze, Git, Github.

## Installation guide

1. Clone this repository
2. Run `cp .env.example .env` in the root directory of the project to create .env file
3. Specify the database password in the .env file (Also you can change other parameters if you need)
4. Run `npm install` to install npm dependencies
5. Run `composer install` to install composer dependencies
6. Run `php artisan key:generate` to generate application key
7. Run `chmod -R 777 storage bootstrap/cache` to give permissions to storage and bootstrap/cache directories (If you use linux)
8. Run `php artisan migrate` to migrate database
9. Run `php artisan db:seed` to seed database (If you need mock data)
10. Run `php artisan storage:link` to create symbolic link to storage

#### Optional steps:
1. Run `php artisan serve` to start local server
2. Run `npm run dev` to start development server
