/*
Title: Detect Animation Events in Javascript
Date: 2013-05-31
Category: Snippets,Web
Template: post
Keywords: 
*/

Whenever I am doing animations that have javascript and CSS, most of the
time, I want an callback to fire in javascript when the animations are
complete. I have used this event for modals and little UI plugins.
Normally, I would have a start event(click or touch) that just adds a
class that has a CSS animation attached to it. Lets say we have a class
called 'on'.

~~~~ {.prettyprint .lang-css title="Example modal animation class"}
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
~~~~

So now in javascript I might have a button click that adds 'on' to my
modal. In my javascript I would have a function to detect different
animation events(start, iterate and end). Here is the code that I
modified from a [SitePoint
Article](http://www.sitepoint.com/css3-animation-javascript-event-handlers/ "Sitepoint")
that was posting about the same topic. [gist id="5673923"] In this
particular example I would do:

~~~~ {.prettyprint .lang-js title="Javascript for modal callback"}
doAnim(myModalElement, 'on', 'AnimationEnd', function(){
  // this function will fire when the animation is finished
  myModalElement.classList.remove('on');
});
~~~~

So now I have a function that will add a class to an element and then
fire my callback when the animation is complete.
