+++
title = "Using slots in Vue js"
description = "If you are working with server-rendered apps, using Vue slots can help you create more reusable and flexible components"
date = "2020-05-18"
category = "Web"
template = "post.html"
[taxonomies]
keywords = ["vue", "slots", "server", "rendered", "reusable", "flexible", "components", "liquid", "blade"]
+++

If you are working with server-rendered apps (your view is compiled on the server down to HTML), and you are a [Vue.js](https://vuejs.org/) user, then you should definitely learn to use a [Vue feature called slots](https://vuejs.org/v2/guide/components-slots.html)! Not only will it allow you to make more reusable and flexible components, but you will also improve the rendering performance of your apps as well.

## Basic Example

Here is the example we will be refactoring later. It is a "profile list" which takes in an array of users from a prop, and then creates "profile cards" for each one. Finally, it adds a button in each card that emits an event with the user data when someone clicks on it.

```html
<!--
  This is the way you might typically build a component like this
 -->
<template>
  <div class="profile-list">
    <ul>
      <!-- loop over all the users and create cards for them -->
      <li class="profile-card" v-for="user in users" :key="user.id">
        <div class="profile-details">
          <img :src="user.profile_image" :alt="`${user.username}` profile image">
          <h4 v-text="user.username"></h4>
        </div>
        <!-- we have a button event here -->
        <button type="button" @click.prevent="buttonHandler(user)">View</button>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'ProfileList',
  props: {
    // we take in our list of users
    users: {
      type: Array,
      required: true,
    }
  },
  methods: {
    buttonHandler(user) {
      this.$emit('profile-change', user);
    }
  }
};
</script>
```

This is how you might use this component in your server-rendered templates:

```html
<!-- liquid or twig example -->
<profile-list v-bind:users="{{ users | json | escape }}"></profile-list>
<!-- plain php, short echo -->
<profile-list v-bind:users="<?= htmlspecialchars(json_encode($users), ENT_QUOTES, 'UTF-8') ?>"></profile-list>
<!-- laravel blade example, note single quotes -->
<profile-list v-bind:users='@json($users)'></profile-list>
```

As you can see the main approach here is to encode the users as JSON and pass them to the components `users` prop. This can create quite a mess of JSON if you look at the source of your pages if you have lots of components that do this.

## Why Use Slots?

As I mentioned, with slots you can create more reusable and flexible components and improve the rendering performance of your apps. I'll outline some of the details below.

#### On Reusability and Flexibility

Normally, you would send data to your Vue component using props, events, or a store. But using slots, you can essentially skip a rendering step and send your pre-compiled Vue into your Vue components template. This allows you to create components with _flexible templates_ instead of adding tons of props and lots of switches in the templates.

What I've typically seen in the past with larger apps, developers end up creating super-components with tons and tons of props. The reason this happens is usually because the components require flexibility. If you have lots of props, that is [probably a code smell](https://en.wikipedia.org/wiki/Code_smell). A way to reduce the number of props is to use events, new components, and of course, slots, to split things up!

#### On Passing Data

Since a slot is rendered on the server, you can also do some handy things with the template. Say you want to show or hide different content based on whether the user is authenticated. Well, this is super easy when working in server-rendered templates since the session is so easy to access. You might even have entire blocks of the UI that are not shown if the user is not logged in or is logged out.

This can help to dramatically reduce the work you need to do on your frontend to access data or building token-based APIs.

#### On Rendering

Since a slot is prerended HTML, your component ends up changing to really only encapsulating _the logic_ of your component and less "template" of your component. You'll notice that when using slots instead of props, your page with show the content inside the slot even before Vue has finished loading. This is great because it can help reduce [flashes of unstyled content](https://en.wikipedia.org/wiki/Flash_of_unstyled_content) that make your app look a little janky.

Although [browers will run your javascript](https://developers.google.com/search/docs/guides/javascript-seo-basics), a by-product of using slots is that you could improve the SEO of your site, as you are trying to fill the page with the most HTML possible.

Mostly slots are good for making more flexible components. The performance benefit is super helpful though.

## Refactored to Slots

```html
<!--
  All we need to do is cut that inside layout and replace it with a "default" slot
 -->
<template>
  <div class="profile-list">
    <ul>
      <!-- this is a default slot with a binding to the `buttonHandler` function -->
      <slot :buttonHandler="buttonHandler"></slot>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'ProfileList',
  methods: {
    buttonHandler(user) {
      this.$emit('profile-change', user);
    }
  }
};
</script>
```

You can now see how we completely remove our inner template and props and replace it with the `slot` tag. We don't need the props now since we won't be passing in any data. We are going to be passing in the entire block of rendered HTML on our server, and when Vue loads on the client side, the functionality will be hooked up!

This is how you might use this component in your server-rendered templates:

```html
<profile-list v-slot="slotProps">
  @foreach ($users as $user)
    <li class="profile-card" key="{{ $user.id }}">
      <div class="profile-details">
        <img src="{{ $user.profile_image }}" alt="{{ $user.username }} profile image">
        <h4>{{ $user.username }}</h4>
      </div>
      <!-- we have a button event here -->
      <button type="button" @click.prevent='slotProps.buttonHandler(@json($user))'>View</button>
    </li>
  @endforeach
</profile-list>
```

Now if you view the source of your page in your browser, you will see that the HTML looks more like Vue is _decorating_ your HTML instead of generating it.

#### Another Example

Let's create a modal with slots!

```html
<template>
  <div class="modal-wrapper">
    <button type="button" @click.prevent="toggle" v-text="openLabel"></button>
    <div class="modal-overlay" v-if="open">
      <div class="modal-header">
        <h3>
          <!-- here is a named slot, we can force content right into this spot as long as we use named slots -->
          <slot name="header"></slot>
        </h3>
      </div>
      <div class="modal-body">
        <slot name="body"></slot>
      </div>
      <div class="modal-footer">
        <button type="button" @click.prevent="toggle" v-text="closeLabel"></button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Modal",
  props: {
    openLabel: {
      type: String,
      required: false,
      default: "Open"
    },
    closeLabel: {
      type: String,
      required: false,
      default: "Close"
    }
  },
  data() {
    return {
      open: false
    };
  },
  methods: {
    toggle() {
      this.open = !this.open;
    }
  }
};
</script>
```

Here we have a component that has 2 slots! One for the header of the modal and another for the body. We are still using props though. We don't want to overwrite the main button that opens the modal, or the `modal-footer` content that includes our button and the handler.

Now we can use this component as follows:

```html
<!-- set our custom labels -->
<modal openLabel="View Details" closeLabel="Dismiss">
  <!-- pass in our title -->
  <template v-slot:header>Details</template>
  <!-- pass in our body content that will be displayed -->
  <template v-slot:body>
    <h3>This is my title</h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam ornare ipsum ligula, id pharetra neque lobortis nec. Mauris varius, felis eget interdum ultricies, libero nulla varius tortor, nec semper tortor leo id nisl. Fusce a est augue. In hac habitasse platea dictumst. Sed pretium egestas vestibulum. Nunc pellentesque aliquam justo, eu rutrum nunc vehicula ac. Nunc feugiat sed ipsum in dapibus. Quisque finibus, dolor at consequat.</p>
  </template>
</modal>
```

You can actually conditionally show slots as well. Let's add that:

```diff
@@ -2,7 +2,7 @@
   <div class="modal-wrapper">
     <button type="button" @click.prevent="toggle" v-text="openLabel"></button>
     <div class="modal-overlay" v-if="open">
-      <div class="modal-header">
+      <div class="modal-header" v-if="hasHeaderSlot">
         <h3>
           <!-- here is a named slot, we can force content right into this spot as long as we use named slots -->
           <slot name="header"></slot>
@@ -38,6 +38,11 @@
       open: false
     };
   },
+  computed: {
+    hasHeaderSlot() {
+      return !this.$slots["header"];
+    }
+  },
   methods: {
     toggle() {
       this.open = !this.open;
```

What we've done here is hide a slot (the `header` one) if the slot is not filled in. This allows us to use the `body` slot even more effectively! We can provide a full content replacement if we want. Nice!

#### Accordion Example

Here are a couple more example but done in the Codesandbox editor. They have code comments as well as some more organization:

**Accordion**

<iframe
   src="https://codesandbox.io/embed/slots-accordion-32c18?fontsize=14&hidenavigation=1&theme=dark"
   style="width:100%; height:500px; border:0; border-radius: 4px; overflow:hidden;"
   title="Slots - Accordion"
   allow="accelerometer; ambient-light-sensor; camera; encrypted-media; geolocation; gyroscope; hid; microphone; midi; payment; usb; vr"
   sandbox="allow-forms allow-modals allow-popups allow-presentation allow-same-origin allow-scripts"
 ></iframe>

**Image Picker**

<iframe
   src="https://codesandbox.io/embed/slots-image-picker-3yvlh?fontsize=14&hidenavigation=1&initialpath=%2Fsrc%2Fcomponents%2FImagePicker.vue&theme=dark"
   style="width:100%; height:500px; border:0; border-radius: 4px; overflow:hidden; margin-bottom: 1rem"
   title="Slots - Image Picker"
   allow="accelerometer; ambient-light-sensor; camera; encrypted-media; geolocation; gyroscope; hid; microphone; midi; payment; usb; vr"
   sandbox="allow-forms allow-modals allow-popups allow-presentation allow-same-origin allow-scripts"
 ></iframe>

## In Conclusion

So next time you find yourself making tons of props or duplicating component just because they have slightly different templates, just reach for slots!
