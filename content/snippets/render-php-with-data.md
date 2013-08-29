/*
Title: Render PHP File With Data
Date: 2013-08-29
Category: Snippets,Web
Template: post
Keywords: php, render, file, data, view, array, template
*/

I am modifying an open source CMS to use the [Phalcon PHP framework](phalconphp.com/en/ "Phalcon PHP Framework"), as well as the [PHP-Sundown](https://github.com/chobie/php-sundown "PHP-Sundown") C implimentation of Markdown.

It is a very simple CMS which previously would just echo out compiled HTML. But I am using the Volt template engine in Phalcon. It renders `.volt` files to native PHP. This means that I cannot just spit out raw HTML. I need to create a render function that passes an array of data to my PHP file.

Here is that function:

    function renderPhpFile($filename, $vars = null) {
      if (is_array($vars) && !empty($vars)) {
        extract($vars);
      }
      ob_start();
      include $filename;
      return ob_get_clean();
    }

    // usage
    echo renderPhpFile('views/templates/index.php', $view_data);

This works! It is a handy little function for passing data into a PHP file.

If you wanted to use an object, you would need to cast it to an array first.