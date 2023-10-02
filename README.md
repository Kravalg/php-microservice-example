[![SWUbanner](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/banner2-direct.svg)](https://supportukrainenow.org/)

# Technical task

[![CodeScene Code Health](https://codescene.io/projects/39797/status-badges/code-health)](https://codescene.io/projects/39797)
[![CodeScene System Mastery](https://codescene.io/projects/39797/status-badges/system-mastery)](https://codescene.io/projects/39797)
[![codecov](https://codecov.io/gh/VilnaCRM-Org/php-service-template/branch/main/graph/badge.svg?token=J3SGCHIFD5)](https://codecov.io/gh/VilnaCRM-Org/php-service-template)
![PHPInsights code](https://img.shields.io/badge/PHPInsights%20%7C%20Code%20-100.0%25-success.svg)
![PHPInsights style](https://img.shields.io/badge/PHPInsights%20%7C%20Style%20-100.0%25-success.svg)
![PHPInsights complexity](https://img.shields.io/badge/PHPInsights%20%7C%20Complexity%20-100.0%25-success.svg)
![PHPInsights architecture](https://img.shields.io/badge/PHPInsights%20%7C%20Architecture%20-100.0%25-success.svg)

## Possibilities
- Modern PHP stack for services: [API Platform 3](https://api-platform.com/), PHP 8, [Symfony 6](https://symfony.com/)
- [Hexagonal Architecture, DDD & CQRS in PHP](https://github.com/CodelyTV/php-ddd-example)
- Built-in docker environment and convenient `make` cli command
- A lot of CI checks to ensure the highest code quality that can be ([Psalm](https://psalm.dev/), [PHPInsights](https://phpinsights.com/), Security checks, Code style fixer)
- Configured testing tools: [PHPUnit](https://phpunit.de/), [Behat](https://docs.behat.org/)
- Much more!

### Minimal installation
You can clone this repository locally or use Github functionality "Use this template"

Install the latest [docker](https://docs.docker.com/engine/install/) and [docker compose](https://docs.docker.com/compose/install/)

Create `.env.local` and fill the empty values
> cp .env .env.local

Use the `make` command to set up a project and automatically install all needed dependencies
> make start

Wait a few minutes for the first attempt to allow scripts to automatically install all dependencies and initialize the database structure

Also, you can monitor installing progress using the command
> make logs

Go to browser and open the link below
> https://localhost/docs

That's it. You should now be ready to use this service

## Using cli
You can use `make` command to easily control and work with project locally.

Execute `make` or `make help` to see the full list of project commands.

The list of the `make` possibilities:

```
artillery                    A load testing framework
behat                        A php framework for autotesting business expectations
build                        Builds the images (PHP, caddy)
cache-clear                  Clears and warms up the application cache for a given environment and debug mode
cache-warmup                 Warmup the Symfony cache
changelog-generate           Generate changelog from a project's commit messages
check-requirements           Checks requirements for running Symfony and gives useful recommendations to optimize PHP for Symfony.
check-security               Checks security issues in project dependencies. Without arguments, it looks for a "composer.lock" file in the current directory. Pass it explicitly to check a specific "composer.lock" file.
commands                     List all Symfony commands
composer-validate            The validate command validates a given composer.json and composer.lock
coverage                     Create the code coverage report with PHPUnit
doctrine-migrations-generate Generates a blank migration class
doctrine-migrations-migrate  Executes a migration to a specified version or the latest available version
down                         Stop the docker hub
first-release                Generate changelog from a project's commit messages for the first release
fix-perms                    Fix permissions of all var files
install                      Install vendors according to the current composer.lock file
update                       update vendors according to the current composer.json file
load-fixtures                Build the DB, control the schema validity, load fixtures and check the migration status
logs                         Show all logs
new-logs                     Show live logs
phpcsfixer                   A tool to automatically fix PHP Coding Standards issues
phpinsights                  Instant PHP quality checks and static analysis tool
phpunit                      The PHP unit testing framework
psalm                        A static analysis tool for finding errors in PHP applications
psalm-security               Psalm security analysis
purge                        Purge cache and logs
release                      Generate changelogs and release notes from a project's commit messages for the first release
release-major                Generate changelogs and commit new major tag from a project's commit messages
release-minor                Generate changelogs and commit new minor tag from a project's commit messages
release-patch                Generate changelogs and commit new patch tag from a project's commit messages
sh                           Log to the docker container
start                        Start docker
stats                        Commits by the hour for the main author of this project
stop                         Stop docker and the Symfony binary server
up                           Start the docker hub (PHP, caddy)
```

## Tests
Tests use PHPUnit 9 and [Behat](https://github.com/Behat/Behat).

### How to setup

Create `.env.test.local` and fill the empty values
> cp .env.test .env.test.local

Run e2e tests using behat
> make behat

Run unit tests using phpunit
> make phpunit
