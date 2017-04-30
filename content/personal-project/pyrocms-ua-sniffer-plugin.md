---
Title: "PyroCMS UA Sniffer Plugin"
Description: "A plugin for PyroCMS that allows UA Sniffing"
Date: "2013-06-23"
Category: "Personal Project,Web"
Template: "post"
Keywords: ["pyrocms", "plugin", "sniff", "useragent", "php", "code igniter"]
---

This plugin lets you sniff information from the user agent for use in the frontend. I use it for adding classes or conditional loading of partials and templates.

You can see the [github repository here](https://github.com/james2doyle/pyro-sniffer-plugin "pyro-sniffer-plugin github").

This plugin is **not** built on the [CodeIgniter User Agent Library](http://ellislab.com/codeigniter/user-guide/libraries/user_agent.html).

The reason I did not use the built in CodeIgniter lib, was because Pyro is only going to have CodeIgniter for a few more months(right?!?!), and I also want to have the information returned in a different way. This plugin is pretty small and only really gets information that is helpful to be used in CSS and Javascript (CSS custom classes and js feature detection/fallbacks).

If you are looking for a plugin that uses the user agent library, check out [this plugin called Agent](https://www.pyrocms.com/store/details/agent_plugin).

### [](#usage)Usage

    <body class="\{\{ sniffer:get key="browser|platform|type" \}\}">

On my Mac running Google Chrome, this would return:

    <body class=" google-chrome mac desktop">

On my iPhone, this would return:

    <body class=" apple-mobile-safari ios mobile">

#### [](#conditional-content)conditional content

This works in 2.2/develop. Not sure about 2.3 or 2.1.

    \{\{ if \{ sniffer:get key="type" \} == 'desktop' \}\}
    <div class="huge-slider">
      <div class="slide">
        <img src="img/kitten1.jpg" width="1400" height="500">
      </div>
      <div class="slide">
        <img src="img/puppy1.jpg" width="1400" height="500">
      </div>
      <div class="slide">
        <img src="img/snake1.jpg" width="1400" height="500">
      </div>
    </div>
    \{\{ else \}\}
    <div class="mobile-logo">
      <img src="img/mobile-logo.png" width="200" height="200">
    </div>
    \{\{ endif \}\}

here is the full dump of the `$results` object for my machine:

    $results = array (
      ['useragent'] => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.44 Safari/537.36' // full ua string
      ['name'] => 'Google Chrome' // name of the browser
      ['browser'] => 'google-chrome' // CSS safe browser name
      ['version'] => '28.0.1500.44' // bowser version
      ['type'] => 'desktop' // device form factor
      ['platform'] => 'mac' // OS platform
      ['pattern'] => '#(?Version|Chrome|other)[/ ]+(?[0-9.|a-zA-Z.]*)#' // match pattern
    );
