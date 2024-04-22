+++
title = "Font Awesome SVG Icons"
description = "A sprite sheet of all the font-awesome icons from version 4.0.2"
date = "2014-02-06"
category = "Web"
template = "post.html"
[taxonomies]
keywords = ["font-awesome", "font", "awesome", "vector", "logo", "svg", "eps", "icons", "sprite", "sheet"]
+++

This one was kind of annoying. I was looking for all the [font-awesome icons](http://fontawesome.io/) in a nice sheet so that [WARPAINT](warpaintmedia.ca) could design some mockups for a client. Well, of course this sheet doesn't exists.

So I used the following code to grab the icons from the [cheatsheet page](http://fontawesome.io/cheatsheet/).

```javascript
var arr = "";
$('.container .col-md-4').each(function(i, e) {
  arr += e.innerText.slice(0,1) + ', ';
});
console.log(arr);
```

I then took that output and pasted it into Sublime Text. I split the output into multiple lines, and replaced the commas with double spaces. That was then pasted into Illustrator and exported as SVG.

Voila! There you have this sprite sheet.

You can [download it here](/images/font-awesome-sheet.svg).

*These icons are from version 4.0.2*

