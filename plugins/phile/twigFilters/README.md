Twig-Filters-Plugin
===================

An example plugin for [Phile](https://github.com/PhileCMS/Phile) showing how to make [Twig filters](http://twig.sensiolabs.org/doc/advanced.html#filters).

### 1.1 Installation (composer)
```
php composer.phar require phile/twig-filters:*
```
### 1.2 Installation (Download)

* Install [Phile](https://github.com/PhileCMS/Phile)
* Clone this repo into `plugins/phile/twigFilters`

### 2. Activation

After you have installed the plugin. You need to add the following line to your `config.php` file:

```
$config['plugins']['phile\\twigFilters'] = array('active' => true);
```

### Usage

There will now be a new twig filter called `excerpt`. It grabs the first paragraph of the content string.

So you can use it like {{ content|excerpt }} and it will print the first paragraph from that pages markdown file.

There will also be a filter called `limit_words`. It is used in the same way, and the limit is controlled in the [plugins config file](https://github.com/PhileCMS/Twig-Filters-Plugin/blob/master/config.php#L3).

If you want to remove the HTML markup when using the `limit_words` filter, you can use the `striptags` Twig filter:
```
{{ page.content|striptags|limit_words }}
```

### Adding More Filters

See the [Twig Documentation on creating filters](http://twig.sensiolabs.org/doc/advanced.html#filters).
