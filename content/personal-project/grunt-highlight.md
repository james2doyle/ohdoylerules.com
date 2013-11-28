/*
Title: Grunt Highlight Plugin
Description: Grunt task for running Highlight.js over files or blocks of code
Date: 2013-11-25
Category: Personal Project,Web
Template: post
Keywords: grunt, highlight.js, prettyprint, plugin, node,
*/

Over the weekend, in a couple hours, I wrote this grunt plugin for [Highlight.js](highlightjs.org). I know that [marked](https://github.com/chjj/marked) does an excellent job of parsing markdown, and can also use highlight, but I wanted something I could use in [assemble](https://github.com/assemble/assemble/) for HTML parsing or full css/js files.

This was made much easier thanks to the [yeoman-gruntplugin](https://github.com/yeoman/generator-gruntplugin) project.

### Getting Started
This plugin requires Grunt.

If you haven't used [Grunt](http://gruntjs.com/) before, be sure to check out the [Getting Started](http://gruntjs.com/getting-started) guide, as it explains how to create a [Gruntfile](http://gruntjs.com/sample-gruntfile) as well as install and use Grunt plugins. Once you're familiar with that process, you may install this plugin with this command:

```shell
npm install grunt-highlight --save-dev
```

Once the plugin has been installed, it may be enabled inside your Gruntfile with this line of JavaScript:

```js
grunt.loadNpmTasks('grunt-highlight');
```

### The "highlight" task

#### Overview
In your project's Gruntfile, add a section named `highlight` to the data object passed into `grunt.initConfig()`.

```js
grunt.initConfig({
  highlight: {
    task: {
      options: {
        // Task-specific options go here.
      },
      your_target: {
        // Target-specific file lists and/or options go here.
      }
    }
  }
});
```

#### Options

##### options.lang
Type: `Boolean`
Default value: `false`

If you know the highlight language, use this.

##### options.useCheerio
Type: `Boolean`
Default value: `true`

You target files are HTML and you want to parse over them and highlight code blocks. *Turn off for raw code input*.

##### options.selector
Type: `Boolean`
Default value: `pre code`

This is what cheerio will be looking for as code block in your HTML. *Only used when useCheerio is true*.

#### Usage Examples

##### Default Options

```js
grunt.initConfig({
  highlight: {
    task: {
      options: {},
      files: {
        'dest/out.html': ['src/in.html'],
      }
    }
  }
});
```

##### Full Code Files

If you want to highlight an entire file then use the following:

```js
grunt.initConfig({
  highlight: {
    task: {
      options: {
        useCheerio: false,
        lang: 'javascript' // treat the file as a javascript file
      },
      files: {
        'dest/highlighted.html': ['src/bunch-o-javascript.js'],
      }
    }
  }
});
```

##### Many Files

```js
grunt.initConfig({
  highlight: {
    scripts: {
      options: {
        useCheerio: false,
        lang: 'javascript'
      },
      files: {
        'javascript.html': ['src/script.js']
      }
    },
    styles: {
      options: {
        useCheerio: false,
        lang: 'css'
      },
      files: {
        'stylesheet.html': ['src/style.css']
      }
    }
  }
});
```

Check out the project [on github](https://github.com/james2doyle/grunt-highlight).
