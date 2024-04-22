+++
title = "Pico-Useragent Plugin"
description = "A plugin for pico that allows you to list the useragent"
date = "2013-09-15"
category = "Personal Project"
template = "post.html"
[taxonomies]
keywords = ["pico", "cms", "useragent", "parse", "plugin", "ua", "sniffer", "twig", "templates", "conditional", "modernizr"]
+++

I created another plugin for [Pico CMS](http://pico.dev7studios.com/). It is esentially a clone of my [pyro-sniffer-plugin](https://ohdoylerules.com/personal-project/pyrocms-ua-sniffer-plugin) for [PyroCMS](http://pyrocms.com "Pyro CMS Homepage").

Here is the [Github project](https://github.com/james2doyle/pico_useragent).

This plugin allows you to parse the user agent of the current visitor and then expose that information in an easy to use variable in your twig templates.

Hopefully that makese sense.

### Output

When using the plugin, you get a new variable called `browser`. The browser variable has the following properties in it when dumped from my computer:

```php
$browser = array (
  'useragent'   => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.37 Safari/537.36' // full ua string
  'name'        => 'Google Chrome' // name of the browser
  'browser'     => 'google-chrome' // CSS safe browser name
  'version'     => '30.0.1599.37' // bowser version
  'type'        => 'desktop' // device form factor
  'platform'    => 'mac' // OS platform
  'pattern'     => '#(?Version|Chrome|other)[/ ]+(?[0-9.|a-zA-Z.]*)#' // match pattern
);
```

### Example

I use this example when I want to make small modifications to my CSS. Not unlike how Modernizr is supposed to work. Except modernizr doesn't give you browser information.

```html
<html lang="en" class="\{\{ browser.browser \}\} \{\{ browser.platform \}\} \{\{ browser.type \}\}">
```

Here is the output for that html tag:

```html
<html lang="en" class="google-chrome mac desktop">
```

I usually use it to normalize issues across different browsers. Like something looking weird in Firefox, so I know I can modify some CSS by using a `.firefox` parent.

```css
.button {
  padding: 0.25em 1em;
}
/* fix padding in FF */
.firefox .button {
  padding: 0.28em 1em;
}
```

### Use Cases

* conditional content
* conditional styles/scripts
* layout modifications
* serving specific images
* Modernizr-esque CSS classes

Here is the [Github project](https://github.com/james2doyle/pico_useragent) again.
