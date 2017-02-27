/*
Title: How To Use Template Strings As Modules
Description: How to the new es6 template string literals to make reusable modules for templates/strings or HTML partials
Date: 2017-02-26
Category: Tricks
Template: post
Keywords: javascript, js, es6, template, string, literal, component, module
*/

I had a project the other day that needed to make some HTML strings based on some other data in my code.

This is a standard approach when you need to write to the `innerHTML` of an element, or if you want to populate a string before writing it to the DOM or some HTML attribute.

I was trying to find a nice way to split up my JS - that had a bunch of functions in it - and my template string which had a bunch of parts that needed to be filled/replaced while being looped over.

Another thing I wanted to accomplish is to be able to find the string in my code quickly. Just in case I needed to locate it and make some more changes to it in the future. Previously, the code was sitting is some variable or some function like `buildElementTemplate` or something. But that still seemed a little gross for me.

Well, I found a nice way to do all of these things. By sticking the string code in a module, and returning a function, I can pass the data in as I needed. Plus, it was easy to use `require` whenever I needed that template.

#### template.js

```js
module.exports = function(name, age) {
  return `Hello ${name}! You look good for ${age}!`;
}

// or as an object
module.exports = function(data) {
  return `Hello ${data.name}! You look good for ${data.age}!`;
}
```

#### application.js

```js
// myTemplate will be the compiled string
const myTemplate = require('./template')('Billy', 85);

// object style
const myTemplate = require('./template')({ name: 'Billy', age: 85});
```

There we go! A nice way to split up some template logic and some app logic. You could probably even return an object of methods that would compile different strings for your app - think translations or different personal messages for the user.
