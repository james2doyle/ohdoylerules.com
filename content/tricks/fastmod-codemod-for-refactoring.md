---
Title: "Fastmod Codemod For Refactoring"
Description: "Fastmod is a command line tool that can help you with large-scale codebase refactors"
Date: "2020-02-06"
Category: "Tricks"
Template: "post"
Keywords: ["refactor", "code", "delete", "remove", "replace", "find", "webpack", "rewrite", "fix", "fastmod", "codemod"]
---

If you have ever encounter a big refactor, you were probably dreading the steps it would take to get all the changes done. You have to find patterns, replace them, remove old code, rename variables, so much work! Well, like most things in the development world, there are tools to help you do this. Yes, you can use find-and-replace, but that approach is very naïve (as in simple) and doesn't take in some of the more nuanced cases that you will come across.

The tool that I have been using for the last couple of years is [fastmod](https://github.com/facebookincubator/fastmod). `fastmod` is a flavour of `codemod` but written in Rust - so it has to be cool right? Here is a description from the `codemod` repo:

> codemod is a tool/library to assist you with large-scale codebase refactors that can be partially automated but still require human oversight and occasional intervention.

What you do is write a "match pattern" and then a "replace pattern". When you run the tool you get a prompt for each match and you can decide what you want to do with the proposed changes. This is a lot like `git add -p` (which is also a great trick) where you only accept the changes you know are valid.

One of the best things about this tool is how it provides the interface to the changes you need to apply:

- [x] filter files by extension
- [x] use regex to create matches
- [x] named matches so they can be reordered
- [x] preview of the changes before you commit them
- [x] ability to accept or decline any single change
- [x] ability to edit the changes using `$EDITOR` (like `git commit --verbose`)
- [x] accept all changes without previews ("fast mode")

**Help With Regex**

If you are terrible at written regex patterns, you're not alone. There are lots of people who despise regex but it isn't going anyway. I actually made a conscious effort a few years ago to acquire a better understanding of how regex works and what the patterns and special characters do. I used [this tool call regexr](https://regexr.com/) to help practice as well as learn new patterns. Check it out if you need help building and testing regex patterns.

Like most purpose-built tools, there is some learning curve to finding how to best use the interface provided. You really need to consider your match strategy and your replace strategy. Let's write some examples based on some real world examples I've come across.

#### CSS

Here we have a CSS example for a button component. This component can be grouped or have an icon inside it. The naming of the component in CSS is kinda redundant.

```css
.button-group-component {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.button-component {
  color: white;
  background-color: black;
  display: inline-block;
  padding: 1rem 2rem;
}
.button-component .button-icon-component svg {
  fill: currentColor;
}
```

Let's remove the `-component` part of the CSS declaration. We don't need it. So we are going to turn `.button-group-component` into `.button-group` and so on for the other 2 class declarations. All we need to do is find `-component` and replace it with nothing/null/empty string.

```sh
fastmod -m --extensions css '(\-component)' ''
```

Running the above code on in our target folder will prompt us with this:

```diff
./example.css:1
- .button-group-component {
+ .button-group {
    display: flex;
    align-items: center;
Accept change (y = yes [default], n = no, e = edit, A = yes to all, E = yes+edit, q = quit)?
```

Here you can see all the options for the code that is going to be changed as well as a nice diff too. If we move from left to right in the options we get the following choices:

- `y` or `enter` accepts the changes being shown
- `n` will not change anything and will go to the next change
- `e` will open your `$EDITOR` *without* any changes applied
- `A` will accept this change and all of the future changes with reprompting you
- `E` will open your `$EDITOR` *with* any changes applied
- `q` will no accept the changes and stop the process

In this case we can hit `enter` for each change. We will be prompted 4 times: once for each occurrence of the string `-component` or we can skip all that and just hit `A` and everything will be changed.

#### Webpack Magic Comments

Recently I was working on a Vue project that had a lot of components in it. I wanted to start using [webpack chunking](https://router.vuejs.org/guide/advanced/lazy-loading.html#grouping-components-in-the-same-chunk) in order to split the components up and have single chunks for each component instead of them being wrapped up together. In order to do that, I need to rewrite all my `import` statements to use "dynamic imports" with a special magic comment that webpack picks up.

You can see the example below:

```sh
# old code: `import MyComponent from 'Components/MyComponent.vue';`
# new code: `const MyComponent = () => import(/* webpackChunkName: "MyComponent" */ 'Components/MyComponent.vue');`
# note: you may need to reorder your imports when using a dynamic import

fastmod -m -d ./ --extensions vue \
  'import (.*?) from \'(.*?)\';' \
  'const ${1} = () => import(/* webpackChunkName: "${1}" */ \'${2}\');'
```

Here you can see the snippet I wrote to do the refactor. The great thing about using `fastmod` over find-and-replace, is that it allowed me to accept or deny the changes. I didn't want all the components updated this way. Especially imports that were not Vue components. So this approach was ideal.

#### More Use Cases

Those are two decent examples but I have used this tool quite a lot for refactoring code. Here are some more examples of what I used it for:

- add/remove classes in HTML
- rename bad variable names on multiple projects
- quickly fix the misspelling of various words in multiple projects
- ran a replace on an exported SQL database backup to change some values in the data (faster than running a query)
- [refactor `isset` into `array_get`](https://gist.github.com/james2doyle/a94542b8ef6f07a689f23698424d1763) on a Laravel (PHP) project
- merge down multiple `use` statement in PHP to a single `use` line
- rewrite `{{ var }}` interpolation to `v-text="var"` directives in a Vue project
- replace imports with other versions
- upgrade old code to new methods or APIs

As you can probably already tell, the possibilities are endless! I have used this on database exports and even CSV files. It is a much nicer alternative to find-and-replace. Best of all? It's editor agnostic. So you can use it with any other tools.
