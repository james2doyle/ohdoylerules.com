---
Title: "Apax apache theme in htdocs"
Description: "Apax apache theme in htdocs"
Date: "2013-07-02"
Category: "Snippets"
Template: "post"
Keywords: ["Apax", "apache", "theme", "htdocs"]
---

I was tired of looking at the ugly default no-style of the htdocs file listing. I had seen [Apaxy theme](http://adamwhitcroft.com/apaxy/ "Apaxy Homepage") before and thought it was really nice. But I couldn't figure out how to get it to work with the default htdocs MAMP folder. I tried again tonight, and I got it working without much hassle.

1.  [Download Apaxy](https://github.com/AdamWhitcroft/Apaxy/archive/master.zip "Apaxy Download Link") and move everything from the apaxy folder into your MAMP htdocs folder.
2.  open "htaccess.txt" and replace "/{FOLDERNAME}/theme" with "/.theme/"
3.  rename the "htaccess.txt" file to ".htaccess" which will hide the file
4.  rename the "theme" folder to ".theme" which will hide the directory
5.  go to your localhost url and refresh
6.  enjoy a not-ugly page

Now you can edit the files in the ".theme" folder and style your page. I changed the ".wrapper" to have no max-width or margin, this way it was full screen.

[![apaxy theme applied to htdocs](https://ohdoylerules.com/images/Screen-Shot-2013-07-02-at-12.38.08-AM.png)](https://ohdoylerules.com/images/Screen-Shot-2013-07-02-at-12.38.08-AM.png)

Above is a screenshot of what my htdocs/localhost:8888 now looks like.

#### OPTIONAL

You can also hide the ".theme" folder. You will see a section that looks
like this, in your .htaccess file:

    # HIDE /theme DIRECTORY
    IndexIgnore .htaccess /.theme

The old version should read "/theme" and not "/.theme". If change this
line, it will NOT show the .theme folder in the localhost listing.

