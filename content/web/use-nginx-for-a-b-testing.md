+++
title = "Use Nginx for A/B Testing"
date = "2016-08-28"
category = "Web"
template = "post.html"
description = "Use Nginx to set custom headers in your HTTP responses so you can serve conditional content"
[taxonomies]
keywords = ["nginx", "server", "middleware", "a", "b", "test", "content", "conditional", "header", "marketing"]
+++

I was starting a new project the other day that had a heavy marketing influence. The team was wondering about possibly A/B testing the main content section of the website.

It got me thinking about doing A/B test with content and how that works.

There are a couple of ways that A/B testing can be accomplished. After some quick Google-ing, I found this cool feature of Nginx called `split_clients`.

Here is a little breakdown of that module:

> The `ngx_http_split_clients_module` module creates variables suitable for A/B testing, also known as split testing.

There is a [great article at DigitalOcean](https://www.digitalocean.com/community/tutorials/how-to-target-your-users-with-nginx-analytics-and-a-b-testing) about getting `split_clients` setup.

Nginx will allow you to apply certain variables to a segment of your traffic. For example:

```
http {
    split_clients "${remote_addr}" $variant {
            0.5%    .one;
            2.0%    .two;
            *       "";
    }

    server {
        location / {
            index index${variant}.html;
```

You can break this down as:

> 0.5% of the traffic will see `index.one.html`, 2.0% of the traffic will see `index.two.html`, and the rest will see `index.html`.

Although this is perfect for serving static content, what about dynamic content? I figured this would be better if it set a *custom header* that could then be handled in a response middleware and applied to my views. Here is the resulting code for that:

#### `/etc/nginx/conf.d/split-clients.conf` file

```
split_clients "${remote_addr}" $ab_test {
    # 50% of the traffic is "A" traffic
    50%     "A";
    # the remaining traffic (the other 50%) will be set to "B"
    *       "B";
}
```

If your Nginx is setup with the default `nginx.conf`, then there is an include that will autoload all `.conf` files in `/etc/nginx/conf.d/` folder.

So you can put files in there that you want to be globally loaded in the main `http {}` block.

#### `/etc/nginx/sites-enabled/default` or `/etc/nginx/sites-enabled/somewebsite` file

```
server {
    # probably some `listen 80;` code above, and some other things

    # this will come out in our response headers
    add_header X-AB-Testcase $ab_test;

    # the rest of the code below for `location / {}` and all that...
}
```

This would be the resulting response from any HTTP request:

<div class="center">
  <a href="/images/nginx-ab-header.png" title="Nginx example of the custom a/b header" target="_blank"><img alt="Nginx example of the custom a/b header" src="/images/nginx-ab-header.png" ></a>
</div>

Awesome! Now half of all traffic will be tagged with either *X-AB-Testcase: A* or *X-AB-Testcase: B*.

Finally, we could add a middleware to collect that information from the header and pass it to variables in your views, or you could use AJAX to check the headers of a piece of conditionally content.

The `split_clients` directive uses the IP of the request to assign it to either pool. Given this functionality, *if you are using shared internet connection in the office, this can be difficult to test*.

I used `curl` requests from 2 different external servers to make sure that we were getting both A and B set by various IPs.

