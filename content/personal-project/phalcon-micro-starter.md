---
Title: "Phalcon Micro App Starter"
Date: "2015-01-20"
Category: "Personal Project"
Template: "post"
Description: "A showcase of a Phalcon Micro App starter template that makes it easy to get started with the Phalcon micro app class"
Keywords: ["Phalcon", "module", "open source", "PHP", "template", "micro", "simple", "starter"]
---

I created a [simple application template](https://github.com/james2doyle/phalcon-micro-start) that helps people get started with [Phalcon PHP](http://phalconphp.com/ "Phalcon PHP Homepage") using a more practical example of the [Micro application](http://docs.phalconphp.com/en/latest/reference/micro.html).

There is already a [sample application created by the Phalcon team that uses the Micro class](https://github.com/phalcon/store), but I found it to be a little more specific than I would like. It uses things like the [Volt template engine](http://docs.phalconphp.com/en/latest/reference/volt.html), models, Database connections, and some other [glossed over Bootstrapping](https://github.com/phalcon/store/blob/master/config/bootstrap.php).

[My example application](https://github.com/james2doyle/phalcon-micro-start) contains very little. It has enough to get you started creating a simple JSON-based application, or just serving a static site with a few cached views.

## What's Included?

#### Basic page example

Just shows a simple GET route and serves a single view.

#### Partial views (`Simple` view engine)

The templates use partials for the header and footer of the site.

#### URL with params

You can pass parameters into the URL, and they will be rendered on the page.

#### JSON return

An example of how to return JSON via a POST request. There is also a comment that tells you the jQuery test function to try.

#### Cached view

This shows how you can serve a cached view, with an expiry. Good for those complicated pages that need to be refreshed every other day.

#### Redirect URL

This one is really simple. It just shows how you can redirect one URL request to another.

### Other Niceness

I also included a simple grunt task that uses `livereload`. This will refresh the browser when view files, or the `app.php` file, changes.

### Link

You can find the [repositry on Github](https://github.com/james2doyle/phalcon-micro-start). I will be updating and tweaking this project as I move along. It may become more feature-rich in the next few months. I would like to build a nice solid base for myself when using the Micro app.

There may be some need to add in some simple search examples, models, forms, validation, or even Database connections. But we will see if that is where it moved organically.