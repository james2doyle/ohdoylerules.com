---
Title: "rework-shade"
Description: "A package for rework that allows a shade function"
Date: "2013-06-23"
Category: "Personal Project"
Template: "post"
Keywords: ["javascript", "node", "rework", "shade", "css"]
---

I created another plugin for Rework that makes it easy to do lighten and darken functions. I called it [rework-shade](https://github.com/james2doyle/rework-shade "rework-shade github"). This package is also available [on NPM here](https://npmjs.org/package/rework-shade "rework-shade on NPM").

Here is the basic usage.

~~~~ {.prettyprint .lang-css}
/* input */
body {
  padding: 10px;
  background: shade(rgba(0, 0, 0, 0.5), 5);
}

/* using points */
.stuff {
  color: shade(rgb(0, 200, 50), 1.3);
}

.bright {
  background: shade(#004080, 30);
}

.dark {
  background: shade(#fff, -50);
}

/* output */
body {
  padding: 10px;
  background: rgb(13, 13, 13, 0.5);
}

.stuff {
  color: rgb(3, 203, 53, 1);
}

.bright {
  background: rgb(77, 141, 205, 1);
}

.dark {
  background: rgb(128, 128, 128, 1);
}
~~~~
