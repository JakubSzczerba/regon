# Regon
> Application for searching data from GUS via REGON number

## Technologies
* PHP - version 8.2.12
* Symfony - version 6.3.6
* PostgreSQL - version 13.2-1
* [GusApi](https://github.com/johnzuk/GusApi/) - version 3.3.2

## Local Setup
```
docker compose up -d
```
```
docker compose exec php composer install
```
```
docker compose exec php bin/console doctrine:database:create
```
```
docker compose exec php bin/console doctrine:migrations:migrate
```
## Tests

* Change name phpunit.xml.dist for phpunit.xml

```
docker compose exec php /var/www/regon/vendor/bin/phpunit
```

## Contact
* [GitHub](https://github.com/JakubSzczerba) 
* [LinkedIn](https://www.linkedin.com/in/jakub-szczerba-3492751b4/)