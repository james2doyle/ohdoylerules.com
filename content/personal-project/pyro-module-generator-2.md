---
Title: "PyroCMS Module Generator 2.0"
Date: "2014-11-16"
Category: "Personal Project"
Template: "post"
Description: "The Pyro Module Generator allows you to rapidly create modules for Pyro 2.2 and up"
Keywords: ["Phalcon", "generator", "Github", "module", "open source", "PHP", "Pyro", "tool", "build", "live", "demo"]
---

Finally, I found a good excuse to re-write my old [Pyro Module Generator](https://ohdoylerules.com/personal-project/pyro-module-generator).

This tool was originally made when I was freelancing. I built it off the [Sample Module project on Github](https://github.com/pyrocms/sample). I wanted to be able to build modules quickly, since I wasn't using streams. In fact, streams wasn't even a thing when I made the first version of the module generator.

Again, I have made a [live hosted version of the generator](http://dev.warpaintmedia.ca/pyro-module-generator/ "PyroCMS Module Generator Website") which you can use without having to have anything setup locally. The generated module is zipped and then ready for download.

The [source is also on Github](https://github.com/james2doyle/pyro-module-generator "PyroCMS Module Generator On Github") for people who want to patch issues or fork.

### About Version 2.0

This new version is built with [PhalconPHP](http://phalconphp.com/en/) because phalcon is crazy fast and easy to make small apps with. I managed to get the whole thing re-written in a day. Much of the code was a copy paste for the build process. But now the `Add Field` button is actually an AJAX call to generate a new partial for the new field. This is much nicer than the pervious version.

That being said, **YOU MUST HAVE PHALCONPHP INSTALLED TO USE THIS APP!!**.

There are a few little things I need to refactor, so that when 3.0 comes out, it will be easy to switch between the different versions of Pyro.

### Usage

Just throw it in your localhost root and point your browser to it. There is no database, since it just writes and renames files for you.

If you have **used a custom folder name** (and didn't just clone as `pyro-module-generator`), then open the [config/config.php and change the baseUri](https://github.com/james2doyle/pyro-module-generator/blob/master/config/config.php#L7) to match that folder name.

##### Writeable Folders

We need to run `chmod -R 777 cache/volt` and `chmod -R 777 public/generated` if you have write errors.

* cache/volt/
* public/generated/

#### Genrated Modules

**Included in all generated modules is the following setup:**

* `ID` field by default
* `order` field by default
* functionality for drag and drop table order (add `ui-sortable-container` to `tbody` in admin index view)
* basic function for files included but commented out
* `_form_data` function for passing data to form views
* settings table included, but commented out

The generated module gets put in the `public/generated/` folder. As well as the Zip file.

<div class="center">
  <p>Screenshot of the current version of the app</p>
  <a href="/images/pmg2.jpeg" title="PyroCMS Module Generator Screenshot" target="_blank"><img alt="PyroCMS Module Generator Screenshot" src="/images/pmg2.jpeg" ></a>
</div>
