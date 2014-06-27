/*
Title: The Simple Spam Stopper
Date: 2014-05-27
Category: Web
Template: post
Keywords: spam, email, contact, form, captcha, recaptcha, fields, validation, honey, pot
*/

For the last year at [WARPAINT Media](http://warpaintmedia.ca), we have been getting assaulted with spam. Everything from "Chinese Jerseys" and "Super SEO Ultra Elite Package Extreme" offers.

We are using [PyroCMS](http://pyrocms.com) for the website. The default contact plugin is pretty awesome. It has some really great features and couldn't be easier to use. There is a little [honeypot](http://www.sitepoint.com/forums/showthread.php?946120-Spam-Honey-Pot-trap&s=9cfd3419319d5c9bd1f5d597cdfa6113&p=5278832&viewfull=1#post5278832) for spam bots, but it seems to not be doing a great job, at least for us.

The great thing about the Pyro contact form is that it lets the developer define some validation without much work. In the past I have added questions like *"what is one plus one? (use a number)"*, other times I have tried "are you a human?" with a dropdown. Both seemed fine. But I wanted something a little more transparent and more conventional than strange questions about math or your species.

The solution that I came up with was, 2 email fields. That's it. I have one that is called "email" and another field that is called "check". When the user submits the form, the email and check field and validated. The rules for them are that they need to be identical, *but* they also need to be valid emails.

So there is a sort of a double validation going on. They need to be putting in a real email and they need to know that the email needs to match the check field. The label for this second check field is just "Enter Your Email Again". Since it comes after the first field with an Email label, people tend to figure it out.

How about the results? Well we used to get about 10-20 spam per day. Now we get about 1-3 a week and none of them are from our websites contact form.

#### Tl;Dr

I added a second email input and practically eliminated our spam.
