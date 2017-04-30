---
Title: "Flexible SVG Placeholder Images"
Description: "Replace a service like placehold.it with your own local version that serves SVG images"
Date: "2014-05-24"
Category: "Web"
Template: "post"
Keywords: ["php", "svg", "image", "placeholder", "placehold.it", "vector", "center", "text", "server", "placekitten"]
---

Do you use [placehold.it](http://placehold.it "Placehold.it Homepage")? It is a great service. The only thing is when you are offline, or you are testing a page that needs a lot of placeholders, it may not be the greatest solution.

**Enter the SVG placeholder.**

Here are the properties you can set:

* width and height
* background-fill
* font-color
* font-family
* font-size

Here is the actual SVG file. As you can see it is a PHP file, but you are serving it as an SVG (see the `Content-Type` part?). Here we grab the URL arguments and assign them to the SVG.

<script src="https://gist.github.com/3aad1d22163c3c3e5cfd.js?file=placeholder-svg.php" type="text/javascript"></script>

If you saved the file as `placeholder-svg.php` then it would be used like so:

```html
<img src="placeholder-svg.php?wh=400x400&fill=bada55&color=000000&font=Georgia&size=20" />
```

This would be the output:

<div class="center">
  <img src="http://ohdoylerules.com/content/images/placeholder.png" alt="Placeholder Example">
</div>

