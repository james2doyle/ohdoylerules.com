/*
Title: Switching to SVG on Grey Nimbus
Date: 2013-04-14
Category: Personal Project,Snippets,Web
Template: post
Keywords: svg, grey, nimbus, fuelphp, static, user agent sniffing, vector, retina, minify, minifier, fuel, extension
*/

So I recently bought the [Sketch app](http://www.bohemiancoding.com/sketch/ "Sketch Website") for Mac. I am using it because I don't have illustrator. But to be honest, it is much better at doing small things. It's been about 2 hours switching the whole thing over and I have to say it is worth it.

I also found a [SVG minifier](https://github.com/svg/svgo "svg/svgo") that I will definitely be using in the future. It managed to save about 50-60% on each image. Which, for compression, is very good. After all is said and done, I saved about 10kb. Now this is not a lot but I also eliminated the use of retina.js. Which cause a second request for each image that has an @2x version. So on mobile I have made the site much faster.

Also, because of the way that FuelPHP does it's caching, I was not able to cache the images. Because it would append a query at the end for the cache and retina.js would not be able to find the retina version. That means that any retina device would take double(approximately) requests to get the full page.

I did something I think is rather clever. What I did was, since SVG support is high, I sniffed the user agent to see if it is one of the browsers that doesn't support SVG. Then I set a global and used that to define the extension I was going to use.

    <a href="#welcome">
      <?php echo Asset::img('nimbus'.$ext, array("width"=>"275", "height"=>"57", "alt"=>"Grey Nimbus Logo")); ?>
    </a>

Now \$ext would be equal to ".png" or ".svg" depending on the browser you were in. Now the changes are live so you can see that everything is all SVG! It should also look quite pretty on retina screens. [Have a look](http://greynimbus.com "Grey Nimbus Website"). The site still loads in under 1 second. Which, according to Google, is a good thing.
