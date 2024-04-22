+++
title = "jQuery-doodal-js"
description = "jQuery-doodal-js"
date = "2013-09-09"
category = "Personal Project"
template = "post.html"
[taxonomies]
keywords = ["jquery", "plugin", "modal", "events", "trigger", "css3", "transitions", "animations", "alert", "confirm"]
+++

jQuery.doodal.js is a very simplistic modal plugin for jQuery. It has custom events, allows stacking, and is powered by CSS transitions

[See the demo](http://james2doyle.github.io/jquery.doodal.js/)

### Usage

Instatiate a new doodal.

    $('.doodal').doodal({
      type: 'modal',
      closeclass: '.doodal-close',
      trueclass: '.doodal-true',
      falseclass: '.doodal-false',
      showclass: 'showing'
    });


Those are all the default options so in this specific example I am not actually overwriting anything.

Now trigger an `open` to see it:

    $('#doodal1').trigger('open');

### Custom Events

* *open*: - when the modal starts to open
* *afteropen*: - after the animation is over and it is open
* *ontrue*: - for confirms yes button
* *onfalse*: - for confirms no button
* *close*: - when the close is clicked
* *afterclose*: - after the animation is over and it is hidden

You can also view the [project on Github](https://github.com/james2doyle/jquery.doodal.js).
