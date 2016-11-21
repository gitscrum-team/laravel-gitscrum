# GitScrum

## Database

![Screenshot 1](http://i.imgur.com/QxHDVvk.png)


## Screnshots

![Screenshot 1](http://i.imgur.com/pMZuwH0.png)

![Screenshot 2](http://i.imgur.com/pRByX5K.png)

![Screenshot 3](http://i.imgur.com/mgJGNlA.png)

![Screenshot 4](http://i.imgur.com/isbTvHr.png)

![Screenshot 5](http://i.imgur.com/BIZtoq4.png)

![Screenshot 6](http://i.imgur.com/xnJeaIq.png)

## Setup

First, create a new github app, visit [GitHub's New OAuth Application page](https://github.com/settings/applications/new), fill out the form, and grab your client ID, secret and callback URL.

```
Application name: gitscrum
Homepage URL: URL
Application description: gitscrum
Authorization callback URL: http://URL/auth/github/callback
```

Finally fill the informations in the .env file

````
...
GITHUB_CLIENT_ID=XXXXX
GITHUB_CLIENT_SECRET=XXXXXXXXXXXXXXXXXX
````

## License

The GitScrum is licensed under the [GPL v3 license](http://opensource.org/licenses/GPL-3.0).
