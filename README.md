> Used [vinkla/hashids](https://github.com/tymondesigns/jwt-auth) package to create package.


## Installation

Update config/auth.php file

### 1. Change from

```
'defaults' => [
    'guard' => 'web', //CHange to 'api'
    'passwords' => 'users',
],
```

#### To

```
'defaults' => [
    'guard' => 'api',
    'passwords' => 'users',
],
```

### 2. Change from

```
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'api' => [
        'driver' => 'token', // Change to 'jwt'
        'provider' => 'users',
    ],
],
```

#### To

```
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

### 3. Change from

```
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\User::class, // Change this model, You can customize it
    ],

    // 'users' => [
    //     'driver' => 'database',
    //     'table' => 'users',
    // ],
],
```

#### To

```
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => akr4m\jwtauth\Models\User::class,
    ],

    // 'users' => [
    //     'driver' => 'database',
    //     'table' => 'users',
    // ],
],
```

Ready to deal!!

### Active API Routes
  
| url | Method | Middleware |
| ------ | ------ | ------ |
| /api/register | POST | api,guest
| /api/login | POST | api,guest
| /api/logout | POST | api
| /api/password/forgot | POST | api,guest
| /api/password/reset | POST | api,guest
| /api/me | GET | api,auth:api
  
#### Profile output

```
{
    "data": {
        "name": "Name",
        "email": "email@domain.com",
        "created_at": {
            "date": "2050-02-26 16:33:48.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        }
    },
    "meta": {
        "token": "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~token~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~"
    }
}
```

