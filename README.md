![Laravel GitScrum](http://i.imgur.com/ZIMPy4w.png)

#Laravel GitScrum

GitScrum is a Laravel 5.3 application to helps teams use Git version control and the Scrum framework in the support for day-to-day task management.

[![Build Status](https://travis-ci.org/renatomarinho/laravel-gitscrum.svg?branch=master)](https://travis-ci.org/renatomarinho/laravel-gitscrum)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/renatomarinho/laravel-gitscrum/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/renatomarinho/laravel-gitscrum/?branch=master)
[![Total Downloads](https://poser.pugx.org/renatomarinho/laravel-gitscrum/downloads)](https://packagist.org/packages/renatomarinho/laravel-gitscrum)


![Sprint Planning](http://i.imgur.com/9QWUd7Y.png)


## Instalation

### Create a project using Composer

It is very simple, run the command and enjoy

```
composer create-project renatomarinho/laravel-gitscrum --stability=dev --keep-vcs
```

Jump to GitHub Application and Database connection


#### Starting

Create a fork and after clone the git repository

```
git clone git@github.com/xxxxxxx/xxx.git
```

Go to the project folder

```
cd GitScrum
```

Update composer

```
composer update
```


#### GitHub Application

First, create a new github app, visit [GitHub's New OAuth Application page](https://github.com/settings/applications/new), fill out the form, and grab your client ID, secret and callback URL.

```
Application name: gitscrum
Homepage URL: URL (Same as APP_URL at .env)
Application description: gitscrum
Authorization callback URL: http://URL/auth/github/callback
```
Finally fill the informations in the .env file

```
GITHUB_CLIENT_ID=XXXXX
GITHUB_CLIENT_SECRET=XXXXXXXXXXXXXXXXXX
```

#### Database connection

Fill the information in the .env file

```
DB_CONNECTION=mysql
DB_HOST=XXXXXX
DB_PORT=3306
DB_DATABASE=XXXXX
DB_USERNAME=XXXX
DB_PASSWORD=XXXXX
```

and after run the command

```
php artisan migrate --seed
```

![Screenshot 1](http://i.imgur.com/zdrEkkf.png)
27 tables

## Use Docker
Containers to run GitScrum : [php7, nginx and mysql57](https://github.com/renatomarinho/Docker-GitScrum)

## Screenshots

![Screenshot 0](http://i.imgur.com/RcYFFCp.png)



![Screenshot 1](http://i.imgur.com/URnC74b.png)


![Screenshot 2](http://i.imgur.com/p6j1pKK.png)


![Screenshot 3](http://i.imgur.com/IDHeay1.png)



## License

The GitScrum is licensed under the [GPL v3 license](http://opensource.org/licenses/GPL-3.0).

## Do you need help?

Renato Marinho:
Facebook: https://www.facebook.com/renato.marinho /
LinkedIn: https://pt.linkedin.com/in/renatomarinho13 /
Skype: renatomarinho13

## Thanks

[Laravel PHP Framework](https://github.com/laravel/laravel)

[Flat-UI](https://github.com/designmodo/Flat-UI)

[Chart.js](https://github.com/chartjs/Chart.js)

[Date Range Picker for Bootstrap](https://github.com/dangrossman/bootstrap-daterangepicker)

**and :) We love GitHub**
