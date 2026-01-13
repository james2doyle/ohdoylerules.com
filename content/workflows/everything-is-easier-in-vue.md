+++
title = "Everything is easier in Vue"
description = "When comparing Vue with React, I just find Vue so much easier"
date = "2026-01-12"
category = "Workflows"
template = "post.html"
[taxonomies]
keywords = ["react", "vue", "node", "next.js", "nuxt"]
+++

I’ve written quite a few sites using Next. In fact, at this point, I have written more sites in Next than with any other framework. I have a strong handle on the ups and downs of Next. I have even gone through the great class component purge of 2019. I was using Next when triangle company was called Zeit.

So to say I just haven’t used it right, or don’t know about _XYZ_ experience, I’m sure I do.

With all that experience under my belt, I still find working with Next to be like running a marathon with a weighted vest and a baby under my arm. I’m constantly battling with the system and worried that at any moment I’ll get a hydration error or just a wall of red text telling me there is some attribute that is not supported on an HTML component.

The thing is, I never really had these issues when working on Vue projects. I have worked on less Vue projects. So maybe I never hit these things. But when I did work on Vue projects, I was still in that marathon, but I felt like I was wearing fly-knit shoes, a camel back, and was running with the headwind.

I won’t belabour each point here, I’m literally just going to dump out all the things that I’ve enjoyed about using Vue.

Maybe some of you reading this will be compelled to taste the _sweet nectar_ of Vue some day...

### Here Are Some Of The Takeaways:

**For Vue**

- Incredible API stability since the release of Vue 3 (released Sep 18, 2020, still the working version) and no plans to break things
- Lots of basic code written in 2015 can quickly be made to work in Vue today, over 10 years later, especially with a little AI help
- The reactivity system uses [patch flags](https://vuejs.org/guide/extras/rendering-mechanism.html#patch-flags) that skip expensive checks during DOM diffing
- You can be sure that [code you expect to run once only runs once](https://twitter.com/icarusgkx/status/1722766405924200567) without special attention
- The versions of `Context` & `Providers` (`Provide` & `Inject`) work seamlessly across Server and Client components allowing for easy global state
- [Automatic fallthrough of attributes](https://vuejs.org/guide/components/attrs.html) (no `cleanProps` required, [or updates required to support new DOM features](https://github.com/facebook/react/issues/27479))
- Less hydration mismatch errors because of `v-show` which keeps the DOM structure identical and doesn’t require additional expressions
- The `KeepAlive` component allows you to keep state localized instead of moving it up the tree
- Using a named `slot` is much easier than using children in props or making render props
- Easier conditions with `v-if`, `v-else`, and `v-show` vs. conditional nesting
- Control flashing/shifting content with `v-cloak` which "unhides" elements when Vue is ready
- List rendering is much nicer with `v-for` (plus it can go directly on a Component instead of needing a wrapper fragment)
- No `useCallback` or `useMemo` jargon, instead there is `v-once` and `v-memo` (or even `KeepAlive`) but you rarely need them
- No need for `Fragment` because multiple root elements are allowed
- You often don’t need `Suspense` because you can leverage `v-if="loading"` instead of wrapping in the parent
- Built-in `Transition` component for animations
- You don't need to alias any of the HTML attributes (ex: `class` vs. `className`, `stroke-width` vs. `strokeWidth` (this changed in React 19))
- The [new devtools for Vue](https://devtools-next.vuejs.org/) are some of the best ones out there

**For Nuxt**

- Nuxt has [hooks for build, runtime, and the server](https://nuxt.com/docs/guide/going-further/hooks). This makes [building plugins/modules](https://nuxt.com/modules) much more capable and powerful
- The [deployment targets for Nuxt are more portable](https://nuxt.com/deploy) and you don't loose features choosing one over another (like with Next ISR)
- The [testing story is much more complete](https://nuxt.com/docs/getting-started/testing) in Nuxt with choices for runtime environment (jsdom, happy-dom), and test runner (vitest, jest). There are also built-in mocks and utilities/helpers
- Convenient `ClientOnly` component (that supports a server fallback)
- Convenient "server only" components using filenames (ex: `LoginButton.server.vue`)
- The [Nuxt devtools are phenomenal](https://devtools.nuxt.com/guide/features)
- [Dynamic imports](https://nuxt.com/docs/guide/directory-structure/components#dynamic-imports) are handled by just prefixing your component with `Lazy`
- The `Lazy` prefix handles the code-splitting and the loading state logic in one go, without additional imports (`next/dynamic`) or configuration

### Code Examples

**Code that just runs once**

{% codetoggle(title="React with useMemo and useCallback") %}
```tsx
import { useState, useMemo, useCallback } from 'react';

export default function ExpensiveList({ items }) {
  const [count, setCount] = useState(0);

  // We have to wrap this or it re-runs every time 'count' changes
  const processedItems = useMemo(() => {
    return items.map(item => ({ ...item, id: Math.random() }));
  }, [items]);

  // We have to wrap this or child components might re-render needlessly
  const handleAction = useCallback(() => {
    console.log("Action performed");
  }, []);

  return (
    <div>
      <button onClick={() => setCount(c => c + 1)}>Count: {count}</button>
      <ItemList items={processedItems} onAction={handleAction} />
    </div>
  );
}
```
{% end %}

{% codetoggle(title="Vue with simple computed") %}
```html
<script setup>
const props = defineProps(['items']);
const count = ref(0);

// No useMemo needed. Computed properties are cached and
// only re-evaluate if 'items' changes.
const processedItems = computed(() => {
  return props.items.map(item => ({ ...item, id: Math.random() }));
});

// No useCallback needed. This function is stable by default.
const handleAction = () => {
  console.log("Action performed");
};
</script>

<template>
  <button @click="count++">Count: {{ count }}</button>
  <ItemList :items="processedItems" @action="handleAction" />
</template>
```
{% end %}

**Keeping components "alive"**

{% codetoggle(title="React with state being kept alive") %}
```tsx
import React, { useState } from 'react';

// The Child Component
const SearchTab = ({ query, setQuery }) => {
  return (
    <div className="tab-content">
      <h2>Search Records</h2>
      <input
        value={query}
        onChange={(e) => setQuery(e.target.value)}
        placeholder="Search for something..."
      />
      <p>Results for: {query}</p>
    </div>
  );
};

const SettingsTab = () => <div>Settings Page</div>;

// The Parent Component
export default function App() {
  const [activeTab, setActiveTab] = useState('search');

  // WE ARE FORCED TO KEEP THIS HERE
  // so it doesn't die when the tab switches
  const [searchQuery, setSearchQuery] = useState('');

  return (
    <div className="container">
      <nav>
        <button onClick={() => setActiveTab('search')}>Search</button>
        <button onClick={() => setActiveTab('settings')}>Settings</button>
      </nav>

      {activeTab === 'search' ? (
        <SearchTab query={searchQuery} setQuery={setSearchQuery} />
      ) : (
        <SettingsTab />
      )}
    </div>
  );
}
```
{% end %}

{% codetoggle(title="Vue with KeepAlive") %}
```html
<script setup>
import { ref } from 'vue';
import SearchTab from './SearchTab.vue';
import SettingsTab from './SettingsTab.vue';

const activeTab = ref('search');
</script>

<template>
  <div class="container">
    <nav>
      <button @click="activeTab = 'search'">Search</button>
      <button @click="activeTab = 'settings'">Settings</button>
    </nav>

    <KeepAlive>
      <!-- no props here to worry about, mount and unmount all you want and the state will remain -->
      <SearchTab v-if="activeTab === 'search'" />
      <SettingsTab v-else />
    </KeepAlive>
  </div>
</template>
```
```html
<script setup>
import { ref } from 'vue';
// State stays localized and will be brought back when this component is remounted
const query = ref('');
</script>

<template>
  <div class="tab-content">
    <h2>Search Records</h2>
    <input v-model="query" placeholder="Search for something..." />
    <p>Results for: {{ query }}</p>
  </div>
</template>
```
{% end %}

**Named slots vs render functions**

{% codetoggle(title="React with render props") %}
```tsx
<Layout
  header={<h1>My Page</h1>}
  footer={<button>Save</button>}
>
  <p>Main content (children) that comes after the header and footer???</p>
</Layout>
```
{% end %}

{% codetoggle(title="Vue with named slots") %}
```html
<BaseLayout>
  <!-- #slotname targets a slot -->
  <template #header>
    <h1>My Page</h1>
  </template>

  <p>Main content (default slot) that is in the order it will be rendered in!</p>

  <template #footer>
    <button>Save</button>
  </template>
</BaseLayout>
```
{% end %}

**Component lazy loading**

{% codetoggle(title="React lazy loading with next/dynamic") %}
```tsx
import dynamic from 'next/dynamic';

// Manually define the dynamic import
const HeavyChart = dynamic(() => import('@components/HeavyChart'), {
  loading: () => <p>Loading chart...</p>,
  ssr: false // disable SSR if it's a browser-only library
});

export default function Dashboard() {
  return (
    <div>
      <h1>Stats</h1>
      <HeavyChart />
    </div>
  );
}
```
{% end %}

{% codetoggle(title="Vue with Lazy prefix") %}
```html
<!-- no scripts or imports required -->
<template>
  <div>
    <h1>Stats</h1>
    <!-- original name "HeavyChart" -->
    <LazyHeavyChart />
  </div>
</template>
```
{% end %}

**Handling classes**

{% codetoggle(title="React with conditional classes") %}
```tsx
export default function StatusMessage({ isActive, hasError }) {
  // Manual string building or complex ternaries
  const classes = [
    'base-style',
    isActive ? 'is-active' : '',
    hasError ? 'is-error' : ''
  ].join(' ').trim();

  return (
    <div className={classes}>
      Status Message
    </div>
  );
}
```
{% end %}

{% codetoggle(title="Vue built-in class handling") %}
```html
<script setup>
// Props are defined clearly with no extra logic needed to "massage" them
const props = defineProps({
  isActive: Boolean,
  hasError: Boolean
})
</script>

<template>
  <div :class="['base-style', { 'is-active': isActive, 'is-error': hasError }]">
    Status Message
  </div>
</template>
```
{% end %}

### Some Downsides

* Working with TypeScript can be odd. There are some weird quirks using it. Most are well documented and can be solved with snippets or linting
* Nuxt auto imports are cool but the editor integrations (the LSP) often need to be restarted in order to pick up the changes in imports
* Nuxt auto imports can also be tricky because your component Types need to be imported but not modules themselves
* Nuxt 3rd party components always need to be imported unless added to auto imports which just ends up feeling less slick

*Auto imports can be turned off or just told to include everything.*

### Coming From React

Conventions in React don’t translate fully to Vue, in that large blocks of code before your template are usually not required. The templating in Vue is much more expressive so you don’t need that huge JS block setting up all your state and hooks.

You have no "returns" in Vue, so you end up moving that logic to the template. You can use "if-else" to choose which component to render, or using the built-in `Component` tag, to select one dynamically. This can be really nice when you have a component that you want to set as a specific element based on it’s props. Think the `Button` component that can be an a tag (`a`, `input[type=submit]`) or a literal `type=button`.

Classes are much easier to handle in Vue, so you don’t need the big setup in the front that massages all the classes. You can do this, but it generally isn’t needed. Basically, [clsx](https://github.com/lukeed/clsx) is built-in. You can pass objects to the `class` prop which eliminates ternaries and localizes code to where it is used.

With better conditionals, your templates are immediately more understandable at a glance. It is clear in the first prop on your component if it will render or not give the convention of putting directives like `v-if` first.

The `slot` concept is just so much nicer than `props.children` and render props. Especially if you have multiple places you want to place those children.

Using `v-show` can help reduce hydration errors. Given you are still rendering the elements in the output, when the client calls kick in, then the client code takes over. This can be done in React, but you would have to make it a client component as well as use a `className` to toggle the visibility like `v-show` would.

There is almost never a reason to even think about doing any memoization in Vue. It just doesn’t come up. One of the benefits of having a compiler. Because of the way Vue renders, you don't have to optimize for immediate mode (full rerenders) in the same way you do in React.

### The Vue Ecosystem

It may look on the surface like Vue has a smaller ecosystem, but I think that is partially because Vue has things included that you don't need a dependency for.

- No need for `clsx` because Vue `:class` supports objects
- No need for a dedicated animation library, because `class` and `transition` are capable features that are already included
- You don't need `cleanProps` because of support for attribute fallthrough
- You don't need anything extra to do scoped styles, you just use the style tag
- You don’t need to wait for a release to support new DOM properties like `popover`
