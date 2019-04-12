---
Title: "Laravel Scout Sonic Driver"
Date: "2019-04-12"
Category: "Web"
Template: "post"
Description: "A Laravel Scout driver for the Sonic search tool"
Keywords: ["php", "laravel", "scout", "search", "sonic", "elasticsearch", "rust", "index"]
---

If you haven't heard about the cool new search indexer [Sonic](https://github.com/valeriansaliou/sonic) you must be living under a rock! If you want to read about Sonic directly from the author, [check out his blog post](https://journal.valeriansaliou.name/announcing-sonic-a-super-light-alternative-to-elasticsearch/) on why and how they went on building the tool.

According to the Sonic page, it is:

> Fast, lightweight & schema-less search backend. An alternative to Elasticsearch that runs on a few MBs of RAM.

There are some main points on the site that outline some of the main features:

* Search terms are stored in collections, organized in buckets
* Search results return object identifiers
* Search query typos are corrected
* Insert and remove items in the index at the same time
* Auto-complete any word in real-time via the suggest operation
* Full Unicode compatibility on 80+ languages
* Built as a TCP protocol

All these items make this an ideal candidate for the [Laravel Scout search tool](https://laravel.com/docs/5.8/scout). Scout expects your search engine to return IDs that then get mapped to your query builder which will apply further transformations like `WHERE` clauses and pagination.

I took it upon myself to write a driver for Sonic. You can find it on my Github at [Laravel Scout Sonic Driver](https://github.com/james2doyle/laravel-scout-sonic) and you can also install it via composer with the following command:

```
composer require james2doyle/laravel-scout-sonic
```

You will need to add some extra config information to `config/scout.php` before you can use everything correctly. Just checkout the `README.md` because all the instructions are in there.
