---
Title: "Setup A Raspberry Pi with PHP And Lighttpd"
Description: "Setup a raspberry pi with php 8.1 and the latest lighttpd web server"
Date: "2022-06-05"
Category: "Snippets"
Template: "post"
Keywords: ["raspberry", "pi", "php", "8.1", "composer", "lighttpd", "apache", "web", "server"]
---

I recently got a Raspberry Pi model 4+. I'm using it to [run a minidlna server](https://pimylifeup.com/raspberrypi-minidlna/) that loads music and movies from an old external hard drive that I have. On top of that, I wanted to run a local web server so that I can write scripts and pages that I can access locally on my network without having to have my laptop open and running.

I wanted to setup `lighttpd` as it is much more efficient than the default installed `apache2`. Since I'm already running `minidlna`, I wanted a web server that was more performant and used less memory/resources.

Finally, I wanted the latest PHP installed given I use it a lot in my day job and it will be great for writing small websites that are only ever accessed through my local network. Unfortunately, the default installed PHP version is quite a bit behind and you need to setup new sources in order to install the latest version of PHP.

Here is a short list of all the steps you need to setup a newer version of PHP 8.1 as well as the `lighttpd` server.

#### Instructions

_These instructions assume you're using the default debian-based raspberry pi operating system!_

Update the local packages already installed:

```sh
sudo apt-get update
```

Install the dependencies needed to add the additional services:

```sh
sudo apt-get install lsb-release apt-transport-https ca-certificates
```

Add the repository for installing the latest version of PHP:

```sh
sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://origin.sury.org/php/apt.gpg
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/php.list
```

Now we can install all the PHP packages we will need for basic PHP applications:

```sh
sudo apt-get update
sudo apt-get install -y php8.1 php8.1-cli php8.1-cgi php8.1-intl php8.1-zip
```

If you need additional PHP extensions then the above command is where you would add those in.

Since we now have the latest PHP version, we can setup `composer`. The `sha384` code may different for your installation based on whatever version is out when you are following these instructions. [You can find the latest download/install instructions on the Composer download page](https://getcomposer.org/download/).

```sh
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
sudo mv composer.phar /usr/local/bin/composer
php -r "unlink('composer-setup.php');"
```

We can remove `apache2`, given we are not going to use it:

```sh
sudo systemctl stop apache2.service
sudo apt remove apache2
```

The last thing to install will be `lighttpd`:

```sh
sudo apt-get install lighttpd lighttpd-doc
```

We also want to enable the PHP modules inside `lighttpd` so that we can process `.php` files:

```sh
sudo lighttpd-enable-mod fastcgi fastcgi-php
```

In order for the web server to properly run, serve our files, and store logs and caches, we need to make sure the folders have the right ownership rules:

```sh
sudo chown -R www-data:www-data /var/log/lighttpd
sudo chown -R www-data:www-data /var/cache/lighttpd
sudo chown -R www-data:www-data /var/www/html
```

To test out the server once we are finished, we can setup this simple project that emulates the apache directory listing module. This will just list everything in our `/var/www/html` folder in a nice display:

```sh
git clone https://github.com/halgatewood/file-directory-list /var/www/html/listing
```

If you are looking for a more efficient directory browser, or you don't want to use PHP for this, you can [use the built-in `dirlisting` module](https://redmine.lighttpd.net/projects/lighttpd/wiki/Docs_ModDirlisting) that comes with `lighttpd`.

We can now make sure the `lighttpd` service is running so it will always start when we restart our pi:

```sh
sudo systemctl start lighttpd.service
```

If you want to test the server on the command line, you can just `curl` your localhost and see what happens. You should get the source code for the listing page we installed:

```sh
curl http://localhost/listing
```

Done! That should be all you need to have PHP 8.1 and a light weight web server setup!
