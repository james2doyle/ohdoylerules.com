+++
title = "nodelist.each"
description = "nodelist.prototype.each in javascript"
date = "2012-09-06"
category = "Snippets"
template = "post.html"
[taxonomies]
keywords = ["javascript", "nodelist", "foreach", "each", "array.prototype.slice.call", "each", "node", "each"]
+++

I was doing a project in vanilla javascript that used querySelectorAll, which returns a nodelist object. I wanted the jQuery each function so that I could add an event listener to each element. It was a school project and no jQuery allowed so I did some research and came up with this little prototype.

Here is the result:

```javascript
Object.prototype.each = function(callback) {
  // new empty array
  var a = [];
  // iterate through the nodelist
  for (var i = 0; i < this.length; i++) {
    // put the objects into the array
    a[i] = this[i];
    // callback the new array
    callback(a[i]);
  }
}
// USAGE
var x = document.querySelectorAll('li');
x.each(function(elem) {
    elem.style.background = 'red';
});
```

Pretty cool. [Here is the fiddle](http://jsfiddle.net/james2doyle/nrhgr/ "each prototype")

