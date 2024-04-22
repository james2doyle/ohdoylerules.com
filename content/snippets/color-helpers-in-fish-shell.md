+++
title = "Color Helpers In Fish Shell"
description = "How to easily create a color function for printing colorized output"
date = "2017-06-03"
category = "Snippets"
template = "post.html"
[taxonomies]
keywords = ["color", "fish", "shell", "prompt", "output", "stdout"]
+++

I am one of those people who likes a lot of colors in my shell. When there is a failure, I like to see red. If there is something stuccessful, I like to see green.

Working with the prompt to output the correct colors can be a bit of a pain. I manage to find a nice way to handle both colorizing backgrounds for the text as well as the actual text color. You can see an example below:

{{ gist(src="https://gist.github.com/james2doyle/acb8c065c8b4d63f557d44a77a356d59.js") }}

Once you add the code into your `fish config`. You will then be able to colorize your output using this simple helper function:

```fish
color_print $COLOR_R "I am red text."
```

You can also do a background color:

```fish
color_print $BG_G "I am on a green background."
```

I use this helper function in my other functions to colorize output when showing different results or handling different exit codes.

Here is an exmple of a little function that moves a file and timestamps it:

```fish
function amv
  set source $argv[1]
  if [ $source ]
    set stamp (date +%Y-%m-%d-%H-%M-%S)
    set dest "$stamp-$source"
    mv $source $dest
    # output will be blue text
    color_print $COLOR_B "Moved $source to an archive at $dest"
  else
    # output will be yellow text
    color_print $COLOR_Y "Help: amv source.zip {timestamp}-source.zip"
  end
end
```

So you can see where this can be really helpful for when you just want to simply color some text. Instead of worrying about the color codes and escape sequences, you can use this handy helper function now.
