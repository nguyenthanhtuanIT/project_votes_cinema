## Requirement

    PHP >=7.0
    MYSQL >=5.6

### INSTALL
* Please make sure your packages is latest

```bash
$ composer install
$ php -r "file_exists('.env') || copy('.env.example', '.env');"
$ php artisan key:generate
$ php artisan migrate --seed
$ php artisan serve --host=0.0.0.0 --port=9000

```

## Admin user
- Email: admin@example.com
- Password: 123123


## Request life-cycle

* It run from 1 to 8

```
1. routes/api
2. app/Http/Requests
3. app/Http/Controllers
4. app/Repositories/Eloquent
5. app/Presenters
6. app/Transformers
7. app/Http/Controllers
8. response
```
