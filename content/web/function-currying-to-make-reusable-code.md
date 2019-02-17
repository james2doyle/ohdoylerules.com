---
Title: "Function Currying To Make Reusable Code"
Date: "2019-02-17"
Category: "Web"
Template: "post"
Description: "Function currying. If you haven't heard of it before, let me introduce you to this magical pattern that can help reduce duplicate code and improve readability"
Keywords: ["javascript", "currying", "event", "handlers", "react", "state"]
---

Function currying. If you haven't heard of it before, let me introduce you to this magical pattern that can help reduce duplicate code and improve readability.

Currying is just a fancy way to describe a *function that returns a function*. Pretty simple right? I mean this literally. There are no gotchas here. A *function that returns a function* is a curried function. Enough words though. I will show you some common code samples and then refactor them to use curried functions.

### Cleaning up prototype chains

I'm sure everyone has written code like this before:

```js
const items = [1, 2, 3, 4];
items.map((num) => `item-${num}`);
// returns ['item-1', 'item-2', 'item-3', 'item-4']
items.map((num) => `key-${num}`);
// returns ['key-1', 'key-2', 'key-3', 'key-4']
```

You can see that this function is very specific to the area it's being used. We support a variable number of items via our array and they don't even have to be numbers. We can build new results with either numbers or strings. That's great. But we do have repeated code that essentially does the same thing. The only difference is the string we are prepending.

Here is an example using currying to *D.R.Y* (don't repeat yourself) this up:

```js
const labelMaker = (label) => {
  return (num) => `${label}-${num}`;
};

const items = [1, 2, 3, 4];
items.map(labelMaker('item'));
// returns ['item-1', 'item-2', 'item-3', 'item-4']
items.map(labelMaker('key'));
// returns ['key-1', 'key-2', 'key-3', 'key-4']
```

When refactoring to curried functions, the thing to keep in mind is *what is unique about each function and what is the same?*

Things that are unique should be the arguments to the first function call. The things that are the same should be the second function that is called. At least when using this pattern of currying.

We can actually go a step further again and make this function very flexible:

```js
const labelMaker = (label, splitter = '-') => {
  return (num) => `${label}${splitter}${num}`;
};

const items = [1, 2, 3, 4];
items.map(labelMaker('item'));
// returns ['item-1', 'item-2', 'item-3', 'item-4']
items.map(labelMaker('key', '_'));
// returns ['key_1', 'key_2', 'key_3', 'key_4']
```

Now that you have seen this in action under a simple example. I think it is useful to chat about using currying to create "constructors".

### Using currying to create "constructors"

Take this example:

```js
const logger = (level = 'info') => {
  return console[level].bind(console);
};
```

In this example, we have a function called `logger` which returns an instance of `console` but bound to whichever `level` you want. Here is how we might use it:

```js
const logger = (level = 'info') => {
  return console[level].bind(console);
};

const infoLogger = logger();
const errorLogger = logger('error');
const traceLogger = logger('trace');
```

See what I mean about creating "constructors"? We can use the first function almost like a constructor that will return a function that will be called with that first set of arguments applied in some way. Pretty useful right? Instead of making classes or global variables, we can make curried functions that can store those values for use in the returned function.

### Currying event handlers

Given the "constructor" nature of function currying, I typically use these for event handlers. I think of it like tagging. I'll show you why here:

```js
/* <input type="text" id="username"> */
const handleInput = (name) => {
  return ({ target: { value } }) => {
    console.log(`${name} input was set to "${value}"`);
  };
};

const username = document.getElementById('username');
username.addEventListener('input', handleInput('username'));
```

In this example, we are adding an event handler to an input and basically giving it a label of "username". Not too special at the moment. If we wanted just the name that would be easy. So let's make this function handle more input types:

```js
/*
<input type="text" id="username"/>
<input type="checkbox" id="accept" value="1" />
<select id="age">
  <option value="below 18">below 18</option>
  <option value="above 18">above 18</option>
</select>
 */
const handleInput = (name) => {
  return ({ target: { type, value, checked } }) => {
    console.log(`${name} input was set to "${type !== 'checkbox' ? value : checked}"`);
  };
};

const username = document.getElementById('username');
username.addEventListener('input', handleInput('username'));
const accept = document.getElementById('accept');
accept.addEventListener('change', handleInput('accept'));
const age = document.getElementById('age');
age.addEventListener('change', handleInput('age'));
```

Ok, so now we see 3 different input types, all using the same function but the output is "tagged" via that first function's argument.

We can actually clean this up more though:

```js
/*
<input type="text" id="username"/>
<input type="checkbox" id="accept" value="1" />
<select id="age">
  <option value="below 18">below 18</option>
  <option value="above 18">above 18</option>
</select>
 */
const handleInput = (name, prop = 'value') => {
  return ({ target }) => {
    console.log(`${name} input was set to "${target[prop]}"`);
  };
};

const username = document.getElementById('username');
username.addEventListener('input', handleInput('username'));
const accept = document.getElementById('accept');
accept.addEventListener('change', handleInput('accept', 'checked'));
const age = document.getElementById('age');
age.addEventListener('change', handleInput('age'));
```

Now you can see our function handles the one special exception on the "checkbox" via an optional argument instead of a ternary. **Slick!**

This becomes a really nice pattern when working in React or other virtual DOMs since your function can really only access the data directly available to it. Here is the same thing wrapped up to use just a single class method to manage the state for 3 different inputs:

```js
import React from 'react';
import ReactDOM from 'react-dom';

class Form extends React.Component {
  state = {
    username: null,
    accept: false,
    age: 'below 18',
  }

  handleInput = (name, prop = 'value') => {
    return ({ target }) => {
      this.setState({
        [name]: target[prop]
      });
    }
  }

  render() {
    return (<div className='form'>
      <input type='text' onInput={this.handleInput('username')} />
      <input type='checkbox' onChange={this.handleInput('accept', 'checked')} />
      <select onChange={this.handleInput('age')}>
        <option value='below 18'>below 18</option>
        <option value='above 18'>above 18</option>
      </select>
      {/* shows the state in the document body - not required */}
      <pre><code>{JSON.stringify(this.state)}</code></pre>
    </div>);
  }
}

ReactDOM.render(<Form />, document.body);
```

*[View this example on codesandbox.](https://6nv8q86yk3.codesandbox.io/)*

This is where I think curried functions really shine. This is a very compact way to support a lot of different form items but they can all use the same function even though they may all be unique items. Obviously, you can use this for any type of event handlers. Hopefully you can see the flexibility here and the potential to make simpler code that is more usable.

### In summation

So next time you see some of these patterns pop up in your code (or some smells with global variables and repeated code) maybe reach for a curried function instead. *Delicious*.
