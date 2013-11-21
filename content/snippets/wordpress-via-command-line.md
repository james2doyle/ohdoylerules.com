/*
Title: Get Wordpress via Command Line
Description: Download and unzip the latest Wordpress version, all via command line
Date: 2013-11-21
Category: Snippets,Web
Template: post
Keywords: wordpress, install, bash, shell, cli, command, line, script
*/

All the cool kids are using the command line these days. This allows you to run quick commands and little functions that would be too tedious to run with a GUI or just clicking around.

A while ago I added this little code snippet to be .bashrc file. It means I can run `download-wordpress` in an empty folder and then it will go and grab the latest archive, unzip it, and remove the junk.

```bash
download-wordpress () {
  wget http://wordpress.org/latest.tar.gz # get wordpress
  tar xfz latest.tar.gz # unzip the archive
  mv wordpress/* ./ # move the files to the root of this directory
  rmdir ./wordpress/ # delete the empty directory
  rm -f latest.tar.gz # delete the archive
  echo 'wordpress installed' # let me know we are done
}
```

This is a handy function. You can really use it for any CMS or Zip file you have to grab on the regular. Just remember to run this in an *empty directory*, or it will overwrite everything and it will make a huge mess.
