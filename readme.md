# Build A Modern Web Application With Laravel and Vue
This is a Trello clone built using Laravel and Vue. You can read about how it was created [in the series](https://blog.pusher.com/author/neo).

## Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites
What things you need to install the software. See the part one of the series on how to get your environment set up.

* Git.
* PHP.
* Composer.
* NodeJS and NPM.
* Laravel CLI.
* Laravel Valet (optional).
* VueJS.
* A webserver like Nginx or Apache.

### Install
Clone the git repository on your computer
```
$ git clone https://github.com/neoighodaro-articles/trello-clone-vue-laravel
```

You can also download the entire repository as a zip file and unpack in on your computer if you do not have git

After cloning the application, you need to install it's dependencies. 
```
$ cd trello-clone-vue-laravel
$ composer install
$ npm install
```

### Setup
When you are done with installation, copy the `.env.example` file to `.env`
```
$ cp .env.example .env
```

Generate the application key
```
$ php artisan key:generate
```

Add your database credentials to the necessary `env` fields

Migrate the application
```
$ php artisan migrate
```

Install Laravel Passport
```
$ php artisan passport:install
```

### Run the application
```
$ php artisan serve
```

## Built With
* [Laravel](https://laravel.com) - The PHP framework for building the API endpoints needed for the application
* [Laravel Passport](https://github.com/laravel/passport) - Authentication for securing the Laravel API endpoints
* [VueJS](https://vuejs.org/) - Used to make the entire frontend of the application

## Acknowledgments
* [Laravel](https://laravel.com) - The excellent documentation explaining how to get started with Laravel and Laravel Passport made it easy to provide a step by step guide for beginners to follow the application.