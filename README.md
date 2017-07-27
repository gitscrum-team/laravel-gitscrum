![Laravel GitScrum](https://gitscrum.com/facebook.jpg)

<hr>
<p align="center">
Site: <b>https://www.gitscrum.com</b> | 
Community and Issues : <b>https://www.gitscrum.com/community</b>
</p>
<hr>
<p align="center">
<b><a href="#overview">Overview</a></b>
|
<b><a href="#installation">Installation</a></b>
|
<b><a href="#setup">Setup</a></b>
|
<b><a href="#screens">Screens</a></b>
|
<b><a href="#questions-and-issues">Questions and Issues</a></b>
|
<b><a href="#contributing">Contributing</a></b>
|
<b><a href="#license">License</a></b>
</p>

<hr>
<p align="center">
<b>Facebook Group: https://www.facebook.com/groups/gitscrum/ </b>
</p>
<hr>

[![Laravel 5.4](https://img.shields.io/badge/Laravel-5.4-brightgreen.svg?style=flat-square)](http://laravel.com)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/2abfe5173e0b4565a2b1e3e345160939)](https://www.codacy.com/app/renatomarinho/laravel-gitscrum?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=renatomarinho/laravel-gitscrum&amp;utm_campaign=Badge_Grade)
[![Total Downloads](https://poser.pugx.org/renatomarinho/laravel-gitscrum/downloads)](https://packagist.org/packages/renatomarinho/laravel-gitscrum)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/GitScrum-Community/laravel-gitscrum/blob/master/LICENSE.md)

<hr>

## Overview

Laravel GitScrum is a **free application** developed in Laravel 5.4. The aim is help the developer teams to use **Git** and **Scrum** on task management of the day-to-day.

Available in English, Chinese, Russian, German, Arabic, Spanish, Portuguese, Italian, French, Indonesian and Hungarian.


Laravel GitScrum in gitter.im : [https://gitter.im/laravel-gitscrum/Lobby](https://gitter.im/laravel-gitscrum/Lobby?utm_source=share-link&utm_medium=link&utm_campaign=share-link)

### Features

GitScrum can be integrated with **Github** or **Gitlab**.

- **Product Backlog** contains the Product Owner's assessment of business value

- **User Story** is a description consisting of one or more sentences in the everyday or business language that captures what a user does or needs to do as part of his or her job function.

	**Features**: Acceptance criteria, prioritization using MoSCoW, definition of done checklist, pie chart, assign labels, team members, activities, comments and issues.

- **Sprint Backlog** is the property of the development team and all included estimates are provided by development team. Often an accompanying sprint planning is the board used to see and change state of the issues.

	**Features**: Sprint planning using Kanban board, burndown chart, definition of done checklist, effort, attachments, activities, comments and issues.

- **Issue** is added in user story to one sprint backlog, or directly in sprint backlog. Generally, each issue should be small enough to be easily completed within a single day.

	**Features**: Progress state (e.g. to do, in progress, done or archived), issue type (e.g. Improvement, Support Request, Feedback, Customer Problem, UX, Infrastructure, Testing Task, etc...), definition of done checklist, assign labels, effort, attachments, comments, activities, team members.



## Installation

The requirements to Laravel GitScrum application is:

- **PHP - Supported Versions**: >= 7.1
- **Webserver**: Nginx or Apache
- **Database**: MySQL, or Maria DB

[**Use Docker** - Containers: php7, nginx and mysql57](https://github.com/renatomarinho/Docker-GitScrum)

### Composer Package

```
$ composer create-project renatomarinho/laravel-gitscrum --stability=stable --keep-vcs
$ cd laravel-gitscrum
```
**Important**: If you have not yet installed composer: [Installation - Linux / Unix / OSX](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)


### Git Clone

```
$ git clone git@github.com:GitScrum-Community/laravel-gitscrum.git
$ cd laravel-gitscrum
$ composer update
$ composer run-script post-root-package-install
```


## Setup

**Important**: If you have not the .env file in root folder, you must copy or rename the .env.example to .env

#### Application URL

.env file

```
APP_URL=http://yourdomain.tld (you must use protocol http or https)
```

#### Language

Options: en | zh | zh_cn | ru | de | es | pt | it | id | fr | hu

.env file

```
APP_LANG=en
```
Can you help us translate a few phrases into different languages? See: https://github.com/GitScrum-Community/laravel-gitscrum/tree/feature/language-pack/resources/lang


#### Database

.env file

```

DB_CONNECTION=mysql
DB_HOST=XXXXXX
DB_PORT=3306
DB_DATABASE=XXXXX
DB_USERNAME=XXXX
DB_PASSWORD=XXXXX
```

**Remember**: Create the database for GitScrum before run artisan command.

```
php artisan migrate --seed
```

#### Github

You must create a new Github App, visit [GitHub's New OAuth Application page](https://github.com/settings/applications/new), fill out the form, and grab your Client ID and Secret.

```
Application name: gitscrum
Homepage URL: URL (Same as APP_URL at .env)
Application description: gitscrum
Authorization callback URL: http://{URL is the SAME APP_URL}/auth/provider/github/callback
```

.env file

```
GITHUB_CLIENT_ID=XXXXX
GITHUB_CLIENT_SECRET=XXXXXXXXXXXXXXXXXX
```

#### Gitlab

You must create a new Gitlab App, visit [Gitlab new application](https://gitlab.com/profile/applications), fill out the form, and grab your Application ID and Secret.

```
name: gitscrum
Redirect URI: http://{URL is the SAME APP_URL}/auth/provider/gitlab/callback
Scopes: api and read_user
```

.env file

```
GITLAB_KEY=XXXXX -> Application Id
GITLAB_SECRET=XXXXXXXXXXXXXXXXXX
GITLAB_INSTANCE_URI=https://gitlab.com/
```

#### Proxy

.env file

```
PROXY_PORT=
PROXY_METHOD=
PROXY_SERVER=
PROXY_USER=
PROXY_PASS=
```


## Screens

![Screenshot 0](http://i.imgur.com/jejT8hY.png)
![Screenshot 0](http://i.imgur.com/apcFdv0.png)
![Screenshot 0](http://i.imgur.com/TRzRIpU.png)
![Screenshot 0](http://i.imgur.com/VcpRaNk.png)
![Screenshot 0](http://i.imgur.com/8uMYCLv.png)
![Screenshot 0](http://i.imgur.com/rIwkn7i.png)
![Screenshot 0](http://i.imgur.com/D954dbU.png)

<br>

## Database schema 

![Screenshot 1](http://i.imgur.com/zdrEkkf.png)

<br>

## Questions and issues

The [github issue tracker](https://github.com/GitScrum-Community/laravel-gitscrum/issues) is **_only_** for bug reports and feature requests. Anything else, such as questions for help in using the Laravel Gitscrum, should be posted in [StackOverflow](http://stackoverflow.com/questions/tagged/gitscrum) under tag `gitscrum`.

### Do you need help?

Renato Marinho: [Facebook](https://www.facebook.com/renato.marinho) / [LinkedIn](https://pt.linkedin.com/in/renatomarinho13) / Skype: renatomarinho13


## Contributing

Contributions are always welcome! https://github.com/GitScrum-Community/laravel-gitscrum/graphs/contributors


## License

Laravel GitScrum is licensed under the [MIT license](https://opensource.org/licenses/MIT).


## Thanks

#### Translate Team : [@orionlu0916](https://github.com/orionlu0916) , [@Bebbolus](https://github.com/Bebbolus) , [@dongm2ez](https://github.com/dongm2ez), [@rizalio](https://github.com/rizalio), [@ddmler](https://github.com/ddmler), [@Assada](https://github.com/Assada), [@edbizarro](https://github.com/edbizarro), [@ngabor84](https://github.com/ngabor84), [@MarwanMohamed](https://github.com/MarwanMohamed) and Manuel Ortega

- [Laravel PHP Framework](https://github.com/laravel/laravel)

- [Chart.js](https://github.com/chartjs/Chart.js)

- [Date Range Picker for Bootstrap](https://github.com/dangrossman/bootstrap-daterangepicker)
