+++
title = "Decrypt-Encrypt Functions From Command Line"
description = "Functions to encrypt and then decrypt files from the command line with OpenSSL"
date = "2013-11-22"
category = "Snippets"
template = "post.html"
[taxonomies]
keywords = ["encrypt", "decrypt", "openssl", "cli", "terminal", "shell", "command line", "shred", "rc4"]
+++

### Preamble

I have been reading about encryption and security since the whole NSA/Edward Snowden thing. It is pretty intense stuff. Most of the security comes from the philosophy of "security through obfuscation". What this means, is that you are making it extremely difficult (expensive, time-consuming) to try and look at your "stuff".

I would suggest reading [this article on "Key Size"](http://en.wikipedia.org/wiki/Key_size). This is probably my favorite quote from the article:

> With a key of length *n* bits, there are *2n* possible keys. This number grows very rapidly as *n* increases. Moore's law suggests that computing power doubles roughly every 18 to 24 months, but even this doubling effect leaves the larger symmetric key lengths currently considered acceptable well out of reach.

The best thing you can do for this type of encryption is [pick a good password](https://tech.dropbox.com/2012/04/zxcvbn-realistic-password-strength-estimation/).

### Code

```sh
# take in a file and output an encrypted one
function encrypt() {
  # take in a file and output a new one with a `.enc` extension
  openssl rc4 -in "$1" -out "$1".enc
  echo "$1.enc created"
}

# reverse of encrypt()
function decrypt() {
  FILENAME="$1" # save the old filename
  # decrypt the file and save it to a file with no `.enc` extension
  openssl rc4 -d -in "$1" -out ${FILENAME%.*}
  echo "$1 decrypted"
}
```

This still leave an "open" file when the file is encrypted. Remember to remove the file securely. You can use `shred` or `gshred` (for OSX). Here is the info from the `--help` output of gshred:

> Overwrite the specified FILE(s) repeatedly, in order to make it harder
for even very expensive hardware probing to recover the data.

Here is the function that I found to be pretty good:

```sh
# overwrite 'my-unsafe-file.txt' 3 times, with zeros (nulls) and then remove the file
gshred --iterations=3 --zero --remove my-unsafe-file.txt
```

Note: I used RC4 instead of 3DES because it is faster (95% slower than RC4), but it is not as secure.

#### References:

* [Encrypt & Decrypt Files from the Command Line with OpenSSL](http://osxdaily.com/2012/01/30/encrypt-and-decrypt-files-with-openssl/)
* [Wiping Securely](http://blog.commandlinekungfu.com/2009/05/episode-32-wiping-securely.html)
* [OpenSSL Cipher Selection](http://zombe.es/post/4078724716/openssl-cipher-selection)
