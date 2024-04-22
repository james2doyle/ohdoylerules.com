+++
title = "Install the latest Node.js on Amazon Linux"
description = "How to install the latest version of node.js on the Amazon Linux AMI"
date = "2017-04-29"
category = "Snippets"
template = "post.html"
[taxonomies]
keywords = ["nodejs", "amazon", "linux", "aws", "centos", "redhat", "rhel", "yum"]
+++

Installing the latest version of Node.js on the Amazon linux AMI can actually be a little painful.

Here is a script for doing just that.

{{ gist(src="https://gist.github.com/james2doyle/a1f0b415dee4e69b3595b7af1d07e7c1.js") }}

Hopefully, sometime soon, Amazon will stop using `0.10.*` and start using a `x.*` version by default.