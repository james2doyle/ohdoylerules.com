+++
title = "Detect Animation Events in Javascript"
description = "Detect Animation Events in Javascript"
date = "2013-05-31"
category = "Snippets"
template = "post.html"
[taxonomies]
keywords = ["detect", "animation", "events", "javascript"]
+++

Whenever I am doing animations that have javascript and CSS, most of the time, I want an callback to fire in javascript when the animations are complete. I have used this event for modals and little UI plugins. Normally, I would have a start event(click or touch) that just adds a class that has a CSS animation attached to it. Lets say we have a class called 'on'.

```css
.modal.on {
  animation: showModal 1s ease;
}
@keyframes showModal {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
```

So now in javascript I might have a button click that adds 'on' to my modal. In my javascript I would have a function to detect different animation events(start, iterate and end). Here is the code that I modified from a [SitePoint Article](http://www.sitepoint.com/css3-animation-javascript-event-handlers/ "Sitepoint") that was posting about the same topic.

```javascript
var pfx = ["webkit", "moz", "MS", "o", ""];
function doAnim(element, animClass, type, callback) {
  var p = 0, l = pfx.length;
  function removeAndCall(){
    this.removeEventListener(pfx[p]+type, arguments.callee,false);
    callback();
  }
  for (; p < l; p++) {
    if (!pfx[p]) {
      type = type.toLowerCase();
    }
    element.classList.add(animClass);
    element.addEventListener(pfx[p]+type, removeAndCall, false);
  }
}
// doAnim(elem, 'show', 'AnimationEnd', function(){
//   this function will fire when the animation is finished
//   elem.classList.remove('show');
// });
```

In this particular example I would do:

```javascript
doAnim(myModalElement, 'on', 'AnimationEnd', function(){
  // this function will fire when the animation is finished
  myModalElement.classList.remove('on');
});
```

So now I have a function that will add a class to an element and then fire my callback when the animation is complete.

