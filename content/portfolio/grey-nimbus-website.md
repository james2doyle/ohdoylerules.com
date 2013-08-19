/*
Title: Grey Nimbus website
Date: 2013-04-11
Category: Portfolio,Web
Template: post
Keywords: grey, nimbus, design, updates, retina, js, no jquery, fuelphp, php, static, single page, parallax
*/

Finally took the time and initiative to launch [Grey Nimbus](http://greynimbus.com "Grey Nimbus Website"), my business. The website itself is built using [FuelPHP](http://fuelphp.com "FuelPHP"). The reason I chose it was because I was curious and it was pretty light weight.

The website has no database so that was pretty much ignored. But I wanted easy validation for forms and a good email library. This is handled nicely by Fuel. The docs are mostly good. I had to do a little google searching when I was trying to tie things in together.

I knew I wanted parallax and responsive. I found [a fork](https://github.com/spencerbaynton/cool-kitten "spencerbaynton/cool kitten") of the [cool-kitten](http://www.jalxob.com/cool-kitten/ "cool-kitten homepage") framework that I liked and created [my own fork](https://github.com/james2doyle/cool-kitten "james2doyle/cool kitten").

In my fork, the first thing I did was add [retina.js](http://retinajs.com/ "Retina.js Homepage"). I know some people knock retina.js because it uses [javascript](http://mir.aculo.us/2012/09/22/dont-use-javascript-for-retinafying/ "Thomas Fuchs - Don’t use JavaScript for Retinafying") to replace images with an @2x version.

> Maybe in the next update I will switch to SVG images, but I digress.

The second thing I did was create a [build script](https://github.com/james2doyle/cool-kitten/blob/master/compile.sh "james2doyle/cool-kitten build script") to concatenate and minify the javascript and css. It uses [clean-css](https://github.com/GoalSmashers/clean-css "GoalSmashers/clean-css") and [uglifyjs](https://github.com/mishoo/UglifyJS "mishoo/UglifyJS").

The reason I didn't use something like grunt.js is because I only had 2 tasks to run and it was only when I was ready to push to the server. I added a condition in the head and footer to check to see if the site was in production and load the minified versions or the normal big list of separate files. The rest was just testing and building. Creating content is always tough for me. I want to sound casual which some people don't like. But it reflects me better so, whatever.

I ended up adding [animate.css](http://daneden.me/animate/ "daneden.me/animate/") too. I didn't create any fallbacks for no css animation support because they just won't show if you don't have support. I've used the library before and it is pretty great. I created a custom build because I am trying to keep my footprint small. In the end, even with all the images and javascript libs, I managed to get the page to load in [under 1 second](http://blog.kissmetrics.com/loading-time/?wide=1 "How Loading Time Affects Your Bottom Line") (at least on desktop...).

In conclusion, I am very happy with it. I have gotten a lot of positive feedback and suggestions. Everyday I make a few minor tweaks. Please [check it out](http://greynimbus.com/ "Grey Nimbus Website").
