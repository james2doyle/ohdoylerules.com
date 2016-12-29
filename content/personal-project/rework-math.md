/*
Title: rework-math
Date: 2013-06-23
Category: Personal Project,Web
Template: post
Keywords: 
*/

I created a plugin for
[Rework](https://github.com/visionmedia/rework "rework") CSS
preprocessor to do math. Here is the [github
repo](https://github.com/james2doyle/rework-math "rework-math"). It is
also my first ever NPM package and it can be found on the website
[here](https://npmjs.org/package/rework-math "rework-math on NPM").

~~~~ {.prettyprint .lang-css}
/* input */
div {
  padding: math(5+5px);
}
/* output */
div {
  padding: 10px;
}
~~~~

It also works with the rework-vars plugin.

~~~~ {.prettyprint .lang-css}
/* input */
:root {
  var-fontSize: 10px;
}

div {
  padding: math((var(fontSize) * 2) + 10px);
}

/* output */
:root {
  var-fontSize: 10px;
}

div {
  padding: 30px;
}
~~~~
