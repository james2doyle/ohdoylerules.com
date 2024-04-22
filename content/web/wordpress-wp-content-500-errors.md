+++
title = "Fixing Wordpress wp-content 500 Errors"
date = "2015-09-29"
category = "Web"
template = "post.html"
description = "How to fix the issue where Wordpress wp-content assets are throwing 500 errors"
[taxonomies]
keywords = ["wordpress", "wp", "content", "error", "500", "misconfigure", "hack", "upload", "index", "htaccess", "apache"]
+++

Yesterday, a friend emailed me about her Wordpress site acting crazy. For some reason all the site assets weren't loading and were returning 500 errors.

#### Troubleshooting

I had her check the usual things: `.htaccess` is there, the asset actually existed, some plugin wasn't busting the site. Each one was throwing a 500 error, so it was something else.

Eventually she gave me her log in, which had a *super simple password*, and I logged in to see what was up. Nothing seemed to be wrong, no crazy plugins or weird issues.

I then logged into the FTP server to sniff around. Checked the `.htaccess`, nothing was wrong. I checked the `index.php`, didn't see anything weird.

I opened the `wp-config.php` and added all the [debugging constants](https://codex.wordpress.org/Debugging_in_WordPress#Example_wp-config.php_for_Debugging), here there are for laziness:

```php
// Enable WP_DEBUG mode
define('WP_DEBUG', true);

// Enable Debug logging to the /wp-content/debug.log file
define('WP_DEBUG_LOG', true);

// Disable display of errors and warnings
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors', 0);

// Use dev versions of core JS and CSS files (only needed if you are modifying these core files)
define('SCRIPT_DEBUG', true);
```

I then navigated around the site. The content (text, database data) was loading fine, but all the assets were busted. There was a map plugin that was hitting Google Maps and that loaded fine. I then knew it was this specific site.

After poking around some more, I noticed an `index.php` and a `.htaccess` in the root of `/wp-content`.

#### The Fix

Well, I have come across this problem before. **Wordpress was hacked**. Hacked might be a strong word, since the password was really weak. A bot probably had that password in it's script and guessed it without issue.

The "hacker" then uploaded a file to `/wp-content/.htaccess` and `/wp-content/index.php`. These files were intercepting request to the `wp-content` folder.

When I removed the files, the site came back to life!

So if your Wordpress site is suddenly getting 500 errors, check for rogue `index.php` or `.htaccess` files.

#### Create A Better Password

If you are looking to create a strong (but human readable) password, you should take a look at [Diceware](https://en.wikipedia.org/wiki/Diceware). In short, it is a huge list of uncommon words that get randomly combined to give you a strong password you can read.

Here is the definition from Wikipedia:

> Diceware is a method for creating passphrases, passwords, and other cryptographic variables using an ordinary die from a pair of dice as a hardware random number generator. For each word in the passphrase, five rolls of the dice are required. The numbers from 1 to 6 that come up in the rolls are assembled as a five-digit number, e.g. 43146. That number is then used to look up a word in a word list.

Here is an [online tool that can generate passwords for you](http://www.ethanresnick.com/diceware/). This site has the default set to word count set to *5*. As of today, you should probably use *6* words to generate your password.

#### Has Your Wordpress Been Hacked?

Do you know any common Wordpress hacks that occur?
