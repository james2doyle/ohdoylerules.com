---
Title: "Nuxt Firebase Starter"
Date: "2017-12-21"
Category: "Web"
Template: "post"
Description: "An example project that uses nuxt.js and Firebase for simple auth (social or email/pass) and account profiles"
Keywords: ["firebase", "nuxt", "vue", "auth", "serverless", "single page app", "spa"]
---

Over the past few weeks, I have been working on [a boilerplate/starting template for using the Nuxt.js framework with Firebase](https://github.com/james2doyle/nuxt-firebase-auth).

I plan to use this boilerplate for easily creating apps that require authentication, real-time feedback from the database (chats, threads, account balances, etc.), and proper modern support for the new PWA (progressive web app) conventions (service worker, offline, code-splitting, etc.) without having to worry too much about laying the ground work each time.

If you already know about Nuxt and Firebase, I suggest just checking out the project and playing around with it. By default, I have setup the Nuxt PWA module, social login support for Google and Github, and also setup a database convention called “accounts” where users manage their public profile inside the application.

If you are unfamiliar with the tools, keep reading!

---

### Nuxt

As you may be able to tell from this post and some of the other posts on this site, I am also a [Vue.js](https://vuejs.org/) fan. I have been using it since before version 1 was released.

About four months ago, I started using a relatively new framework created on top of Vue.js (and stolen from the [Next.js React project](https://github.com/zeit/next.js/)) called [Nuxt.js](https://nuxtjs.org/).

Essentially, Nuxt (and Next) setup conventions for routing pages, creating components, adding “stores” (flux, redux, etc.) based on a directory setup.

So, for example (these are taken from the Nuxt documentation), you have a structure as follows:

```
pages/
--| _slug/
-----| comments.vue
-----| index.vue
--| users/
-----| _id.vue
--| index.vue
```

And this will generate the following routes automatically:

```json
router: {
  routes: [
    {
      name: 'index',
      path: '/',
      component: 'pages/index.vue'
    },
    {
      name: 'users-id',
      path: '/users/:id?',
      component: 'pages/users/_id.vue'
    },
    {
      name: 'slug',
      path: '/:slug',
      component: 'pages/_slug/index.vue'
    },
    {
      name: 'slug-comments',
      path: '/:slug/comments',
      component: 'pages/_slug/comments.vue'
    }
  ]
}
```

You can then call `this.$route.params.slug`  (for slug-comments) or `this.$route.params.id` (for users-id) inside the components or pages that are on that route.

Pretty slick right?

So Nuxt is cool. It lets me quickly create an SPA (single-page app) without worrying about setting up an elaborate route object or worrying about how to organize my projects folders and logic. You just toss files in folders, and everything pretty much works.

Some people **hate this** but I find the structure liberating. I plan to use that additional time/energy to focus on building my app and not organizing configs or fiddling with route logic.

Now onto the Firebase portion of the project:

---

### Firebase

If you have some experience with [Firebase](https://firebase.google.com/) you probably know that it is an excellent service offering some nice features for dealing with "real-time" data as well as some other features like storage, push notifications, serverless functions, and authentication. The best part is that it is usually free for most small projects as they don't use enough resources to qualify for the paid tiers of service.

When I first started using Firebase, I didn't like it. The concept of `snapshots` and paths was confusing for someone coming from a key-value store or a more traditional relational database. It also lacks higher order sorting and querying. For example, you can query for ranges, but you can't query for `LIKE` or "matches/patterns”.

Queries like that can be limiting, but once you shift your mentality to something more like reducing and filtering, these issues disappear. You also need to be conscious about how you structure your database, *but I digress*.

As I got more comfortable with it, I began to see how powerful and easy it is to build things like chats, threads/commenting systems, atomic counters (“like” systems, ratings, etc.), and even used it to do browser push notifications. I am using it right now to build an API rate limiter!

---

### Combining Forces!

Using Nuxt and Firebase together has been easy. I was able to create a nice login flow (with support for Google and Github OAuth!) within about a day.

I also added support for this convention called “accounts”. When a new user signs up, we create an account on the Firebase database that is read-write for that user. This object contains their display name and profile image path.

Since we have a profile image (either pulled from the social login or assigned a default), I figured; *why not add support for uploading a new profile image to the Firebase storage?*

So I did! And now you can easily manage a mini-profile on the app without any extra configuration. It is there by default:

<div class="center">
  <img src="/images/nuxt-firebase-account-preview.gif" alt="nuxt firebase account preview">
  <p><small>Nuxt Firebase Account Preview</small></p>
</div>

As you can see from the animation above, super simple interface with live updating thanks to the bindings from our application store to the Firebase database!

Again, you can check out the project [at the repo on Github](https://github.com/james2doyle/nuxt-firebase-auth).
