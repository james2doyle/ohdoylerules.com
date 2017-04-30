---
Title: "PhalconPHP Crop Image To Fit"
Description: "How to crop and scale an image to fit specific dimensions in Phalcon PHP"
Date: "2014-11-24"
Category: "Snippets"
Template: "post"
Keywords: ["phalcon", "php", "imagick", "gd", "liquidRescale", "resize", "crop", "fit", "lrf"]
---

I was trying to find out how to crop-to-fit an image with `GD`. But there were no examples with Phalcon. There was one post that mentioned using `Imagick`. The only problem was that you needed to compiled Imagick with `--lrf` in order to use `liquidRescale`. This may not be an option on many hosting platforms. For that reason, I wanted to use `GD` instead.

I [found this post](http://salman-w.blogspot.com/2009/04/crop-to-fit-image-using-aspphp.html "Crop-To-Fit an Image Using ASP/PHP") after a quick Google search. It helped me create the base for my Phalcon version of the function. This may seem pretty easy for some people, but I found enough people asking, that I figured I would share the whole code.

<script src="https://gist.github.com/james2doyle/13a36401d6249729d017.js"></script>

If you really wanted to use Imagick, then you could just replace GD in the constructor (`Phalcon\Image\Adapter\Imagick($source)`) and it should work fine. This way you don't need to compile Imagick from source in order to get `liquidRescale`.

