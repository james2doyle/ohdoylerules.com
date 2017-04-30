---
Title: "List File Permission Numbers"
Description: "Easily list the chmod numbers for all the files in a folder"
Date: "2013-12-08"
Category: "Snippets"
Template: "post"
Keywords: ["chmod", "permissions", "file", "numbers", "command", "line", "cli", "terminal"]
---

I wanted to see the chmod numbers for the files in a directory. So I can copy them to the other files. Since I don't want to do that dumb chmod math, I looked for a way to do it easily.

I found the following code:

#### Function

Add the following to your .bashrc (or .zshrc file if you are cool) and then reload the source of your terminal.

```shell
function show-permissions() {
  ls -l | awk '{k=0;for(i=0;i<=8;i++)k+=((substr($1,i+2,1)~/[rwx]/) \
            *2^(8-i));if(k)printf("%0o ",k);print}'
}
```

#### Usage:

    show-permissions
    644 -rw-r--r--   1 james2doyle   README.md
    644 -rw-r--r--   1 james2doyle   LICENSE

greping the output

    show-permissions | grep README.md
    644 -rw-r--r--   1 james2doyle   README.md

Here is the [stackoverflow question](http://goo.gl/HS9Ar3) where I stole this from.

