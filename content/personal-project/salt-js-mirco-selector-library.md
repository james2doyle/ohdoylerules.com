/*
Title: Salt.js micro selector library
Date: 2013-05-13
Category: Personal Project,Snippets,Web
Template: post
Keywords: 
*/

I made a tiny dom selector library called
[Salt.js](https://github.com/james2doyle/saltjs "Salt.js Github"). It
uses a regular expression to map different queries you pass through it
to their native get functions. The reason I don't just use
querSelectorAll for everything is because it is slower than the native
get commands\*. [See this jsperf
test](http://jsperf.com/getelementbyid-vs-queryselector/11 "jsperf mapping test").
Yes, I see that the mapping is slower for newer versions of Chrome. But,
almost every other browser and device is slower using querySelectorAll
over the mapping method. Also keep in mind the regex used in that
example is much more complicated than mine. Here are some examples of
how you would use the library:

~~~~ {.prettyprint .lang-js title="salt.js examples"}
// get by id
$('#iddiv');
// get by class name
$('.classdiv');
// get by element name
$('@namediv');
// get by element tag name
$('=div');
// get element using querySelectorAll
$('*div div.inside');
// getAttribute of name
$('#iddiv').getAttribute('name');
// getAttribute of name from nodelist
$('.classdiv')[0].getAttribute('name');
~~~~

[Check out the library on
Github](https://github.com/james2doyle/saltjs "Salt.js on Github").

### Update

Looks like there are a bunch of better ways to make this smaller! I've
updated the github to reflect the new libraries. I have also added a
[jsPerf test](http://jsperf.com/micro-selector-libraries "jsPerf tests")
