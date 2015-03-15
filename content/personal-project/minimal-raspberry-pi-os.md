/*
Title: Minimal Raspberry Pi OS
Date: 2015-03-14
Category: Personal Project, Web
Template: post
Description: Setup and improve the Moebius OS for the Raspberry Pi
Keywords: Moebius, debian, linux, raspberry, pi, os, operating system, minimal, small, tiny
*/

## Introduction

I have had a [Raspberry Pi B+](http://www.raspberrypi.org/products/model-b/) for a while now, and I was looking to setup a very minimal Linux OS.

Although the other [Raspberry Pi OSs](http://www.raspberrypi.org/downloads/) are great, a lot of them are too feature-full and have packaged GUI libraries I never use. So I wanted to install something much more bare than the ones on the Raspberry Pi website.

Enter, [Moebius](http://sourceforge.net/projects/moebiuslinux/). A few words from the Moebius site:

> [Moebius] is a Raspberry PI armhf Debian based distribution targeted to have a minimal footprint. Size, speed and optimizations are main goals for this distro...

With that said, the *unzipped img* is about 110Mb. That is very small. 

The other thing that Moebius does is remove the default Raspbian sources from apt-get. This means *you can't just download all the Rasbian packages* you want.

Moebius introduces the idea of containers. This isn't the same container technology like Docker. The "containers" are more like groups of packages. When installing a Moebius container, everything is installed in `/usr/bin` as if it came with the system.

I am going to provide a little walkthrough to get started with Moebius as a light-weight development environment, as well as how to install some other tools.

### Initial Setup

First, visit the Moebius Sourceforge page and follow the instructions to [download Moebius](http://sourceforge.net/projects/moebiuslinux/files/raspberry.stable/). The basic instructions tell you how to copy the img to the SD Card. Once everything is setup and the Raspberry Pi has booted, complete the following:

* Either connect a screen and keyboard to the pi, or SSH to the pi
* The default user is `root` and password is `moebius`
* When logged in, run `moebius`

<div class="center">
  <a href="http://ohdoylerules.com/content/images/moebius-tool.png" title="Moebius command line app" target="_blank"><img alt="Moebius command line app" src="http://ohdoylerules.com/content/images/moebius-tool.png" ></a>
  <p>Moebius command line app</p>
</div>

Moebius is the name of the OS, but also the name of a sweet little built-in command line tool to setup the rest of the pi.

#### SSH Niceness

Add your public key to Moebius in order to ssh without a password. Just create `~/.ssh` and then use `vi ~/.ssh/authorized_keys` to paste in your public key.

* Run `moebius` and select `Basic/Initial Setup`
* Choose `Autoresize SD partition`, follow the instructions
* Run `apt-get update`
* Run `apt-get install tzdata`
* Run `moebius` and select `Basic/Initial Setup`, choose `System timezone setup` and follow instructions
* In `moebius`, select `Software Management` and select `Update containers list from repository`
* Do the same as above except choose `Install a container` from the `Software Management` menu
* Select the `lang.gcc` container

<div class="center">
  <a href="http://ohdoylerules.com/content/images/moebius-container-tool.png" title="Moebius container command line app" target="_blank"><img alt="Moebius container command line app" src="http://ohdoylerules.com/content/images/moebius-container-tool.png" ></a>
  <p>Moebius container command line app</p>
</div>

**You may get an error** telling you to run `dpkg --configure -a`. If this happens, press any key to close the container installed and then run that command. When that completes, try to install the `lang.gcc` container again.

You may have to repeat this process *multiple times*.

Once the container is installed, you should have `make` and `gcc`, and a bunch of other tools on your system.

---

### Install git

**You must install the lang.gcc container first**. That container provides the necessary compilers we need in order to build git.

* Get the required development files with `apt-get install openssl-dev curl-dev libexpat-dev dropbear-dev coreutils coreutils-dev`
* Download the latest zip archive `wget https://github.com/git/git/archive/v2.3.3.zip`
* Run `unzip v2.3.3.zip` and then `cd v2.3.3/`
* Allow the scripts to run with `chmod +x *.sh && chmod +x check_bindir`

Following the official [INSTALL](https://github.com/git/git/blob/master/INSTALL) in the git source code repository, we want to leave out some of the features in order to build without some of the required libraries.

To do this, we need to run:

    make NO_PERL=YesPlease NO_TCLTK=YesPlease NO_GETTEXT=YesPlease prefix=/usr install

This will take a while to build, so *grab a coffee or a beer*.

**Note:** This command does not build the docs, so if you want those, you will have to consult the [INSTALL](https://github.com/git/git/blob/master/INSTALL) file in the git repo.

### Samba setup

Samba lets us access the pi like a hard drive on our local network. Samba *works well with Windows and OSX*, and of course Linux as well. 

If you are not familiar with the vi tool, you should [use this site to learn some basics](http://www.washington.edu/computing/unix/vi.html).

Complete the following to setup Samba:

* run `apt-get install samba`
* open the config with `vi /etc/samba/smb.conf`
* then complete the following:

```
# find in the top part of the file
workgroup = your_workgroup_name
# find and uncomment this line
wins support = yes
# add to the bottom of the file
[pihome]
  comment= Pi Home
  path=/home/
  browseable=Yes
  writeable=Yes
  only guest=no
  create mask=0777
  directory mask=0777
  public=no
```

* set the samba password with `smbpasswd -a root`

### Install lit and luvit

*Again, have lang.gcc installed before continuing*.

I have been playing with [Lit](https://github.com/luvit/lit) and [Luvit](https://github.com/luvit/luvit) quite a bit lately, so let's install them with a series of commands
    
    apt-get install curl
    curl -L https://github.com/luvit/lit/raw/master/get-lit.sh | sh
    mkdir -p /usr/local/bin
    mv lit /usr/local/bin/lit
    lit make lit://luvit/luvit
    mv luvit /usr/local/bin/luvit

Try running `lit version` and then `luvit --version` to see if the frameworks are installed.

---

### Finished

You should now have everything setup to get around. If you find any problems with my instructions, please let me know and I will update them!