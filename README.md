# Social Login for Laravel

This package adds a social login component that can be used to log users
using linkedin

## Features

- Log the user using Linkedin

## Requirements

To use this package you need to create a linkedin application and get the following creadentials

- LINKEDIN_CLIENT_ID
- LINKEDIN_CLIENT_SECRET

### Create a linkedin app

Watch the video below for a step by step guide on how to add a linkedin login to your laravel app using this package.

[![How To](https://img.youtube.com/vi/tX8NEwWsfcg/0.jpg)](https://www.youtube.com/watch?v=tX8NEwWsfcg)

You can find the instructions to create a new linkedin app in the official documentation [here](https://www.linkedin.com/help/linkedin/answer/a1667239)

✅ Services to enable:

When you create the linkedin app you need to activate the following services in the Products tab:

- 1. OpenId connect, [read more](https://learn.microsoft.com/en-us/linkedin/consumer/integrations/self-serve/sign-in-with-linkedin-v2)
- 2. Share on Linkedin [read more](https://learn.microsoft.com/en-us/linkedin/consumer/integrations/self-serve/share-on-linkedin)

## Usage

**Install the composer package**:

The first step is to install the package in your laravel application.

```bash
composer require pacificdev/social-login-for-laravel
```

Add the social login component in the login and register pages as shown below

```php
// login.blade.php
<x-pacificdev::social-login />
```

```php
// register.blade.php
<x-pacificdev::social-login />
```

Add the linkedin service

```php
#config/services.php
 'linkedin-openid' => [
        'client_id' => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        'redirect' => env('LINKEDIN_REDIRECT_URL', '/linkedin/auth/callback'),
    ],
```

## Publish the package files

If you need to make changes to the package config file, views or migrations you can
publish them using the following commands:

```php
# publish the config file
php artisan vendor:publish --tag=pacificdev-social-login-config
# publish the views
php artisan vendor:publish --tag=pacificdev-social-login-views
# publish the migrations
php artisan vendor:publish --tag=pacificdev-social-login-migrations

```

## Roadmap

- [X] Linkedin Login
- [ ] Google Login
