# Dotenv
Library that adds the ability to access variables from '.env', $_ENV, and $_SERVER using the getenv() function


# Usage

### Basics
Add your application configuration variables to `.env` file in your project. Next add `.env` to `.gitignore` file! You should create a `.env.example` file to have a skeleton with variable names for your contributors
```shell
APP_NAME=YourAppName
API_KEY=YourApiKey
```

### Include `Dotenv` class
```php
use Dotenv\Dotenv;
```

### Load `.env` variables
```php
$dotenv = new Dotenv();
$dotenv->start();
```

### Retrieving  variables values
```php
echo getenv('APP_NAME');
echo $_SERVER['APP_NAME'];
echo $_ENV['APP_NAME'];

// output: YourAppName
```

### Custom path or file name
```php
$dotenv = new Dotenv('myenvfile.env', '/path/to/file');

// Now you are using myenvfile.env from /path/to/file folder
```