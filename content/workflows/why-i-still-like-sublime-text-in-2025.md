+++
title = "Why I still like Sublime Text in 2025"
description = "I still use Sublime Text in 2025 even after trying a lot of other editors"
date = "2025-01-27"
category = "Workflows"
template = "post.html"
[taxonomies]
keywords = ["sublime", "text", "editors", "neovim", "helix", "zed", "vscode"]
+++

I still get people asking me why I use Sublime Text in 2025 given there are *soooo* many other great editors out there.

My response: there is? Because I still think Sublime Text holds up as a great editor.

*Table Of Contents*

- [It fast](#it-fast)
- [LSP](#lsp)
- [Snippets](#snippets)
- [Project workspaces](#project-workspaces)
- [Build systems](#build-systems)
- [Multiple cursors](#multiple-cursors)
- [Key/mouse bindings](#key-mouse-bindings)
- [Included niceness](#included-niceness)
- [Wish List](#wish-list)

I started with Sublime Text 2 back in 2010/2011 while I was in college. I mainly started using it because it was free, cross-platform, and came as a "portable app" that I could put on a USB and just use.

Back then, I had a really basic Toshiba laptop that dual booted Windows XP and Ubuntu (or maybe it was Mint?) so it was nice that it worked on both. I really liked how snappy it was compared to the tools our teacher suggested using. At that time it was Dreamweaver and maybe Notepad++.

Sublime, at that time, was pretty novel. It clearly took a lot of inspirations from [TextMate](https://github.com/textmate/textmate), another classic editor, considering that one is 4 years older than Sublime. It had multiple cursors, plugins, a build system. But the [biggest claim to fame for Sublime, was the "command palette"](https://www.vendr.com/blog/consumer-dev-tools-command-palette). I'm sure there is some other older app that had a precursor or similar feature to it, but generally speaking, it seems like that user experience pattern really kicked off with Sublime.

I built my web-dev chops on Sublime. The shortcuts are ingrained in my bones at this point. I'm not some key-combo-king, but I know a lot of the shortcuts that can help me get the UI and commands I need without thinking much at all.

> I have been, and continue to be, a Sublime user of about 15 years.

So take all this with that in mind. I have been, and continue to be, a Sublime user of about 15 years.

So why do I keep using Sublime?

If you thought Sublime was dead, well you couldn't be more wrong! The latest build of Sublime as of this post is "4192" and was released 20th January 2025. So basically a week ago from this post. Not too bad.

It has regularly been updated with minor tweaks and fixes about a dozen times a year. I think the last major upgrade would be when Package Control (the plugin installer/manager) bumped to the next version which allowed plugins to install external dependencies.

You can nitpick here and say that Package Control is not part of Sublime. But most people won't use Sublime without it. So I am going to take some liberties and say it is part of it.

I think the thing to consider is how Sublime is basically "done" software. It has been around a *long* time. It was first released around 2008. It just passed it's 17-year anniversary actually. Congrats to them!

Before I dive into the details of **why** I still use it, consider this: if you are using a modern GUI-driven editor, it probably has taken inspiration from Sublime. So why not check out one of the OGs? You might find something you like.

Without further adieu, my reasons for still using Sublime in 2025:

### It fast

Sublime is fast. It starts instantly. Uses very few resources. Handles large files gracefully. Rarely crashes.

Nothing else to add here. A+ performance.

### LSP

[Sublime LSP](https://github.com/sublimelsp) is really doing a lot for Sublime to keep it feeling modern and keeping up with other tools in the same class.

If you aren't aware of what an LSP is, this isn't the post to learn about it. But the gist is, it handles all that fancy code-aware completion and hover info you like from VS Code. If you want to learn more [give TJ 5 minutes to learn you](https://www.youtube.com/watch?v=LaS32vctfOY).

Some of the cool things about the Sublime LSP:

**Multiple servers per file**

You can enable as many LSP servers per file that you want. Restart them individually and configure them on a per-project basis (more on that later) which really helps bolster the capabilities of this already great editor.

**Detection on a scope level**

When configuring an LSP, outside of one installed with a plugin, you tell the LSP plugin which "scope" (think of this as an id for a syntax) to enable an LSP on.

Want your LSP to only turn on if you only open a file with a specific syntax? No problem. Want it to turn on only if a type of syntax is detected? Like a specific flavour of CSS? Sure. It is very configurable.

**Extensible configuration**

I know VS Code is the LSP king, which the tech originating with that editor, but I haven't seen the ability to just add an LSP installed as a binary in on your `usr/local/bin`.

There are a few "cutting-edge" LSPs that are installed via Cargo that are usually only targeting Neovim, but can easily be configured in Sublime with a simple JSON object.

Here is an example of configuring [md-lsp](https://github.com/matkrin/md-lsp) (Markdown language server with support for GitHub flavored Markdown) in a few lines:

```json
// in the "LSP Settings" file, under "clients[]"
"md-lsp": {
  // default enabled?
  "enabled": true,
  "command": [
    // as long as the system path is setup right, we can find this binary
    "md-lsp",
  ],
  // when we see this scope, the LSP will start this server
  "selector": "text.html.markdown",
},
```

It should be noted that md-lsp **does not have a Sublime LSP plugin** nor any mention of Sublime in their README. They only mention support for *Helix* and *Neovim*. Well, guess what? You support Sublime too!

### Snippets

I write a lot of snippets. Right now, my snippets folder in Sublime has 123 snippets. The latest one was added **today**. It was a "TODO" snippet for Blade.

Sublime lets you create snippets from the `Tools > Developer > New Snippet` dropdown. They get sent to your "User" folder in the Sublime directory and are sourced on startup.

**Scope based**

Snippets are also scope-based. VS Code has scopes too, so there is nothing new here. I wonder where they got that from? 😮

A quick note on scopes: they can be very vague (like `source.txt`, targeting a whole `.txt` file) or super specific (like `text.html.basic.liquid text.html.basic meta.object.liquid` which targets a nested object in a liquid template) based on what you need.

I have found the Sublime scope integration to be straightforward to understand. A syntax defines scopes, and you can target those scopes in snippets, keybindings, and macros. More on those other two later.

I'm sure I didn't get the details perfect. But it doesn't really matter given the point I'm going to make: not all snippet systems work this way.

Specifically, I have found Helix, Neovim, and Zed snippets to be more based around "filetype" and not the scope of the where you are in the "syntax".

I'm sure this will change. Or perhaps I've missed something. From what I can see on the surface, snippets based on syntax-specific scopes seem to be the default in VS Code and Sublime.

**Tab stops with nesting, placeholders, and references**

Here is the snippet I made today:

```xml
<snippet>
    <content><![CDATA[
<!-- TODO: $1 -->$0
]]></content>
    <description>Blade todo comment</description>
    <!-- Optional: Set a tabTrigger to define how to trigger the snippet -->
    <tabTrigger>todo</tabTrigger>
    <!-- Optional: Set a scope to limit where the snippet will trigger -->
    <scope>text.html.blade</scope>
</snippet>
```

Pretty simple. People who have written snippets before will recognize the syntax. The `$1` is where your caret is sent first, you can then type, then hit tab, and you get sent to `$0`.

Here is a TODO snippet I have for "javascript" files:

```xml
<snippet>
  <content><![CDATA[
/** @todo ${1:this is my todo} */$0
]]></content>
  <!-- Optional: Set a tabTrigger to define how to trigger the snippet -->
  <tabTrigger>todo</tabTrigger>
  <description>Insert a TODO JS comment</description>
  <!-- Optional: Set a scope to limit where the snippet will trigger -->
  <scope>source.js, source.ts, source.jsx meta.function.js meta.block.js meta.group.js meta.jsx.js meta.interpolation.js, source.tsx meta.function.js meta.block.js meta.group.js meta.jsx.js meta.interpolation.js</scope>
</snippet>
```

Here you can see that the first tab stop has default content of "this is my todo". Here you can see a more complex scope setup that only expands this snippet under those conditions. Nothing really spectacular here.

But snippets in Sublime also support some transformations...

**Transformations (Vue component)**

Here is a much more complicated snippet:

```xml
<snippet>
  <content><![CDATA[
<!--
  ${1:Namespace} Component
  Usage:
    <${1/([a-zA-Z]+)(?:(\s+?)|\b)/\L\1(?2:\-)\E/g}></${1/([a-zA-Z]+)(?:(\s+?)|\b)/\L\1(?2:\-)\E/g}>
  ${2:Here is a description of my web component.}
  @element ${3:div}
  @fires change - This jsdoc tag makes it possible to document events.
  @fires submit
  @prop {String} title - You can use this jsdoc tag to document properties.
  @slot - This is an unnamed slot (the default slot)
  @slot start - This is a slot named "start".
  @slot end
 -->

<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
export interface Props extends /* @vue-ignore */ HTMLAttributes {
  ${4:title?: string;${5}}
}

withDefaults(defineProps<Props>(), {});
</script>

<template>
  <${3:div} :key="${1/(\w+)(\W*)/\L\1\E(?2:\-)/g}" class="${1/(\w+)(\W*)/\L\1\E(?2:\-)/g}wrapper">
    ${6:<!-- content -->}
  </${3:div}>
</template>
]]></content>
  <!-- Optional: Set a tabTrigger to define how to trigger the snippet -->
  <tabTrigger>sfc</tabTrigger>
  <!-- Optional: Set a scope to limit where the snippet will trigger -->
  <scope>text.html.vue</scope>
  <description>Vue single-file component template</description>
</snippet>
```

This snippet has some transformations in it. This means we can actually format what the content in the different tab stops will be.

I won't harp on what is going on too much. Just know that I can format the content in the "Usage" comment as `UpperCamelCase` and I can format the content in `:key` to be `lower-snake-case`. VS Code can do this. The syntax for it is a bit nicer. But I prefer authoring snippets in XML rather than JSON.

Obviously, I'm twisted.

### Project workspaces

Sublime supports the concept of workspaces under the banner of a "project". All without a plugin, by the way. You can open a folder and save that folder as a project.

This creates an empty `your-project-name.sublime-project` which you can really save wherever you like in your project as it has some features to target where the root of the project is.

This file is just a JSON file and contains editor settings that you are overriding for that specific project. You can target global settings, set rules for specific folders, create a build system, tweak/toggle LSP settings, etc. etc.

This is a lot like the `.vscode/settings.json` file from what I understand. I also believe you can do this in Vim with a `.vim` folder in the root of your project with a feature called "exrc". I haven't used it personally, so I can't speak to it much.

In my brief flirtations with Neovim and Helix, you need a plugin for this. In Zed, they also have a settings file that can be saved into a project root to get the same thing.

**Including/excluding files and folders**

I think all the editors I referenced above can do this. Not much to share. It is just nice to have an array of file configurations for a project that may or not be in that directory, can be matched with a glob, or just listed explicitly.

Here is an example of how I would use the project file in a Next.js site:

```json
{
    "folders": [
        {
            "file_exclude_patterns": [
                ".gitkeep",
                "*.min.*",
                "*.snap",
                "*.lock",
                "*lock.json"
            ],
            "folder_exclude_patterns": [
                ".sanity",
                ".netlify",
                ".next",
                ".vercel",
                ".cache",
                "out",
                "dist",
                "node_modules"
            ],
            "path": "."
        }
    ],
    "build_systems": [
        {
            "name": "Project - Build",
            "working_dir": "$project_path",
            "shell_cmd": "pnpm run build"
        },
        {
            "name": "Project - Test",
            "working_dir": "$project_path",
            "shell_cmd": "pnpm run test"
        },
        {
            "name": "Project - Open Test",
            "working_dir": "$project_path",
            "shell_cmd": "find tests -print | grep $file_base_name.spec | sed -n 1p | xargs subl
        },
        {
            "name": "Project - Test Snapshots",
            "working_dir": "$project_path",
            "shell_cmd": "pnpm run test:snapshots"
        },
        {
            "name": "Project - Test File",
            "working_dir": "$project_path",
            "shell_cmd": "pnpm run test -- $file_base_name.spec"
        },
        {
            "name": "Project - Test File Snapshot",
            "working_dir": "$project_path",
            "shell_cmd": "pnpm run test:snapshots -- $file_base_name.spec"
        },
        {
            "name": "Project - Format README.md",
            "working_dir": "$project_path",
            "shell_cmd": "mdformat $file"
        }
    ],
    "settings": {
        "match_brackets_angle": true,
        "tab_size": 2,
        "translate_tabs_to_spaces": true,
        "jsdocs_return_tag": "@return",
        "lsp_format_on_save": false,
        "lsp_code_actions_on_save": {
            "source.organizeImports": false,
            "source.fixAll.eslint": true
        },
        "LSP": {
            "formatters": {
                "source.ts": "LSP-biome",
                "source.js": "LSP-biome",
                "source.tsx": "LSP-biome",
                "source.jsx": "LSP-biome",
                "text.html.basic": "LSP-biome"
            },
            "LSP-eslint": {
                "enabled": false
            },
            "LSP-biome": {
                "enabled": true
            }
        }
    }
}
```

I'm doing a lot here. Setting files to ignore, folders to exclude from indexing, setting build commands that use `pnpm` as well as `mdformat`, setting from editor setting for tab spacing, and finally a few LSP tweaks that make sense for a Next project.

VS Code can do all of what I've listed here. But they split it up into different files. Kinda annoying.

**Configure plugin settings per project**

You can also configure plugin settings per project. Here is how I would add project settings for the "syntax override" plugin. This plugin forces the editor to use a specific syntax for certain files that match a given pattern:

```json
{
    // everything is the same as above but this is added on the end
    "syntax_override": {
        "\\.env.*$": [
            "ShellScript",
            "Shell-Unix-Generic"
        ],
        "\\.*rc$": [
            "JSON",
            "JSON"
        ],
        "\\.ts.snap$": [
            "JavaScript",
            "TypeScript"
        ],
        "\\.css$": [
            "Tailwind CSS",
            "Tailwind CSS"
        ]
    }
}
```

I don't always want all `.css` files to be highlighted with the Tailwind syntax. But in this project I do. So I can set it locally here, and when I open a `.css` file in this project, it will switch the syntax for me. Nice!

**Add build systems per project**

You can see in the example above that I have set build systems on this specific project. You can do this in VS Code with "tasks". Zed has this feature as well and calls it "tasks" too. I just find it annoying that they are in their own files. I guess that makes them more portable.

I just like my project configuration *in one central place*. I must be nuts.

### Build systems

I've touched on build systems a bit already. But in summation, they are just tasks you can run in your project.

Sometimes they call a global command (like `curl`), sometimes a local dependency is installed with a package manager (think some binary in *node_modules/.bin/*), or maybe just runs a command already setup in your other tools (like `composer run test` or `php artisan migrate:fresh`) that run in the root of the project but need some context.

**Can also be provided by a plugin**

A plugin can provide build systems. The neat thing is they are just Sublime files. JSON that ends in `.sublime-build`. Like snippets. So they are really portable too. Just like the other editors with their `tasks.json` file.

**Just a simple file**

Here is one I saved in my "User" directory called `dot-env-linter.sublime-build`:

```json
{
  "cmd": ["dotenv-linter", "$file"],
  "selector": "source.shell",
  "file_patterns": ["\\.env.*$"],
  "file_regex": "^(.*?)\\:(\\d+)(\\s)(.*+)"
}
```

You can see there are some special variables (like `$file`) that will expand based on context. In this case, that one is the full path to the currently active file.

Here is my `phpmd.sublime-build` with a bit more flavour:

```json
{
  "cmd": ["phpmd", "${file}", "text", "codesize,unusedcode,naming"],
  "path": "${PATH}",
  "working_dir": "$project_path",
  "selector": "source.php"
}
```

You can see some more vars here for the project path as well as a reference to my system PATH. Of course, we got a nice lil scope as well.

**Build systems with 🐍**

[You can actually write build systems in Python as well](https://www.sublimetext.com/docs/build_systems.html#advanced-example). So if you need something more complicated, you can reach for that.

You don't even need to make any semblance of a plugin. You can toss a `.py` file in your "User" directory and implement a class that takes a `sublime_plugin.WindowCommand`.

### Multiple cursors

Yep. Multiple cursors. I use them all the time. I know that the "vim" way is to start recording a macro, apply the changes on a single line, and then replay that macro on all the lines you want to change. Or do some `s//g` fu for a fancy find and replace. I get it. I just don't like it.

Most of the editors these days have multiple cursors. Including some terminal editors like Helix. I have tried Helix and I think it is a lot closer to what I would want from a modern editor than my previous terminal editor of Neovim + LazyVim.

### Key/mouse bindings

The key and mouse bindings are what you would expect from a modern editor. It is basically the same as VS Code. Nothing exhilarating here. But I do like the way conceptual key bindings are handled.

**Contextual key bindings**

Like any good editor, Sublime supports contextual key bindings.

I think the best usage I have seen for contextual key bindings is in [the JavaScript language support package](https://github.com/sublimehq/Packages/blob/master/JavaScript/Default.sublime-keymap#L11-L17) that comes with Sublime.

When you have an active selection, and that selection is not empty, and you are inside a string-like scope, then \` will wrap that selection with \`. Basically, it will wrap your selection as a template string. Handy!

**Just a simple file**

Like the build systems and snippets, key bindings are just saved in a file that ends with `.sublime-keymap`. They can be in your "User" directory or in a plugin. Unfortunately, unlike build systems, they cannot be saved on a per-project basis - from what I can tell.

You can also have key bindings for different platforms. They are named as follows:

```
Default (Windows).sublime-keymap
Default (OSX).sublime-keymap
Default (Linux).sublime-keymap
```

### Included niceness

These are just some notable mentions of things I like:

**Python all the way down**

Given how Python is probably the most popular language, at least [the last time GitHub checked](https://www.theregister.com/2024/11/05/python_dethrones_javascript_github/), I'm surprised this isn't the go-to editor. I don't think you need to know python to use Sublime but it helps if you want to craft a nice plugin.

One more thing to add around authoring plugins, they are super simple. It is just a `.py` file in a folder. No build system, external dependencies, or ever-changing APIs to navigate.

You can see [my recent fork of the Scratchpad plugin](https://github.com/james2doyle/sublime_scratchpad/blob/master/Scratchpad.py) and how the whole thing is mostly powered by a single python file.

This plugin has been trucking along for 11 years. I can't imagine any VS Code plugin lasting that long!

**Macros**

Yep you can record macros in Sublime. You can also save them to... a file! Then put that file (`.sublime-macro`) in a plugin, or, of course, your "User" folder. The macro is just an array of key presses. They also support scopes and can be bound to a key combo. Pretty sweet.

This is one feature that VS Code has not stolen - I mean implemented - and that requires an additional plugin to have. Of course the Vimmers have had this for decades.

**Diff hunks (revert or show)**

Sublime supports viewing inline diff hunks. Handy for when you don't want to dive into the diff of a file. You can just ask to see the diff hunk for that line or group of lines. You can also revert just as easily.

**Case conversion and line permute functions**

There are some handy case conversion functions that are built in. Nice with multiple cursors. VS Code has a couple of conversion choices. Sublime has 8 different case conversions built in.

**Package control and repo URLs for packages**

Package control packages can be installed from the central repository. But you can also install them from a git repo URL. You can also clone a repo to your "Packages" folder, and it will work too. No marketplace or anything like that is required.

This is really handy if you have forked a package and just want to install your fork.

**All the config and settings are plain files**

Since the whole of a Sublime setup is mostly plain files, that makes it really easy to sync your setup across multiple computers. I actually symlink my Sublime folder to Dropbox. So any changes I make will be shared across all my computers that use it.

This isn't unique to Sublime. I think it is just a benefit of having tools that use plain text-driven configuration.

**Distraction-free mode**

Sublime has a "distraction free mode" which will full-screen your editor and focus the content to the middle of the screen. I am using it to write this post right now!

### Wish List

Of course there could be a few things that could be better.

**Better docs**

I do find the docs for developing plugins to be sparse. There are doc sites. There are two big ones. One for the "official" docs that document the APIs. There is also another site that is tagged as the "unofficial" docs.

Usually when I want to know how to do something in a plugin, I just read the source of another plugin that does something I want to emulate. It isn't a bad way to learn, it is just a bit tedious.

**Plugin development DX**

Speaking of building plugins, there does not seem to be any "stubs" for the Sublime python API. I am by no means a python guru. I only use it in Sublime, and I usually forget everything once I finish what I am trying to do. But I think there could be some "plugin starter template" that could include a Pyright setup and some basic guide for how to get going.

I also find that getting plugins on the Package Control site to be quite a chore. You need to open a PR to a repo and put your repo into a list based on where it goes into an alphabet. It doesn't allow forks and plugins that are too similar. There is also no way to mark a package as "abandoned".

I like the way Composer/Packagist does packages. You create a repo, submit that URL to the Packagist site, and it will automatically keep track of it for you. You release a new version by just using git tags and releases.

NPM is also a bit nicer. But forcing an NPM account and having to juggle the mixing of git tags and the `package.json` "version" key to be a bit unclear at times.

**Key/Mouse bindings per project**

Simple one here. It would be nice to have key and mouse bindings on a project level. I don't know how often I would really use it, but it would be nice to have just for those projects that have tedious tasks or macros that I want to run under specific scopes.

## In Summation

I like Sublime. I think it is still incredibly capable in 2025. If you are in search of something a little snappier, classier, and not riddled with AI slop, then give it a try.

I doubt I can pry your Vim from your `HJKL` riddled right hand, but if you have been let down or uninspired by the latest offerings when it comes to editors, you might find Sublime still has a lot to offer.
