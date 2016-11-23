/*
Title: OpenSSL Passwd Without Prompt
Description: How to use the openssl passwd without a confirm prompt
Date: 2016-11-22
Category: Tricks
Template: post
Keywords: openssl, prompt, passwd, password, confirm, stdin, stdout, pipe, auth
*/

Have you ever wanted to generate a password using the `openssl passwd` command, but didn't want the prompt?

I encountered this problem when I was writing [an Ansible role for setting up Nginx basic auth](https://github.com/invokemedia/ansible-basicauth-nginx). I didn't want the prompt since I had no way for ansible to handle that gracefully. After some Googling, and some `man` page grepping, I found the answer.

You can generate a password without a prompt by piping text into `openssl` and passing a new flag. For example:

```
echo "password" | openssl passwd -apr1 -stdin
```

This will echo to `stdout`. This way you can write a script or something instead of having to use the prompt to type in the password.

In my case of generating a basic auth password, I had to append the output to the `/etc/nginx/.htpasswd` file. That was done using the following command:

```
echo "password" | openssl passwd -apr1 -stdin >> /etc/nginx/.htpasswd
```

There ya go. It's that easy. I have actually used this trick a couple times for generating passwords and piping to `pbcopy` (the clipboard) on my mac.

Pretty useful stuff!
