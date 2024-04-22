+++
title = "Github Wiki To HTML"
description = "Github Wiki To HTML"
date = "2013-11-17"
category = "Personal Project"
template = "post.html"
[taxonomies]
keywords = ["github", "gh pages", "markdown", "md", "wiki", "html", "marked", "node", "export"]
+++

Have you ever wanted to convert a Github wiki to a set of HTML pages? This can be an easy way to generate new gh-pages (github web pages) based on the projects Wiki.

As of [August 2010](https://github.com/blog/699-making-github-more-open-git-backed-wikis), you can actually clone a repositories wiki to your local machine just by adding .wiki at the end.

This pulls down all the wiki pages in their current format, by default this is `.md` files.

Now what can you do with these files? Well how about converting them to HTML so that you can use them in your gh-pages repo?

After cloning the *.wiki* repo to your local, you can create a script to convert all the files to HTML.

* first [install marked globally](https://github.com/chjj/marked) via NPM
* make a directory called `html` in the root of the repo
* create a file called `convert.sh`
* run `chmod +x convert.sh` on that file to allow execution
* paste the following into the file:

```sh
#!/bin/bash

# for each md file in the directory
for file in *.md
  do
    # convert each file to html and place it in the html directory
    # --gfm == use github flavoured markdown
    marked -o html/$file.html $file --gfm
done
```

Now if you look in the `html` directory, you will see all the markdown files have been converted and are in that folder.

In the next week or so, I will write a new post about how to use this method and the [grunt assemble](https://github.com/assemble/assemble "Grunt Assemble Project") plugin to make simple pages.
