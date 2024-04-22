+++
title = "Detect Theme Editor In Shopify Liquid Templates"
date = "2020-01-04"
category = "Web"
template = "post.html"
description = "A demo on how to detect when a template is running in the Shopify theme and section builder"
[taxonomies]
keywords = ["shopify", "theme", "editor", "builder", "section", "detect", "liquid"]
+++

So you may already know that you cannot detect if an liquid page is running in the theme editor. You can however, [detect this in Javascript](https://help.shopify.com/en/themes/development/theme-editor/other-theme-files#detecting-the-theme-editor-with-javascript).

But what if you want conditional content? What if you want to use this "switch" in a liquid template?

There are a couple good reasons to do this. The first one being that sometimes you need to show the content the website admin is editing in a different way.

I needed this feature when I had a repeating section of blocks that only showed when certain filters where applied to a form. This made it really hard to edit the content. You couldn't see all the blocks at once while you were editing. I wanted to just show all the blocks, with no filtering applied, but only when the theme editor was being used to create and edit blocks.

Shopify says you can't do this though. I'm here to tell you they are incorrect.

Before I continue, you will need to understand [this hack used to detect query strings in liquid](http://freakdesign.com.au/blogs/news/get-the-url-querystring-values-with-liquid-in-shopify). Once read up on that snippet, you'll see how we build on that to detect the theme editor.

```jinja2
{%- comment -%}
  http://freakdesign.com.au/blogs/news/get-the-url-querystring-values-with-liquid-in-shopify
  Capture the content for header containing the tracking data
{%- endcomment -%}
{%- capture contentForQuerystring -%}{{- content_for_header -}}{%- endcapture -%}

{% comment %}Use string splitting to pull the value from content_for_header and apply some string clean up{% endcomment %}
{%- assign pageUrl = contentForQuerystring | split:'"pageurl":"' | last
  | split:'"'
  | first
  | split:'.myshopify.com'
  | last
  | replace:'\/','/'
  | replace:'%20',' '
  | replace:'\u0026','&'
  | strip
-%}
```

The code above is a snippet of the [trick used to detect query strings in liquid](http://freakdesign.com.au/blogs/news/get-the-url-querystring-values-with-liquid-in-shopify). We only need this piece. So let's continue.

```jinja2
{% comment %}When in the theme editor, the pageUrl variable is malformed/empty{% endcomment %}
{% if pageUrl contains page.handle %}
  We are in the frontend of the website
{% else %}
  We are in the theme editor of the website
{% endif %}
```

That's all we need now. I'll explain what is going on.

Basically, when the liquid template is being accessed in the theme editor, the `pageUrl` variable will not properly formed. Since that is the case, we just compare that value with the value that is in `page.handle`.

When the template is being loaded properly on the frontend of the site, the `pageUrl` will be equal to the `page.handle` value.

In summation, we can now detect if the theme is running in the section editor! Yay!

*Side Note*

Shopify likes to change things up every once in a while. They recently [deprecated the `include` tag in favour of a new `render` tag](https://developers.shopify.com/changelog/deprecating-the-include-liquid-tag-and-introducing-the-render-tag). So there is no promise this will work forever.

_You have been warned!_
