+++
title = "Angular (v1.x) Through iFrame"
date = "2018-04-29"
category = "Web"
template = "post.html"
description = "How to use angular.js (v1.x) through an iframe when the iframe URL is dynamically swapped"
[taxonomies]
keywords = ["angular", "iframe", "sanitize", "contentWindow"]
+++

**Note**: This is an older project/repo that uses the previous version of Angular (v1.x) so keep that in mind.

I was working on a project that required users to generate content that had dynamic templates. The goal was to make the entire thing was just a javascript client application and not have to worry about adding a server for handling the updates. Even better, if we could avoid AJAX requests for each keypress to update the content of the template, that would be even better.

This was a perfect problem for an iframe to solve as we had remote HTML files that would be loaded into an editor and then you can edit the data insde them. When you were finished, you could generate a PDF from the content inside the iframe. It was pretty sweet and worked really well.

While writing the app, I had to find a way to get data from the parent window into the iframe. If you didn't know this, you can actually call `window` functions on an iframe you own (one that has `sandbox="allow-same-origin allow-scripts"` set on the tag and is the same domain) which will allow you to send data down to the iframe and have it run events, change code, or in my case, trigger `$scope` updates.

<div class="center">
  <img src="/images/angular-iframe.gif" alt="angular through iframe demo">
  <p><small>Angular Through iFrame Preview</small></p>
</div>

All we need to do is access the `contentWindow` (on our parent iframe) property and call functions that exist in the `window` of the child iframe.

This looks like the following:

**Parent page:**

```js
// somewhere in the parent main js file probably another controller
var iframe = document.getElementById('iframe');
iframe.contentWindow.update(dataFromParent);
```

**Child iframe page:**

```js
// inside the iframe controller
window.update = function(dataFromParent) {
  $scope.$apply(function() {
    // replace the scope with an object from the parent
    $scope = dataFromParent;
  });
};
```

As you can see, this is incredibly simple and allows for *write-only* control of an iframe.

What I did to integrate with Angular was use that window function inside the iframes controller to call `$scope.$apply` with the new data.

You can [see a live demo](https://james2doyle.github.io/angular-through-iframe) of the technique or [visit the demo project on Github](https://github.com/james2doyle/angular-through-iframe).
