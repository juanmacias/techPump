# techPump

## Requirements

Add `127.0.0.1   sites.techpump.local` line in your `/etc/hosts` file. This is for manage sites.

Add `127.0.0.1   cdn.techpump.local` line in your `/etc/hosts` file. This is for cdn of public sites.

Add `127.0.0.1   cerdas.com` line in your `/etc/hosts` file. This is demo site.

Add `127.0.0.1   conejox.com` line in your `/etc/hosts` file. This is demo site.

## Starting server

```shell
cd server && docker-compose up -d
```

## Starting project

You can browser [http://cerdas.com:8080](http://cerdas.com:8080) or [http://conejox.com:8080](http://conejox.com:8080)
in your favorite navigator.

## Admin zone

You can access to site admin zone using [http://sites.techpump.local:8080](http://sites.techpump.local:8080) url.

You can use admin / techpump credentials. You can modify them from ``src/Config/Config.php` file.

## Creating a new Site:

1. Head to [Admin zone](http://sites.techpump.local:8080) 
1. Click in `Add` button
1. Fill inputs and save form.
1. Add your css files to /public/sites/site_domain/css
1. Add `127.0.0.1 site_domain` in `/server/conf/dns/etc_hosts`
1. That's all

## Running tests

From `src/codeception`( or `/var/www/html/src/codeception` inside of container ) run:

```shell
php ../vendor/bin/codecept run --steps -d
```
