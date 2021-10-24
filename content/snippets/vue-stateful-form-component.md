---
Title: "Vue stateful form component"
Description: "Create a Vue form that escalates all events to the top level and supports v-model"
Date: "2021-10-24"
Category: "Snippets"
Template: "post"
Keywords: ["vue", "state", "form", "render", "component", "v-model", "event"]
---

Recently, I needed to create a app that could recreate a form from static JSON and then fill it with values from another source. This was pretty difficult as storing a form in JSON is very hard. You can't add handlers or events given you only can store string, numbers, booleans, and arrays. No functions.

I ended up coming up with [a component that uses a render function in order to recreate the form stored in JSON](https://james2doyle.github.io/vue-stateful-form/).

<div class="center">
  <a href="/images/vue-stateful-form-demo.gif" target="_blank" >
    <img src="/images/vue-stateful-form-demo.gif" width="720" />
  </a>
</div>

#### Features

* <label><input type="checkbox" checked readonly />&nbsp;&nbsp;uses event delegation from the top level `form` element</label>
* <label><input type="checkbox" checked readonly />&nbsp;&nbsp;2 way binding with proper `v-model` support</label>
* <label><input type="checkbox" checked readonly />&nbsp;&nbsp;unstyled but includes lots of classes to target</label>
* <label><input type="checkbox" checked readonly />&nbsp;&nbsp;built-in debounce function</label>
* <label><input type="checkbox" checked readonly />&nbsp;&nbsp;still allows `submit` handler</label>
* <label><input type="checkbox" checked readonly />&nbsp;&nbsp;encodes "multiple" inputs (`select[multiple]`, `radio`, `checkbox`)</label>
* <label><input type="checkbox" checked readonly />&nbsp;&nbsp;no hacky "mounted" calls</label>
* <label><input type="checkbox" checked readonly />&nbsp;&nbsp;supports most input elements (no `file`/`image` support)</label>
* <label><input type="checkbox" checked readonly />&nbsp;&nbsp;sets `ref` for each input automatically</label>
* <label><input type="checkbox" checked readonly />&nbsp;&nbsp;supports custom components and passing props/attrs</label>

I made a whole site on this and posted the code to NPM. It currently only works in Vue 2. So keep that in mind. You can [find the source code and instructions here](https://james2doyle.github.io/vue-stateful-form/).
