# Dotenv
Library that adds the ability to access variables from '.env', $_ENV, and $_SERVER using the getenv() function


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

### Requiring variables
```php
$dotenv->validator()->required(['APP_NAME', 'API_KEY']);
```

### Retrieving  variables values
```php
echo getenv('APP_NAME');
echo $_SERVER['APP_NAME'];
echo $_ENV['APP_NAME'];

// output: My App Name
```

### Custom path or file name
```php
$dotenv = new Dotenv('myenvfile.env', '/path/to/file');

// Now you are using myenvfile.env from /path/to/file folder
```