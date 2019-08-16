# MyPrecious

> My Precious is a personnal movies library project - this repo is the API developped with Laravel Framework

## Features
- create / edit / delete movies
- find movies from database filtered by name, categories, director, rating, seen tag, ...
- support login process with token - implemented with [Laravel Passport](https://laravel.com/docs/5.7/passport)

## Getting Started
Via Composer:

`composer install`

Generate Laravel private key:

`php artisan key:generate`

Create `.env` file base on `.env-sample`.

Create a database and run:

`php artisan migrate`

Generate passport keys running:

`php artisan passport:install`

Setup local development server with WAMP or MAMP for example

`php artisan serve` can't work here due to the multi thread requirement for Guzzle calls.

## Run the API
Use [Insomnia](https://insomnia.rest/) to try API calls.

Start to create first user for example.

:warning: For now, read the file `routes/api.php` to know existing routes. I'm working on Swagger API documentation, I'll let you know when it's ready.

## Requirements
Laravel 5.7 [Server Requirements](https://laravel.com/docs/5.7/installation)

## Todo list
- API documentation with Swagger
- Create seeds to demo purpose
- Reset database functionnality