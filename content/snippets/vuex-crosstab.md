---
Title: "Vuex Crosstab Plugin"
Description: "CrossTab syncs Vuex state across same-origin tabs. Converted from storeon crosstab"
Date: "2020-09-03"
Category: "Snippets"
Template: "post"
Keywords: ["vue", "vuex", "plugin", "store", "sync", "tab", "window", "event", "bus", "localstorage", "storage"]
---

Did you know that you can use localstorage as an event bus between same-origin tabs?

Yep! Local storage is shared across same-origin domains. Which means you can share information between tabs on the same domain. Other cool thing is that the `storage` event that is fired on the `window` when localstorage changes, it _only fired on non-focused tabs_. This means you can write an event bus to sync the tabs you don't have focused with the one you do! Neat.

When browsing around GitHub, like I do, I found this project called [storeon](https://github.com/storeon/storeon). It is a framework agnostic state manager. It's aim is to be small and flexible and provide additional functionality through plugins. One such plugin is called [crosstab](https://github.com/storeon/crosstab).

I am a Vue.js user who likes VueX. So I wanted to recreate this plugin in VueX. VueX also provides a [plugin API](https://vuex.vuejs.org/guide/plugins.html) so you can write plugins as well. So I wrote the plugin for VueX, published it to [npm](https://www.npmjs.com/package/vuex-crosstab), and posted the source on [GitHub](https://github.com/james2doyle/vuex-crosstab).

Here is the demo of the plugin working:

<div class="center">
  <a href="/images/vuex-crosstab.gif" target="_blank" title="vuex crosstab demo"><img alt="laravel multi-lingual site demo" src="/images/vuex-crosstab.gif"></a>
</div>

You can use the plugin like so:

```js
// es6
// import CrossTab from 'vuex-crosstab';
// commonjs
const CrossTab = require('vuex-crosstab');

export default new Vuex.Store({
  // ...
  plugins: [
    // your other plugins...
    CrossTab({ recover: true })
  ],
  // ...
});
```

There is a simple config object you can pass to control some things like the "recovery" which will check the localstorage to see if there was state already in there. You can [read more on the Github page](https://github.com/james2doyle/vuex-crosstab#options).
