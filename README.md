## About Project

This is a test project for a job opportunity, the test has the following goals:

- **CRUD implementation.**
- **EAV (Entity-Attribute-Value) model implementation.**
- **Filters in Laravel.**

The project building includes:

- **Use Laravel 12.**
- **Follow PSR standards and Laravel best practices.**
- **Public Postman API Collection for general test.**
- **API based CRUD.**

## Setup instructions

To run the project follow these steps:

- **Clone the project.**
- **Install packages by running:**
```bash
composer install
```
- **Create .env file with key**
```bash
cp .env.example .env
php artisan key:generate
```

- **For the database, add the configuration to .env file. then run**
```bash
php artisan migrate:fresh --seed
```

or download the database file and import it in your phpmyadmin from the [link](https://drive.google.com/file/d/1zXe96GyX9J7RdfJGwTE6zsXKxhZuoAfH/view?usp=sharing)


- **Run this for creating access token to enable using Laravel Passport auth:**
```bash
php artisan passport:client --personal
```

- **Get the generated token and client id and add them to your .env file.**

- **To test the project, you can create your own API requests or you can use this [postman collection](https://www.postman.com/solar-crater-156104/workspace/astudio
), or use the [invitation](https://app.getpostman.com/join-team?invite_code=c2733365647576c8037233b5d959049317361214f5ef3cc180b516479b547853&target_code=02cacfecb0056ebe7c13588e86e5eabc
) link to access the collection.**


## Usage
To use the project APIs and features you must:

- **In postman collection, add your localhost URL for this project into the environment variable called 'url'**
- **Register a new user using /auth/register API**
- **Login to the system using /auth/login API, if you're using postman collection, the login will automatically add the response token to the environment variables under 'token' name**
- **After login, you can use the rest of the APIs as long as the token is added to authenticate the request, and don't forget the request content type to accept json.**
- **Create a project, and with its name and status add whatever attributes you want under 'attributes' array of id and value. Make sure to add the attribute record first.**


## License

This code is licensed under the [MIT license](https://opensource.org/licenses/MIT).
