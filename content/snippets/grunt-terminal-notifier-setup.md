/*
Title: grunt terminal-notifier setup
Date: 2013-06-07
Category: Snippets,Web
Template: post
Keywords: 
*/

I just downloaded the new Mountain Lion, finally. One of the biggest new
things is the cool little native notifications akin to growl. I thought
it would be cool to get a nice notification when my "grunt watch" task
finished. First things first. You need to install
[terminal-notifier](https://github.com/alloy/terminal-notifier "alloy/terminal-notifier").
This allows you to interact with the native OSX notifications system.
There is a ruby gem and a standalone ".app". Once this is installed, you
will need to grab the
[grunt-growl](https://github.com/alextucker/grunt-growl "alextucker/grunt-growl")
plugin. There are more instructions there for the terminal-notifier app.
Now you will need to setup a new task in your gruntfile:

~~~~ {.prettyprint .lang-js title="gruntfile growl setup"}
growl: {
  css: {
    title: 'STYLUS BUILT',
    message: 'css/style.css has been created'
  },
  js: {
    title: 'JAVASCRIPT BUILT',
    message: 'dist/js/scripts.js has been created'
  }
}
~~~~

Now my watch task looks like this:

~~~~ {.prettyprint .lang-css title="watch growl notify"}
watch: {
  scripts: {
    files: ['<%= concat.dist.src %>'],
    tasks: ['jshint', 'concat', 'growl:js'],
    options: {}
  },
  styles: {
    files: ['css/*.styl'],
    tasks: ['stylus', 'growl:css'],
    options: {}
  }
}
~~~~

You can see that the growl task runs after the initial stylus and
javascript watch tasks.
