/*
Title: Custom Google Forms
Author: James Doyle
Date: 2013-05-22
Updated: 2014-09-05
Category: Personal Project, Web
Template: post
Keywords: CSS, custom, drive, forms, Github, google, less, node, open source, preprocessors
*/

<div class="center">
  <img src="http://ohdoylerules.com/content/images/googleforms.png" alt="" align="middle">
</div>

I have been complaining about the lack of themes for google forms for a while now. I finally decided to stop crying and do something. After a bit of research I have found a way to create custom forms rather easily.

### How to create a custom form

This is just the normal way to make a new google form. If you have made one before then just skip this.

* Create a form as normal
* Click the view live form
* Copy everything inside the form tag including the form tag itself
* Create a new blank HTML file
* Create an empty div with a container class
* Paste all the form markup inside there
* Link the style.css stylsheet
* Test the form and check the response in Google drive

### Hosting the form

**Edit: This feature is [no longer avaliable](https://support.google.com/drive/answer/2881970?hl=en) to the new google drive.**

Something relatively new to Google drive is the ability to host static HTML pages.

* Create a public shared folder
* Upload all your static html files
* Open the index.html file in drive and click the preview button
* Copy the link to the page it sends you too
* Share that link with whoever because you are done!
* This is how the [demo form](https://googledrive.com/host/0B3SHb_huRFdyNENfQjVzSGpIOFU/index.html "Hosted Demo of custom Google Form") is hosted.

As a starting point I basically just copied the stylesheet from the default Google form page. Then I took all the colors and placed them into variables. The stylesheet needs to be stripped of things not necessary.

### Moving Forward

I do not want to add any extra markup to the pages. The idea hear is to just copy the form mark that Google gives you and then just add a stylesheet that will make it themed.

**Think themes for bootstrap. Markup stays, stylesheets change.**

But right now I am just going to try and normalize the current stylsheet into something as default as possible so that I can then create a my-theme-name.css file that contains all the variables to do the styling. I am currently only using the variables in LESS but eventually I will use more of the feaures to get everything nice and themeable.

You can check out the [Demo form in action](https://googledrive.com/host/0B3SHb_huRFdyNENfQjVzSGpIOFU/index.html "Hosted Demo of custom Google Form") or just jump right to the [Github Repo](https://github.com/james2doyle/google-form-styling "james2doyle/google-form-styling").
