

## beforeInstall


```
composer require tymon/jwt-auth 1.0.0-rc.1

```
## publish `jwt` Config

```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

##set `jwt` driver
```
//config/auth.php

'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
```

## install `jc91715/jwt`

```
composer require jc91715/jwt:dev-master

```
## generate `route` `controller` `middleware`

```
php artisan make:jwt

```
## test

### `login` api `test`

yourdomain.work/api/auth/login

![file](https://dn-phphub.qbox.me/uploads/images/201801/01/9324/xIMZk2jzM1.png)

### `logout` api `test`

yourdomain.work/api/auth/logout
![file](https://dn-phphub.qbox.me/uploads/images/201801/01/9324/Hrh3ls5Y9Q.png)

### `refreshToken` api `test`

yourdomain.work/api/test/refresh/token

![file](https://dn-phphub.qbox.me/uploads/images/201801/01/9324/kj1lKp635U.png)
