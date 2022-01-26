# Dotenv
Library that adds the ability to access variables from '.env', $_ENV, and $_SERVER using the getenv() function

# Installation
```shell
composer require fkrzski/dotenv
```

# Usage

### Basics
Add your application configuration variables to `.env` file in your project. Next add `.env` to `.gitignore` file! You should create a `.env.example` file to have a skeleton with variable names for your contributors
```shell
APP_NAME="My App Name"  # My app name
API_KEY=YourApiKey      # My api key
```

### Include ` Dotenv ` class
```php
use Dotenv\Dotenv;
```

### Load ` .env ` variables
```php
$dotenv = new Dotenv();
$dotenv->start();
```

### Custom path or file name
```php
$dotenv = new Dotenv('myenvfile.env', '/path/to/file');

// Now you are using myenvfile.env from /path/to/file folder
```

### Retrieving variables values
```php
echo getenv('APP_NAME');
echo $_SERVER['APP_NAME'];
echo $_ENV['APP_NAME'];

// output: My App Name
```

### Overwrtitting a variable
`.env` file
```shell
APP_NAME="App Name"
API_KEY=ApiKey

APP_NAME="Second App Name"
API_KEY=SecondApiKey
```

PHP file
```php
$dotenv->start(['APP_NAME']);

echo getenv('APP_NAME');
echo getenv('API_KEY');

// Output:
// Second App Name
// ApiKey
```

Second possibility
`.env` file
```shell
APP_NAME="App Name"
API_KEY=ApiKey

APP_NAME="Second App Name"
API_KEY=SecondApiKey
```

PHP file
```php
$dotenv->start(['*']);

echo getenv('APP_NAME');
echo getenv('API_KEY');

// Output:
// Second App Name
// SecondApiKey
```

### Validating and requiring variables
`.env` file
```shell
APP_NAME="App Name"
PHONE_NUMBER=111222333
```

PHP file
```php
$dotenv->start();

$dotenv->validator()->validate([
    'APP_NAME'     => 'required|alnum',
    'PHONE_NUMBER' => 'required|integer',
]);

/* All validating rules:
 * - required
 * - letters (Letters and spaces only)
 * - alnum (Letters, numers and spaces)
 * - integer
 * - boolean (true/false)
 * - float
 */ 
```
