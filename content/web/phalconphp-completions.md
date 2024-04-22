+++
title = "PhalconPHP Completions"
date = "2015-03-20"
category = "Personal Project"
template = "post.html"
description = "A PhalconPHP completions and snippets package for Sublime Text"
[taxonomies]
keywords = ["sublime", "phalcon", "phalconphp", "completions", "snippet", "package"]
+++

I have created a package of Sublime Text completions for [Phalcon PHP](http://phalconphp.com/en/) 1.3.\*.

There are **414** total right now. This is pretty much a copy-paste from my [sublime-node-snippets](https://github.com/james2doyle/sublime-node-snippets) repo.

<div class="center">
    <img src="https://raw.githubusercontent.com/james2doyle/phalconphp-completions/master/testing.gif" alt="PhalconPHP Completions in action" />
    <p>PhalconPHP Completions in action</p>
</div>

## Installing

#### Via Package Control

Just look for `phalconphp-completions` on [Package Control](https://packagecontrol.io/packages/PhalconPHP%20Completions).

#### Manually Adding Repo

* Open the Commands Palette (command+shift+p)
* Package Control: Add Repository
* Past in this repos URL
* Press Enter
* Open the palette again
* press enter on "phalconphp-completions"
* watch it install

#### By Download

Drop this folder in your Sublime Text packages directory.

## Using

Pressing `\` (backslash) or `:` will end the snippet lookup.

Therefore, you will have better results if you *pretend the slashes and colons aren't needed*. So if you are looking for `Phalcon\Text::increment`, you would type `phalcontextincrement` and you would see the results coming up.

*See the GIF above!*

## Building

I went to each page of the PhalconPHP docs, and copied the functions. Then I wrote a converter to take each function and convert it to a snippet.

For Example, this line:

```
Phalcon\Text::endsWith($str, $end, $ignoreCase)
```

Is going to get converted to:

```
Phalcon\\Text::endsWith(\\$${1:str}, \\$${2:end}, \\$${3:ignoreCase});${0}
```

## sources.txt

This file is cool. It is just a line-by-line output of the Phalcon docs functions. This is the file that is parsed to generate the snippets.

## Running The Build

Just run `node build.js` and it will rake the `sources.txt` file and then write the new snippet in the snippets folder.

Everything before the first `(` will be used as the filename.

## Adding New Snippets

Here is how I quickly got all these snippets.

First, I went to the docs for the class, and I looked to see what the code examples were wrapped in. For the all the docs pages, the methods and properties are show in a `p.method-signature` element.

So to quickly get the list, I ran the following code:

```javascript
Array.prototype.slice.call(document.querySelectorAll(".method-signature"), 0).map(function(item){
  return item.textContent.trim();
}).join("\n");
```

Then copied the output in the Chrome console, added the class in front (replacing the type info), and pasted it in the `sources.txt` file. Done!
