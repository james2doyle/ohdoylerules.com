+++
title = "Randomly Generate A Password In Bash"
description = "Randomly generate a password of specified length and then copy it to the clipboard"
date = "2014-02-16"
category = "Snippets"
template = "post.html"
[taxonomies]
keywords = ["password", "random", "generate", "base64", "bash", "openssl", "cli", "terminal", "shell", "command line", "pbcopy", "clipboard", "osx", "mac"]
+++

When installing or setting up frameworks, in this case I was playing around with [Laravel](http://laravel.com/), you usually need to set a session/secret/encryption key.

I know why this is, but I always end up looking around for some random password generator so I can get a random string that is exactly 32 characters. Isn't there an easier way?!?!

Yes there is. If you have the magical [OpenSSL](https://www.openssl.org/ "OpenSSL Website") installed, which most do, you can use it to generate a random string.

I found a [article online](http://osxdaily.com/2011/05/10/generate-random-passwords-command-line/ "Generate Random Passwords from the Command Line") that uses base64 to generate a string of a certain length. The only thing is that base64 is padded with 8 bits. Which means that if you want 32 then you need to use 24. This goes up exponentially as the number gets bigger. So there is a trim part of the function that clips off the extra characters.

Here is the function broken down into steps:

* pass a number to the function
* cut the resulting string
* generate a base64 string using that number
* echo out the result
* copy the output to the clipboard with a newline
* echo out a success

I put a check in there if the argument is not a number. This is just for the dummies out there.

#### pbcopy is not defined

You are probably on Linux. I found [this little snippet](http://whereswalden.com/2009/10/23/pbcopy-and-pbpaste-for-linux/ "pbcopy and pbpaste for Linux") for the lazy. This way you can forget about translating it each time.

```sh
alias pbcopy="xsel --clipboard --input"
alias pbpaste="xsel --clipboard --output"
```

Now for the actual shell function:

### Code

```sh
# if the argument is a number
# cut the string so that there is no base64 padding
# generate a random password of the specified length
# then copy it to the clipboard without a newline
# usage: password 32
password() {
  LENGTH="$1"
  REGEX='^[0-9]+$'
  if [[ $LENGTH =~ $REGEX ]] ; then
    PASSWD=$(openssl rand -base64 $LENGTH | head -c$LENGTH)
    echo $PASSWD
    echo $PASSWD | tr -d '\n' | pbcopy
    echo "Password copied to clipboard"
  else
    echo "Argument must be a number"
  fi
}
```

Here is how you would use it, and what the results would look like:

### Output

```sh
~ ❯ password 32
gY4zLES+WWF5+iNWo0FYx+os6EmDwecf
Password copied to clipboard
~ ❯ password fu
Argument must be a number
~ ❯
```

This function would be put in your `.bashrc` file, or you `.zshrc` file if you are a cool ZSH user.

