/*
Title: Grunt Sundown
Date: 2013-09-08
Category: Personal Project,Web
Template: post
Keywords: grunt, sundown, markdown, plugin, node, robotskirt, c, library
*/

**grunt-sundown** is a wrapper for [robotskirt](https://github.com/benmills/robotskirt)([Sundown](https://github.com/vmg/sundown)) - a C implementation of [Markdown](http://daringfireball.net/projects/markdown/)

### Getting Started
This plugin requires Grunt `~0.4.1`

If you haven't used [Grunt](http://gruntjs.com/) before, be sure to check out the [Getting Started](http://gruntjs.com/getting-started) guide, as it explains how to create a [Gruntfile](http://gruntjs.com/sample-gruntfile) as well as install and use Grunt plugins. Once you're familiar with that process, you may install this plugin with this command:

    npm install grunt-sundown --save-dev

Once the plugin has been installed, it may be enabled inside your Gruntfile with this line of JavaScript:

    grunt.loadNpmTasks('grunt-sundown');

You can find the project [on Github](https://github.com/james2doyle/grunt-sundown "grunt-sundown on Github").

### The "sundown" task

#### Overview
In your project's Gruntfile, add a section named `sundown` to the data object passed into `grunt.initConfig()`.

    grunt.initConfig({
      sundown: {
        target: {
          options: {
            extensions: {
              fenced_code: true
            },
            render_flags: {
              skip_html: true
            }
          },
          files: {
            'output.html': ['input1.md', 'input2.md']
          }
        }
      }
    });

#### Options

    options: {
      extensions: {
        autolink: false,
        fenced_code: false,
        lax_html_blocks: false,
        no_intra_emphasis: false,
        space_headers: false,
        strikethrough: false,
        tables: false
      },
      render_flags: {
        skip_html: false,
        skip_style: false,
        skip_images: false,
        skip_links: false,
        expand_tabs: false,
        safelink: false,
        toc: false,
        hard_wrap: false,
        use_xhtml: false,
        escape: false
      },
      separator: '\n\n' // concat option for multiple files
    }

#### More Information

You can try your luck on the [Sundown](https://github.com/vmg/sundown) homepage. Or check out some of the [other wrappers](https://github.com/vmg/sundown#bindings).