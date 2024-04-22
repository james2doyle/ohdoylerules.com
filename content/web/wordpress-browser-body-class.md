+++
title = "WordPress Browser Body Class"
date = "2017-06-21"
category = "Web"
template = "post.html"
description = "A simple WordPress tutorial for adding a class to the body that represents the browser. No plugin required."
[taxonomies]
keywords = ["wordpress", "browser", "detect", "body", "class", "no plugin"]
+++

Sometimes, browsers just don't behave. While working on a WordPress site, I had a particular styling issue that was affecting Safari. I was wondering what the best way to target the browser was.

If you didn't know, there are some primitive [browser detection booleans](https://codex.wordpress.org/Global_Variables#Browser_Detection_Booleans) that are built into WordPress.

Using those primitives, I was able to whip up a little snippet that adds classes to the body tag depending on the browser - no plugins required.

{{ gist(src="https://gist.github.com/james2doyle/979b09fc7c676baf3283bdb113b3db6d.js") }}

As you can see, we simply loop over each one of those browser booleans and append them to the output.

Easy, and no plugin needed. Just add that code to your `functions.php` file.
