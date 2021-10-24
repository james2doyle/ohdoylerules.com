---
Title: "Lodash i18n (translation) function"
Description: "An incredibly simple i18n (internationalization + translation) function using lodash `get` and `template` functions"
Date: "2021-10-22"
Category: "Snippets"
Template: "post"
Keywords: ["lodash", "i18n", "internationalization", "intl", "translation", "get", "template", "function"]
---

One of the great things about [lodash](https://lodash.com/) is that it gives you all the building blocks to create some really powerful functions.

I was working on a site that needed to use dynamic translations. The way this is done today is usually through a function that is loaded in your components and called with a key that then gets mapped to whatever language you are using.

You can pass in variables to the function in order to translate sentences that include placeholders. For example, you might want to have a welcome message like "Hello {name_of_user}!". Pretty common use case as you can imagine.

I managed to get a simple version of an `intl` function working by using a combination of `get`, `template`, and `memoize` functions in lodash.

<script src="https://gist.github.com/james2doyle/d00e06a5f4963a539e3aa0b2d5283d11.js"></script>

What we are doing here is using first getting a value from our translation file. We use the `template` function to parse the value we find from our translation function using a pattern that looks for single words wrapped with curly braces. Like `{this}`. We can then pass in any variables we wanted to replace in that string. Finally, we use `memoize` to avoid recompiling the template on each additional call. This will just return the cached results of any translations instead of grabbing the value and parsing the string again.

If you find yourself needing a simple translation function, this could be a good option if you already have lodash in your project.
