+++
title = "Vue Omnibar Component"
description = "A Vue component that is used to create modal popups that emulate omnibar, command palette, open anywhere, or other search functions/features"
date = "2020-12-05"
category = "Web"
template = "post.html"
[taxonomies]
keywords = ["vue", "component", "modal", "omnibar", "command palette", "open anywhere"]
+++

I'm working on a project right now that requires us to have a search modal. The feature is actually inspired by the ["Quick Search" experience in Notion](https://www.notion.so/Searching-with-Quick-Find-af945b6e69b64437afba2d143e4b546f). I looked around for a component that was already created that would do this for me. I couldn't find one, so I wrote my own!

This component allows you to create modal popups that emulate omnibar, command palette, open anywhere, or other "search and act" functions/features. It is really simple and uses slots to make it easier to customize. It comes with some basic styling so you don't have to fight with it too much.

One of the cool things about the search box in the modal is that it is using [Fuse.js](https://fusejs.io/) for the filtering part. This means you can search complex objects really easy. You can even rank-order properties that are being searched! Pretty slick, right?

## Demo

<div class="center">
  <a href="https://james2doyle.github.io/vue-omnibar" target="_blank" title="demo of the omnibar modal"><img src="https://james2doyle.github.io/vue-omnibar/demo.gif" alt="demo of the omnibar modal"></a>
</div>

Check out the [website for the component](https://james2doyle.github.io/vue-omnibar) in order to view the demo.

## Features

- [x] built-in filtering using [Fuse.js](https://fusejs.io/)
- [x] custom key combo support
- [x] listens for `esc` key
- [x] bring your own styling (basic styles included)
- [x] arrow key support
- [x] uses slots for best flexibility
- [x] "off-click" closes the modal

## Installation

```bash
npm install vue-omnibar
```

### Global Usage

```js
import Vue from 'vue';
import Omnibar from 'vue-omnibar';

Vue.component('omnibar', Omnibar);
```

### In Single File Components

```js
import Omnibar from 'vue-omnibar';

export default {
  // ...
  components: {
    Omnibar,
  },
  // ...
};
```

To learn more, check out the [website for the component](https://james2doyle.github.io/vue-omnibar).
