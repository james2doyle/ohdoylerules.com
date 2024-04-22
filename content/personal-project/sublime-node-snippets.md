+++
title = "Sublime Node Snippets"
date = "2014-03-25"
category = "Personal Project"
template = "post.html"
description = "Sublime Text snippets for node, async, underscore, and lodash"
[taxonomies]
keywords = ["sublime text 3", "snippets", "javascript", "node", "async", "underscore", "lodash", "completions", "package control"]
+++

I created a [huge snippet library](https://sublime.wbond.net/packages/Node%20Completions) based on the docs for node 10.26. There are **783** total right now (*2014-03-25*).

The way that I quickly made this big repository, was I wrote a script that would generate new sublime snippets based on a text file.

The [converter](https://github.com/james2doyle/sublime-node-snippets/blob/master/convert.php) just reads [the text file](https://github.com/james2doyle/sublime-node-snippets/blob/master/sources.txt) line by line and then generates a `.sublime-completions` file.

There is a template that is sort of setup. So you can actually just clone the repo, drop in a new sources file, and then generate a new snippets library with the converter.

Here is an excerpt from [the github repo](https://github.com/james2doyle/sublime-node-snippets):

## Installing

#### Package Control

Just look for `sublime-node-snippets` on [Package Control](https://sublime.wbond.net/packages/Node%20Completions). It is called "Node Completions" on the site, but comes up as "sublime-node-snippets".

#### Manual Install

* Open the Commands Palette (command+shift+p)
* Package Control: Add Repository
* Past in this repos URL
* Press Enter
* Open the palette again
* press enter on "sublime-node-snippets"
* watch it install

## Using

Pressing `.` (period) will end the snippet lookup.

You will have better results if you pretend the period isn't needed. So if you are looking for `fs.readdir`, you would type `fsread` and you would see the results coming up.

## Snippet Categories

Node Populars

* async
* underscore
* lodash

Node Core

* Assert
* Buffer
* Child
* Console
* Cluster
* Crypto
* Decoder
* Domain
* Dns
* Event
* Http
* Https
* Fs
* Global
* Module
* Net
* Path
* Punnycode
* Process
* Querystring
* Readline
* Repl
* Timers
* Tls Ssl
* Tty
* Udp
* Util
* Url
* Os
* Vm
* Zlib

## Adding New Snippets

Here is how I quickly got all these snippets.

I will use [Express](http://expressjs.com/3x/api.html) as an example since it isn't in here.

First I went to the docs for the framework, and I looked to see what the code examples were wrapped in.

For the [express](http://expressjs.com/3x/api.html) docs site, the codes are shown in `section h3` tags. So to quickly get the list, I ran the following code:

```javascript
Array.prototype.slice.call(document.querySelectorAll("section h3"), 0).map(function(item){
  return item.textContent.trim();
}).join("\n");
```

Then copied the output and pasted it in the `sources.txt` file. Done!

##### Cool Feature

**The word `callback` will automagically be converted into a function.**

## Building

I went to each page of the [node docs](http://nodejs.org/api/), and copied the functions. Then I wrote a [converter](https://github.com/james2doyle/sublime-node-snippets/blob/master/convert.php) to take each function and convert it to a snippet.

For Example, this line:

```
setTimeout(fun, delay)
```

Is going to get converted to:

```
setTimeout(${1:fun}, ${2:delay})${0}
```

When the word `callback` appears, it will convert it to the standard
`fun` snippet.

```javascript
fs.readdir(path, callback)
```

will become

```javascript
fs.readdir(${1:path}, function(${2:args}){
  ${3:// body}
})${0}
```

## sources.txt

This file is cool.

It is just a line-by-line output of the node docs functions. This is the file that is raked over to generate the snippets.

## Running The Build

Just run `php convert.php` and it will rake the sources.txt file and then write the new snippet in the snippets folder.

Everything before the first `(` will be used as the filename and tab snippet.

## Contributing

Just add (or edit) a line in the source file. Then run `php convert.php` to generate the new snippets.

## Why PHP?!

Well, PHP is actually pretty good at manipulating strings and writing files. Maybe at some point I will convert the converter and release it as a separate tool.

## Source

You can find the [source code on github](https://github.com/james2doyle/sublime-node-snippets). You can also install via package control by looking for `sublime-node-snippets`.

