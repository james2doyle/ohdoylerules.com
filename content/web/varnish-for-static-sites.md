+++
title = "Varnish For Static Sites"
date = "2015-09-20"
category = "Web"
template = "post.html"
description = "a small tutorial for how to setup Varnish cache for a flat site running on Apache"
[taxonomies]
keywords = ["varnish", "flat", "file", "site", "apache", "ubuntu", "install", "setup", "config"]
+++

Recently, [my company](http://warpaintmedia.ca) had a request to build a series of sites that could handle huge bursts of traffic. I asked some friends of mine, what a good solution for this would be. All of them said [Varnish](https://www.varnish-cache.org/).

If you don't know what Varnish is, check out this definition from their documentation:

> Varnish Cache is a web application accelerator also known as a caching HTTP reverse proxy. You install it in front of any server that speaks HTTP and configure it to cache the contents. Varnish Cache is really, really fast. It typically speeds up delivery with a factor of 300 - 1000x, depending on your architecture.

So you can see that having this tool would be really nice. A simple way to get started with Varnish is to set it up on a flat-file site. Maybe something like [PhileCMS](http://philecms.com/) perhaps? Here is [a nice curated list](https://www.staticgen.com/) of flat-file site generators.

### Setting Up

This tutorial assumes the following:

* You are using Ubuntu 14.04
* You have [Varnish and Apache installed](https://www.digitalocean.com/community/tutorials/how-to-install-and-configure-varnish-with-apache-on-ubuntu-12-04--3) *

\* This tutorial is for Ubuntu 12.04. Replace this command: `deb http://repo.varnish-cache.org/ubuntu/ lucid varnish-3.0` with this one `deb http://repo.varnish-cache.org/ubuntu/ trusty varnish-4.0`

### Apache Setup

First, you will want to serve Apache on a different port, because Varnish is going to act as our "web server" and Apache will only be used if the cache is stale or there is no item in the Varnish cache.

We can open `/etc/apache2/ports.conf` and make the following change:

```
# Listen 80
Listen 127.0.0.1:8080
```

We commented out the original listening port, and added our own.

If we have any sites setup, we should change their virtual host files as well. These files live in `/etc/apache2/sites-available` and end in `.conf`, so this demo file might be called `example.com.conf`

```
<VirtualHost *:8080>
  ServerAdmin hello@example.com
  ServerName  www.example.com
  ServerAlias example.com
  DocumentRoot /var/www/html/example.com
</VirtualHost>
```

If this site is not enabled, it would be done with the command `a2ensite example.com`.

#### Remove Caching And Header Changes

You need to **disable all caching in Apache**!

Varnish works by reading headers from any files served from our normal web server. Having caching in Apache might seem like killing 2 birds with 1 stone, but it doesn't work that way.

Rules you might want to check for in your `apache.conf` files:

* mod_headers - used for modifying headers, use with caution
* mod_deflate - for setting compression details
* mod_filter - used with mod_deflate for setting compression
* mod_expires - used for setting how long to cache files, use with caution

These different rule sets usually contain settings that would be great if we were *not* using Varnish. In this case, we are going to trust Varnish to manage all the headers for us.

When everything is good to go, restart Apache with `service apache2 restart`.

### Varnish Setup

First, we need to tell Varnish to live on port 80. We do that by editing the settings for the Varnish daemon.

The file we need to edit is `/etc/default/varnish`. Scroll down until you see the uncommented lines with code that looks like it does below. We need to it like this:

```
DAEMON_OPTS="-a :80 \
             -T localhost:6082 \
             -f /etc/varnish/default.vcl \
             -S /etc/varnish/secret \
             -s malloc,256m"
```

Most likely, you will only change the `-a` part to `80`.

Our Varnish configuration for our site lives at `/etc/varnish/default.vcl`, here is the one I am using:

{{ gist(src="https://gist.github.com/james2doyle/0feec6ab77078ad3fdce.js") }}

It is very basic. I really only want to cache text files (HTML, CSS, Javascript/JSON) and images.

To restart Varnish, use `service varnish restart`.

#### Restarting Varnish

If you restart or run out of memory, Varnish will rebuild the cache. This isn't great because you are trying to keep Varnish alive and the cache enabled.


### Testing

At this point we are ready to test.

I would suggest running the command `vanrnishstat` on your remote server so you can see things happening in the Varnish cache. Pressing the arrow keys up and down will give you a description of the item.

Then you can go to you site and click around. You should see the Varnish Stat table getting updated. You will want to watch the *MAIN.cache_hit* and *MAIN.cache_miss* numbers.

You want the *MAIN.cache_hit* to be as high as possible. This means that your Apache is not getting tapped for information, but Varnish is serving it straight to the client.

For the *MAIN.cache_miss*, you want that to be as low as possible. This number represents the number of times that Varnish had to hit Apache. Having a low *MAIN.cache_miss* means that we are only tapping Apache when we must.

#### Troubleshooting

Since we added that line in our `default.vcl` file for `X-Cache`, we can see which files are being served by Varnish. Using dev tools in Chrome/Safari or Firefox, we can look for a header in our request called `X-Cache`.

<div class="center">
  <a href="/images/varnish-x-cache.png" title="Varnish x-cache header example" target="_blank"><img alt="Varnish x-cache header example" src="/images/varnish-x-cache.png" ></a>
</div>

You can see that this item was *HIT*. This means that it will be counted in the *MAIN.cache_hit* column and not *MAIN.cache_miss* column. Good!

Things that mess up Varnish are headers and cookie headers especially. Sometimes you want or need some headers though. This setup does not allow any cookies to get through. If you had a normal CMS with this setup, you would find you wouldn't be able to log in, or there might be some CSRF Token (Cross Site Request Forgery) issues with form submissions if you use CSRF.

Varnish will let you control different areas where cookies or other things can change. You will want to refer to the [Varnish Documentation](https://www.varnish-cache.org/trac/wiki/VCLExampleRemovingSomeCookies) for these advanced features.
