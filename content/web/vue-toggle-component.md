+++
title = "Vue Toggle Component"
description = "A Vue component that is used to create simple switches, toggles, and show/hide experiences"
date = "2020-12-04"
category = "Web"
template = "post.html"
[taxonomies]
keywords = ["vue", "component", "toggle", "ui", "state", "switch"]
+++

Have you ever created a switch component that just shows and hides an element? How about an accordion? Or maybe a slider? If you distill down these components into their core offering, it is really just a simple state toggle that is either a `boolean` or a index/key value that is being used.

I created this component because it is something I use all the time. I wanted to share it with other people so I released it as a package. The state can be either a `boolean` or a `string`. This means you can use it to create experiences that are not just on/off and show/hide.

With a simple toggle, you can build almost any UI experience. Think about experiences like show/hide, accordions, nested menus, and even sliders, they mostly revolve around a single piece of state.

## Demo

Check out [the website for demos](https://james2doyle.github.io/vue-toggle).

## Installation

```bash
npm install -S vue-ui-toggle
```

```javascript
const Toggle = require('vue-ui-toggle'); // es5/node
// import Toggle from 'vue-ui-toggle'; // es6

Vue.component('toggle', Toggle);
```

```javascript
import Toggle from 'vue-ui-toggle';

export default {
  // ...
  components: {
    Toggle,
  },
  // ...
};
```

To learn more, check out the [website for the component](https://james2doyle.github.io/vue-toggle).
