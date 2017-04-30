---
Title: "Phile CMS"
Description: "Phile is flat-file CMS based on Pico"
Date: "2013-11-04"
Category: "Personal Project"
Template: "post"
Keywords: ["phile", "pico", "cms", "markdown", "twig", "template", "PHP"]
---

After being a upset at the progress with Pico, myself and a developer from Germany([Frank](https://twitter.com/neoblack "Frank Twitter")) have developed a fork project.

<div class="center">
  <a href="http://philecms.github.io/Phile/" title="PhileCMS Homepage">
    <img src="http://ohdoylerules.com/content/images/phile-logo.png" alt="PhileCMS Logo">
  </a>
</div>

The project is [PhileCMS](http://philecms.github.io/Phile/ "PhileCMS Homepage"). It maintains the philosophy of Pico, being fast and small, but it makes a lot of improvements on the core. Most the project is now OOP based with classes and models.

Also the parser and the template engine have been pushed into services. Which means they can be overloaded and replaced with different ones. Don't like Markdown? Use a plugin for TextTile instead. Don't like [Twig](twig.sensiolabs.org)? Replace it with [Lex](https://github.com/pyrocms/lex)!

The hooks system was completely replaced with an Evented system. The plugins have also changed. They now have a config.php file that is used instead of having to write your own file reader for each plugin.

### So why use this over Pico?

Here is a small list of differences in design from Pico:

* OOP based (Classes)
* Events system
* Parser Overloading
* Template Engine Overloading
* Performance Improvements (*33% to 65% speed increase*)

The main increase in speed is when there are multiple pages. Once you get to 20 pages you see a minumum of a 50% increase in load times.

I have actually converted this site to run on Phile. It is probably the first site in production to be using it. I also use the [Sundown Plugin](https://github.com/PhileCMS/Sundown-Parser-Plugin) I wrote since I have [PHP-Sundown](https://github.com/chobie/php-sundown) installed on my server.

Anyway, check out the project. It is pretty cool and I am very happy with the work of Frank.

[Github Repo](https://github.com/PhileCMS/Phile)

[Homepage](http://philecms.github.io/Phile/ "PhileCMS Homepage")
