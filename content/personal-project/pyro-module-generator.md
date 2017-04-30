---
Title: "PyroCMS Module Generator"
Description: "PyroCMS Module Generator that can generate modules for pyrocms"
Date: "2013-04-13"
Category: "Personal Project"
Template: "post"
Keywords: ["CodeIgniter", "generator", "Github", "laravel", "module", "open source", "PHP", "PyroCMS", "tool"]
---

<div class="center">
  <img src="http://ohdoylerules.com/images/pmgh.png" alt="PyroCMS Module generator header image">
</div>

### UPDATE
I created a [hosted version](http://pyromg.aws.af.cm/ "Hosted Pyro Module Generator") of the module generator.

FINALLY!! I finished my module generator. It lets you create modules by just filling in a simple form. The module it generates can be used with 2.2. There is no support for any other version at this time.

[See the Video](http://www.youtube.com/watch?v=g7moZUqIwHU "Pyro Module generator video") or go to the [github repo](https://github.com/james2doyle/pyro-module-generator "james2doyle/pyro-module-generator").

The “app” is just installed to your localhost. It uses no database and relies strictly on writing files and reading files.

It is built using [Laravel](http://laravel.com/ "Laravel Homepage") because Pyro is eventually going to move to Laravel. It is kind of funny that a Laravel based app is building a CodeIgniter based CMS! Hehehee.

There is a lot of extra junk in there now just because I may create a dedicated site for it. I also want to make it more dynamic for when you are creating dropdown/multiselect and radio/checkbox inputs. But that depends. Right now it can just run locally and be used/customized that way.

This is actually my fourth iteration of the generator. I created one with no framework, just straight PHP. That was rough. Then I made one with just CodeIgniter. It was a little better. Next, I went kind of crazy and made a PHP command line tool. It can actually make plugins and widgets quite nicely.

In the end I chose Laravel because I might as well start learning it and it was pretty easy to use. Sp please [check it out](https://github.com/james2doyle/pyro-module-generator "james2doyle/pyro-module-generator") and help clean it up if you can.

Some little screenshots:

<div class="center">
  <img src="http://ohdoylerules.com/images/pmg1.png" alt="PyroCMS Module generator input form">
  <img src="http://ohdoylerules.com/images/pmg2.png" alt="PyroCMS Module generator field input">
</div>