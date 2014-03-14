/*
Title: Simple Binder
Date: 2014-03-14
Category: Personal Project,Web
Template: post
Description: simplebinder is a zero dependency one-way databinder for javascript
Keywords: data, binding, javascript, jquery, input, select, onchange, oninput, dependency
*/

The other day I was working on a custom form that had a lot of javascript interaction. It got a little too far before I realized I should have been using something like [Angular.js](http://angularjs.org/). I was looking for a simple one-way databinding library, but I couldn't find anything that wasn't overkill.

So I created [Simple Binder](http://james2doyle.github.io/simplebinder/). Simple Binder is a zero dependency one-way databinder for javascript. The great thing about it is that, not only is it very simple, but it is super small as well. No dependencies is also nice.

Using the lib is pretty straightforward. Here is the markup required for a simplebinder element:

```
<p data-model="number">number</p>
<input type="number" data-controller="number" />
```

As you can see, you must have a *data-model* and a *data-controller* set on your items. Models are like the destination for the data-controllers value.

This would be the javascript for this element:

```
var sb = SimpleBinder('number', function(input, model) {
  console.log(input.value);
});
```

Now the `sb` variable it a simplebinder object. It has a few nice methods that you can use now:

Destroy a simplebinder element.

```
sb.destroy();
```

Add a new controller to a simplebinder element.

```
sb.addController('new-controller-name');
```

Add a new model to a simplebinder element.

```
sb.addModel('new-model-name');
```

See all models on a simplebinder element. Returns an arrary of strings with querySelectorAll queries.

```
sb.models;
```

See all controllers on a simplebinder element. Returns an arrary of strings with querySelectorAll queries.

```
sb.controllers;
```

Custom events and attributes

```
var sb = SimpleBinder('modelname', {
  watch: 'value', // what controller attribute are we watching?
  change: 'className' // the attribute to change on the model, default = textContent
}, function(input, model) {
  console.log(input.value);
});
```

That's it. I will be adding the ability to remove a Model or Controller in the future. I tested this on a variety of devices. This library uses `querySelectorAll`, so if you don't have that... well you're fucked.

Check out the [source on github](https://github.com/james2doyle/simplebinder).
