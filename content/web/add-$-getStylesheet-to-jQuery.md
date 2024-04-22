+++
title = "Add $.getStylesheet To jQuery"
date = "2016-02-05"
category = "Web"
template = "post.html"
description = "Ever wanted to have a CSS/Stylesheet version of $.getScript? Well now you can with $.getStylesheet"
[taxonomies]
keywords = ["javascript", "jquery", "getScript", "getStylesheet", "getCss", "plugin", "function", "deferred"]
+++

Have you ever wanted to do this?

```js
$.when($.getStylesheet('css/main.css'), $.getScript('js/main.js'))
.then(function () {
  console.log('the css and js loaded successfully and are both ready');
}, function () {
  console.log('an error occurred somewhere');
});
```

Well, now you can! I have created an alternative to `$.getScript` that handles stylesheets. I called it [$.getStylesheet](https://gist.github.com/james2doyle/9456c3e145f8d0afbe25) for obvious reasons.

It implements the [$.Deferred](https://api.jquery.com/jQuery.Deferred/) object, which allows for chaining and pseudo-promises-style code. Just like `$.ajax`, `$.post`, and `$.get`. This also means you would have access to all the other methods on that object too, this means: `.then()`, `.always()`, `.done()`, and `.fail()`.

Here is the little function for [$.getStylesheet](https://gist.github.com/james2doyle/9456c3e145f8d0afbe25). It is just hosted on Github gist, so I can update it if I need to:

{{ gist(src="https://gist.github.com/james2doyle/9456c3e145f8d0afbe25.js") }}

You can see this is pretty simple. Just add the function after your jQuery script, or somewhere in your main script file.
