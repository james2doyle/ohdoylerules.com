---
Title: "pico-download plugin"
Description: "I created a plugin to force files to download in PicoCMS"
Date: "2013-09-18"
Category: "Personal Project"
Template: "post"
Keywords: ["pico", "cms", "markdown", "php", "plugin", "download", "force"]
---

I created a plugin to force files to download in [PicoCMS](http://pico.dev7studios.com).

I needed this because I wanted to PDFs to download and not just render in the browser.

### Usage

Place your files in the content folder. Then replace the word `content/` in the url with the word `download/`.

*The download folder can be controlled in the plugin file. Default for downloading is `content/`.*

### Example

If you wanted to render the file in the browser:

**http://localhost:8888/Pico/content/sub/page.md**

Now with this plugin installed, you can force a download:

**http://localhost:8888/Pico/download/sub/page.md**

### More info

I have added quite a few comments in the plugin so just take a look. It's nothing new, just bringing different snippets together.

You can find the project [here on Github](https://github.com/james2doyle/pico_download "james2doyle/pico_download").
