+++
title = "Autocomplete TailwindCSS In Custom Attributes/Strings"
description = "Use tailwindcss autocomplete classes and logic inside non-default attributes or strings"
date = "2022-06-06"
category = "Snippets"
template = "post.html"
[taxonomies]
keywords = ["tailwind", "css", "class", "classname", "tw", "twin.macro", "twinmacro", "template", "literal", "react", "vue", "attributes", "props"]
+++

If you are using [TailwindCSS](https://tailwindcss.com/) along with [their extension for completing tailwind classes](https://github.com/tailwindlabs/tailwindcss-intellisense) but you are using styled components, custom attributes/props for class names, or packages like [twin.macro](https://github.com/ben-rogerson/twin.macro), then autocomplete for class names might not work properly for you.

There is a setting inside the language server for tailwind that let's you provide a custom regex for when/where you want the tailwind autocomplete to work. By default it works inside `class` and `className`. But what if we want to change that? For, say, a tagged template literal?

You can use the following config for various types/styles of solutions for writing tailwind classes:

```json
"tailwindCSS.experimental.classRegex": [
  ["classnames\\(([^)]*)\\)", "'([^']*)'"],
  "class=\"([^\"]*)", // <div class="..." />
  "tw`([^`]*)", // tw`...`
  "tw=\"([^\"]*)", // <div tw="..." />
  "tw={\"([^\"}]*)", // <div tw={"..."} />
  "tw\\.\\w+`([^`]*)", // tw.xxx`...`
  "tw\\(.*?\\)`([^`]*)" // tw(Component)`...`
],
```

The above rules are what I am using with React and the twin.macro package. I can complete under various `tw` props or tagged templates which is exactly what I need for the project I'm on.

If you would like to see some of the other use cases for this setting, [you can browse the issues on Github](https://github.com/tailwindlabs/tailwindcss-intellisense/search?q=classRegex&type=issues). As you can see, it is a common feature that is reached for when you need to customize the location of the autocomplete trigger.
