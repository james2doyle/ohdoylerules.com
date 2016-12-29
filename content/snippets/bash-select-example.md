/*
Title: Bash select example
Description: An example of how to use the select command in bash to pass arguments to functions
Date: 2014-04-07
Category: Snippets,Web
Template: post
Keywords: select, bash, command, line, cli, terminal, function, arguments
*/

I recently bought 2 [raspberry pi computers](http://raspberrypi.org). One is for home, and one is for the office.

Since we have dynamic IPs setup in the office, and I have the same at my house, I needed to be able to connect using the MAC address of the pi. I ended up writing a little script to get the IP based on the MAC Address, and then ssh into the computer. Pretty slick.

To make my life easier I used the `select` command in bash. The [documentation for select](http://www.gnu.org/software/bash/manual/bashref.html#Conditional-Constructs) leaves a lot to be desired. So I had to fiddle with it until I got it right. Here is a simple boilerplate for a bash script using select:

#### Function

```shell
#!/usr/bin/env bash

speak() {
  echo "$1 $2"
  break; # we are done
}
echo "What do you want me to say?"
select ab in "Hello" "Bonjour";
do
  case $ab in
    "Hello") speak "Hello" "my friend";;
    "Bonjour") speak "Bonjour" "mon ami";;
    *) echo "invalid option";; # you picked anything but 1 or 2
  esac
done
```

Save that in a file called `say-hello.sh` and change the rights to allow execution by using `chmod +x say-hello.sh`. Then you can run it:

#### Output:

```
$ ./say-hello.sh
  1) Hello
  2) Bonjour
  #? 1
  Hello my friend
$
```

You can see that in this example I push `1`. If I run it again and push `2`, you will see the French words show up.
