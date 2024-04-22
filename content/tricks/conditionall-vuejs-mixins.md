+++
title = "Conditional Vue.js Mixins"
description = "How to use commonjs modules as vue.js mixins and how to conditionally load mixins on a per-page-basis."
date = "2017-05-25"
category = "Tricks"
template = "post.html"
[taxonomies]
keywords = ["nodejs", "vuejs", "require", "mixin", "conditional"]
+++

When building more traditional Vue.js applications, I tend to use mixins a lot. It helps split up code, speparate concerns, and can allow for some cool tricks. One that i keep using is conditionally requiring a mixin based on the details of the page.

Here is an example. The first module is a function that, like `require`, will load a file into the script it is being called from. The thing is, this `require` function also takes a new parameter for checking if the page URL contains a particular string or _array of strings_.

#### conditionalRequire.js

```js
// loads mixins based on the current URL
module.exports = function(name, filename) {
  // name can be an array or single string value
  name = (typeof(name) === 'object') ? Array.from(name) : [name];
  // are there any matches?
  const check = name.filter((n) => window.location.pathname.includes(n)).length;

  // return a no-op function for better compatibility with traditional require
  return check ? require(filename) : function() { return {}; };
};
```

The next code block below would be for you main app file. This would be the file included in all of the footers on your site. Some things to assume is these modules exist in a folder called `mixins/` and that the source files in there are returning a valid object that works as a mixin.

#### index.js

```
// include the module from the above snippet
const conditionalRequire = require('conditionalRequire');

// create our Vue app
const app = new Vue({
  el: "#app",
  data: {
    // ...
  },
  mixins: [
    require('mixins/global'), // a regular module - loaded always
    require('mixins/navigation'), // a regular module - loaded always
    conditionalRequire('home', 'mixins/home'), // only load when on the "/home" page
    conditionalRequire('profile', 'mixins/profile'), // only load when on the "/profile" page
    conditionalRequire(['about', 'contact'], 'mixins/forms') // load on "/about" and "/contact"
  ]
});
```

So you can see this can be a handy trick. You don't load code on pages you don't need it. There are ways to do this using components and `v-if` but it is a lot "softer" than simply never running/including code that you know is not needed.
