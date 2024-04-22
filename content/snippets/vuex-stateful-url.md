+++
title = "Vuex Stateful URL Plugin"
description = "StatefulURL is a Vuex plugin that can read and write the state from a query string"
date = "2020-09-03"
category = "Snippets"
template = "post.html"
[taxonomies]
keywords = ["vue", "vuex", "plugin", "store", "sync", "url", "query", "string"]
+++

Have you ever used permalinks on a site? These links store the state of the page in the URL. They can be super useful for simple single-page-apps (SPAs) for bringing users back to where they were when they left the page or just adding the ability to share that page state with someone else without requiring logins or anything like that.

I'm a Vue.js user who likes VueX. So I wanted to create a plugin in VueX that would send the state of the store into the URL.

VueX provides a [plugin API](https://vuex.vuejs.org/guide/plugins.html) so you can write plugins that can extend the basic functionality. So I wrote the plugin for VueX that would sync the store to the URL.

I used a great package called [json-url](https://github.com/masotime/json-url) which allows you to encode/compress JSON objects in a URL-safe way.

It is now published to [npm](https://www.npmjs.com/package/vuex-stateful-url) and the source is on [GitHub](https://github.com/james2doyle/vuex-stateful-url).

Here is the demo of the plugin working:

<div class="center">
  <a href="/images/vuex-stateful-url.gif" target="_blank" title="vuex stateful url demo"><img alt="laravel multi-lingual site demo" src="/images/vuex-stateful-url.gif"></a>
</div>

You can use the plugin like so:

```js
// es6
// import StatefulURL from 'vuex-stateful-url';
// commonjs
const StatefulURL = require('vuex-stateful-url');

export default new Vuex.Store({
  // ...
  plugins: [
    // your other plugins...
    StatefulURL()
  ],
  // ...
});
```

You can [read more on the Github page](https://github.com/james2doyle/vuex-crosstab).
