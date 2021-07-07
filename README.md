# Demo Pin Generator App

## Setup 

All Steps are run using docker cli from the root directory

1. Install PHP Dependencies

```bash
docker run --rm --interactive --tty -v $PWD:/app composer install
```

2. Run Program

 * Server
```bash
docker run -d -p 8881:80 --name=demo-server --rm -v "$PWD":/var/www php:8-apache
```

 * From CLI
```bash
 docker run --rm -v "$PWD":/app -w "/app" php:8-cli php app.php
```

## View Website 

http://127.0.0.1:8881/

## Run Tests

1. PHPUnit

```bash
    docker run --rm -v "$PWD":/app -w "/app" php:8-cli ./vendor/bin/phpunit
```

## Shutdown

1. Stop Docker Containers

```bash
docker stop demo-server
```