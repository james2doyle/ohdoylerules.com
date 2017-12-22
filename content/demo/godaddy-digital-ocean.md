---
Title: "GoDaddy Email on Digital Ocean"
Description: "How to use GoDaddy Email on Digital Ocean"
Date: "2013-11-18"
Category: "Demo"
Template: "post"
Keywords: ["godaddy", "email", "digital ocean", "hosting", "mx", "records", "dns", "settings"]
---

I was recently trying to send an email to a domain I had purchased on GoDaddy but had hosting on [Digital Ocean](https://www.digitalocean.com/?refcode=802f151adea5).

I sent the email and a couple hours later it bounced. This wasn't good. My email was going to GoDadddy but I want the site *hosted* on Digital Ocean.

So I had to find how to keep the domain hosted on Digital Ocean but the email needs to stay on GoDaddy servers.

Here are the DNS settings I used:

<div class="center">
  <a href="/images/do-records1.png" title="GoDaddy Digital Ocean DNS Records" target="_blank"><img src="/images/do-records1.png" alt="GoDaddy Digital Ocean DNS Records" ></a>
</div>


Your settings may differ, so please follow these instructions in order to check if your settings are correct:

* Log into GoDaddy
* Launch the domain you are looking to check
* Go to the email tab
* Hover over tools and click "Server Settings"
* You will see a popup showing all the settings

There you can see that there are a bunch of records listed. These are the ones for your specific domain.

<div class="center">
  <a href="/images/do-records2.png" title="GoDaddy Default MX and DNS Records" target="_blank"><img src="/images/do-records2.png" alt="GoDaddy Default MX and DNS Records" ></a>
</div>

Hopefully this was helpful because it took a long time to figure out! It is even more painful because the records take a while to propogate. Boo!
