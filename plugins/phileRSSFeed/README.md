phileRSSFeed
============

Generate RSS feeds based on the posts in your [Phile](https://github.com/PhileCMS/Phile) site.

### Installation

* Install the latest version of [Phile](https://github.com/PhileCMS/Phile)
* Clone this repo into `plugins/phileRSSFeed`
* add `$config['plugins']['phileRSSFeed'] = array('active' => true);` to your `config.php`
* go to `/feed` on your site

### Usage

You can set some defaults in the plugins config file. By default the feed URL is `/feed`. You can change this if you need too.

There is also a key in the plugin config called `post_key`. This is the key *that defines which unqiue meta key to associate with posts*. If you posts don't have a date but instead use a template of 'post' you can use that instead.

There is a file included with a plugin called `template.php`. This is the file that is used as the *XML template for the RSS feed*. This is a valid RSS feed when run through the [Phile-Blog-Theme](https://github.com/PhileCMS/Phile-Blog-Theme) setup.

You may need to edit the template file if you require the feed results to be different.
