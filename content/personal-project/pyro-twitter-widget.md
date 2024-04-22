+++
title = "Pyro Twitter Widget"
description = "Pyro Twitter Widget"
date = "2013-08-08"
category = "Personal Project"
template = "post.html"
[taxonomies]
keywords = ["pyro", "pyrocms", "twitter", "widget", "oauth", "1.1", "api", "support"]
+++

I created another widget for PyroCMS. This one is for Twitter. I didn't find one that I liked or thought was very good, so I created my own. This widget actually uses a 3rd party sub-module, for the Twitter authentication, called [twitter-api-php](https://github.com/J7mbo/twitter-api-php "J7mbo/twitter-api-php").

Here are the current supported (basically just tested) API endpoints:

* statuses/mentions_timeline
* statuses/user_timeline
* statuses/home_timeline
* statuses/retweetsofme
* favorites/list

Here is the [widget on Github](https://github.com/james2doyle/pyro-twitter-widget "james2doyle/pyro-twitter-widget").
