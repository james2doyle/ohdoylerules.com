---
Title: "Tailwind Screens In JS"
Description: "Detect if a tailwind screen value matches the current window"
Date: "2020-09-05"
Category: "Snippets"
Template: "post"
Keywords: ["tailwind", "css", "screens", "js"]
---

If you haven't heard of [Tailwindcss](https://tailwindcss.com/) before, what is going on? It is the hot new CSS framework for building custom designs.

From the site:

> Tailwind CSS is a highly customizable, low-level CSS framework that gives you all of the building blocks you need to build bespoke designs without any annoying opinionated styles you have to fight to override.

One of the things Tailwindcss gives you is a configuration file (named `tailwind.config.js`) for setting the configuration of the output CSS. This may be a little strange to people who have never used this before but there are some advantages. The output CSS can be configured based on the build environment or your own specifications.

One of the configuration settings is for what screen sizes and breakpoints are supported. One of the benefits of these values being defined in JS is that you can then use them in JS as well. You can [read more about them in the docs](https://tailwindcss.com/docs/breakpoints).

So why might you want to use these values in JS? Well, if you are building components that have conditional content based on the screen size, having access to these values can be super handy. You can check the screen size and show/hide different content, conditional load different sizes elements, or even disable an entire swath of features/functionality. All while keep your JS code in sync with your CSS code. You can reuse the variable names.

Here is the code I used to accomplish this:

<script src="https://gist.github.com/james2doyle/c1306ace82cfe9e22a4ecfff13c6595b.js"></script>

You can use the function like so:

```js
// es6
// import screenIs from 'screenIs';
// commonjs
const screenIs = require('screenIs');

if (screenIs('md')) {
  // we are on an "md" screen...
}

const { md, lg } = screenIs();
if (md || lg) {
  // we are on an "md" or an "lg" screen...
}
```

Basically, we load up the config, use [`window.matchMedia`](https://developer.mozilla.org/en-US/docs/Web/API/Window/matchMedia) to test all the media queries in the config, then check if the key we pass in matches an existing key in our config and return the results.

Pretty simple but a nice way to share the config into your JS code.

If you are familiar with Tailwind, you might be asking, _why not just use CSS with md:show and md:hide?_

While that does work perfectly for visual content, it does not stop the browser from creating the DOM for the hidden content or stop and event listeners from being created or removed. If you are using the detection of the screen in JS, you can make sure to not render or add events for code that is not used. The opposite is true for when the screen changes and you need to cleanup any listeners or DOM elements you don't want to be there.
