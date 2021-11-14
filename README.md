# Project

It is an online store with a backoffice, a payment and email system developed with Symfony.

## Development environment

### Prerequisites

*   PHP 8.0
*   Composer
*   Somfony CLI
*   Nodejs et npm

You can check the prerequisites with the following command (from the Symfony CLI) :

```bash
symfony check:requirements
```

### Download

To download the project typed the following commands:

```bash
cd your path (example : C:/wamp64/www)
git clone https://github.com/cdiot/ecommerce.git
```

### Environment variable required

*   `DATABASE_URL`
*   `MAILER_DSN`

### Launch the development environment

Configure the environment variables by copying the .env file to .env.local at the root directory of your project and define the news values.

To start the development environment typed the following commands :

```bash
composer install
npm install
npm run build
symfony serve -d
```

### Run datafixtures

To run datafixtures typed the following commands :

```bash
symfony console doctrine:fixtures:load
```

### Run tests

Tests that interact with the database use their own separate database to not mess with the databases used.

To do that, edit or create the .env.test.local file at the root directory of your project and define the new value for the environment variables.

After that, create the test database and all tables using :

```bash
symfony console --env=test doctrine:database:create
symfony console --env=test doctrine:schema:create
symfony console --env=test doctrine:fixtures:load
```

or update the test database using :

```bash
symfony console --env=test doctrine:schema:update
```

To run tests typed the following commands :

```bash
symfony php bin/phpunit --testdox
```
