---
Title: "Atom Monokai Dark"
Description: "Dark Monokai theme for the Github Atom editor"
Date: "2014-02-27"
Category: "Personal Project"
Template: "post"
Keywords: ["monokai", "theme", "dark", "github", "atom", "editor", "less", "css", "tmtheme", "font", "smoothing", "scrollbars"]
---

I made a [dark monokai](http://atom.io/packages/monokai-dark) syntax theme for [Atom](http://atom.io/).

Originally converted from [monokai](https://github.com/kevinsawicki/monokai) which in turn came from the [TextMate](http://www.monokai.nl/blog/wp-content/asdev/Monokai.tmTheme) theme using the [TextMate bundle converter](http://atom.io/docs/latest/converting-a-text-mate-theme).

<div class="center">
  <a href="/images/atom-monokai-dark.png" target="_blank"><img alt="atom monokai dark screenshot" src="/images/atom-monokai-dark.png" ></a>
</div>

I would also suggest editing your main stylesheet and adding the following CSS:

```css
/* really nice smooth fonts */
body {
  -webkit-font-smoothing: antialiased;
  text-rendering: optimizeLegibility;
  -moz-osx-font-smoothing: grayscale;
}

/* custom scrollbars */
.tree-view-resizer {
  ::-webkit-scrollbar {
    width: 0.5em;
    height: 0.5em;
  }

  ::-webkit-scrollbar-track {
    background-color: #303030;
  }

  ::-webkit-scrollbar-thumb {
    background-color: lighten(#303030, 15%);
  }
}

/* fix website scroll styling flash */
.tree-view-scroller {
  overflow: hidden;
  &:hover {
    overflow: auto;
  }
}
```

This adds some nicer smoothing and also adds some custom scrollbars to both panes. This gets rid of the ugly strange white ones. I would also suggest checking out [Source Code Pro](https://ohdoylerules.com/web/source-code-pro-sublime) for your font!

You can download the theme on [Atom](http://atom.io/packages/monokai-dark).
