---
Title: "Modernizr SVG Fallback to PNG"
Description: "Modernizr SVG Fallback to PNG"
Date: "2013-05-27"
Category: "Snippets"
Template: "post"
Keywords: ["CodeIgniter", "generator", "Github", "laravel", "module", "open source", "PHP", "PyroCMS", "tool"]
---

<div class="center">
  <img src="http://ohdoylerules.com/content/images/githubgistlogo.png" alt="Github Gists Logo">
</div>

I have been building a small project boilerplate for when I am starting new projects. I wrote this small snippet based on [this article](http://toddmotto.com/mastering-svg-use-for-a-retina-web-fallbacks-with-png-script/ "Todd Motto - mastering-svg-use-for-a-retina-web-fallbacks-with-png-script").

The only changes I made were wrapping it in a closure and combining all the vars to make it smaller. Of course your minifier would do this anyway unless you are using it inline after including Modernizr.

[Here is the gist](https://gist.github.com/james2doyle/5659710 "modernizr-svg-replace.js").

Or you can copy the current version from right here.

```javascript
if (!Modernizr.svg) {
  // wrap this in a closure to not expose any conflicts
  (function() {
    // grab all images. getElementsByTagName works with IE5.5 and up
    var imgs = document.getElementsByTagName('img'),endsWithDotSvg = /.*\.svg$/,i = 0,l = imgs.length;
    // quick for loop
    for(; i < l; ++i) {
      if(imgs[i].src.match(endsWithDotSvg)) {
        // replace the png suffix with the svg one
        imgs[i].src = imgs[i].src.slice(0, -3) + 'png';
      }
    }
  })();
}
```
