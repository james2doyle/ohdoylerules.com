phileXMLSitemap
===============

[Phile](https://github.com/PhileCMS/Phile) plugin to generate a XML sitemap

### 1.1 Installation (composer)
```
php composer.phar require phile/xmlsitemap:dev-master
```

### 1.2 Installation (Download)

* Install [Phile](https://github.com/PhileCMS/Phile)
* Download this repo and drop the content into a new folder `phile/xmlsitemap` under the _Phile plugin directory_ e.g. `plugins/phile/xmlsitemap/`

### 2. Activation

After you have installed the plugin. You need to add the following line to your `config.php` file:


```php
$config['plugins']['phile\\xmlsitemap'] = array('active' => true);
```

Now, you can access the sitemap under the URL `http://your-domain.com/sitemap.xml`. If you installed Phile into a subdirectory your sitemap.xml is located under your `subdirectory/sitemap.xml`.
