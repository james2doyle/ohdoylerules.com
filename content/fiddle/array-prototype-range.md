+++
title = "Array.prototype.range()"
description = "How to create Array.prototype.range in Javascript"
date = "2012-10-18"
category = "Fiddle"
template = "post.html"
[taxonomies]
keywords = ["array", "prototype", "range", "javascript", "js"]
+++

I wrote this little prototype after seeing the range function in ruby.

```js
Array.prototype.range = function(a, b, step) {
  step = !step ? 1 : step;
  b = b / step;
  for(var i = a; i <= b; i++) {
    this.push(i * step);
  }
  return this;
};

// usage

var myarray = [];
myarray.range(0, 10, 2); // myarray now returns [0, 2, 4, 6, 8, 10]
```
