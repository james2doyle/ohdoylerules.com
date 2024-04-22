+++
title = "Use Laravel Valet for WordPress Multisites"
description = "Use Laravel Valet for developing local WordPress multisites"
date = "2019-09-01"
category = "Web"
template = "post.html"
[taxonomies]
keywords = ["laravel", "valet", "php", "subdomain", "wordpress", "multisite", "setup"]
+++

Working with WordPress multisites can sometimes be a pain. Especially if you are not using the amazing [Laravel Valet](https://laravel.com/docs/6.0/valet) tool to manage your local sites.

From the site:

> Valet is a Laravel (or any site really) development environment for Mac minimalists. No Vagrant, no /etc/hosts file.

I would add that everything can be managed from the command line as well. Very handy.

I'm going to make some assumptions for the rest of the post. Firstly, you already have a WordPress multisite setup at `~/Sites/my-blog` (or wherever your root folder is) that is already resolving with `my-blog.localhost`. The TLD (in my case `.localhost`) is not important either. Just imagine yours there instead.

We are going to want to add a new domain name that resolves to the exact same folder as our current blog setup. We can do that with `valet link`.

So let's run some commands:
 - `cd ~/Sites/my-blog`
 - `valet link my-other-blog.localhost`

Now we have 2 domains pointing to the same folder:

 - `my-blog.localhost`
 - `my-other-blog.localhost`

They are both going to resolve to the same site right now. That's OK. We need to tweak our `wp-config.php` to work properly with the requests.

If we have multisite already setup, we should see some sites in the `wp_blogs` table of our database. We want each of these "sites" to reflect the domains on our system. You can update those now and make sure that the domains match the ones we are setting up.

Then we need to update our `wp-config.php` with some changes:

```php
<?php
// wp-config.php

// ... there is going to be other stuff in here at the top...

// check for HTTPS since valet makes it easy to add HTTPS locally...
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';

// set the home vars based on the domain that is being used for this request
define('WP_HOME', $protocol . $_SERVER['HTTP_HOST']);
define('WP_SITEURL', WP_HOME);

// multisite settings, should be the same
define('WP_ALLOW_MULTISITE', true);
define('MULTISITE', true);

// grab the domain from the request and just set it as the current site
define('DOMAIN_CURRENT_SITE', $_SERVER['HTTP_HOST']);

// we get the IDs from `wp_blogs` table
// and use them here as our domain => wp_blog.id mappings
$site = [
    'my-blog.localhost' => 1,
    'my-other-blog.localhost' => 2,
][$_SERVER['HTTP_HOST']];

// we set the active ID here now that we have the right one
// based on the domain we are on in this request
define('SITE_ID_CURRENT_SITE', $site);
define('BLOG_ID_CURRENT_SITE', $site);

// the rest of the regular stuff
// up to you what you want here
define('WP_DEBUG', false);
define('WP_CACHE', false);
define('PATH_CURRENT_SITE', '/');
define('COOKIE_DOMAIN', '');
define('ADMIN_COOKIE_PATH', '/');
define('COOKIEPATH', '/');
define('SITECOOKIEPATH', '/');
```

So what we are doing here is taking advantage of the way PHP handles requests. Each request runs the entire application. So we can use the request itself as the state of our application. We use the domain to figure out which site we should be loading. Pretty simple.

Now we don't have to make multiple copies of the WordPress setup just to test the basic multisite features.

I understand that you probably don't want to do this as multisite is usually because you want to administrate multiple instances of WordPress at the same time. But when you are just using multisite for managing content. In my case, it was just that the site was multilingual and so we wanted the sites to be identical but the content is swapping in and out. So this is a setup for that instead of having two completely separate folders and copies.

The nice thing about this is that it also scales nicely. If you have new sites, just `valet link` the domain, and add to the array of `$sites`. Done!
