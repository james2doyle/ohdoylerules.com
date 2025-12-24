+++
title = "Alpine.js Playground"
description = "I created an Alpine.js playground for live coding and building small components"
date = "2025-12-24"
category = "Projects"
template = "post.html"
[taxonomies]
keywords = ["alpine.js", "javascript", "tailwind", "playground", "html"]
+++

I created a live coding playground for [Alpine.js](https://alpinejs.dev/) with Tailwind CSS support.

{{ image(title="alpinejs playground screenshot", src="/images/alpinejs-playground.png", style="max-width:95%") }}

**[View the live site](https://james2doyle.github.io/alpinejs-playground/)**

### Features

- **Live Preview**: See your Alpine.js code render instantly as you type
- **Code Sharing**: Generate shareable URLs with compressed code
- **Resizable Panes**: Adjust the editor/preview split to your preference
- **Tailwind CSS Support**: Full Tailwind CSS utility classes available
- **One-Click Actions**: Copy code, reset to default, and save with URL updates

I wanted this for a while and didn’t see any existing playgrounds out there for this. Sometimes you just want to develop a small component in isolation with "live reload" without having to set much up in your project. This small site can help with that.

I also wanted to be able to quickly share or save the state of the editor like they have on the Tailwind play site. Since this editor only deals with a single pane and HTML input, it just compresses the HTML input and stores it in the URL.

Eventually I can put in a nicer editor and I think it would also be handy to be able to enable all the default plugins so that you can make demos with those too.

You can find the source code here: https://github.com/james2doyle/alpinejs-playground