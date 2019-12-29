# techPump

## Requirements

Add `127.0.0.1   sites.techpump.local` line in your `/etc/hosts` file. This is site for manage sites.

Add `127.0.0.1   cerdas.com` line in your `/etc/hosts` file. This is demo site.

Add `127.0.0.1   conejox.com` line in your `/etc/hosts` file. This is demo site.

## Starting server

```shell
cd server && docker-compose up -d
```

## Starting project

You can browser [http://cerdas.com:8080](http://cerdas.com:8080) or [http://conejox.com:8080](http://conejox.com:8080)
in your favorite navigator.

## Running tests

From `app/codeception`( or `/var/www/html/app/codeception` inside of container ) run:

```shell
php ../vendor/bin/codecept run --steps -d
```