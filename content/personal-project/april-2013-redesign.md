/*
Title: April 2013 Redesign!
Date: 2013-04-17
Category: Personal Project,Snippets,Web
Template: post
Keywords: april, 2013, redesign, ohdoylerules, james2doyle, website, generated, content, css3, ie7
*/

Another redesign. This one is completely by me, with a little help from the [html5blank](http://html5blank.com "html5blank wordpress theme") Wordpress template. I am using SVGs exclusively. Although I only have 2 images for the entire site, the logo and the mobile nav hamburger/menu button. I think the best part is the new code highlighter. It has some cool features.

    // here is some javascript
    var item = document.getElementById('#item');
    item.style.background = 'red';
    item.setAttribute('data-index', 1);

There it is. If you inspect you will see something, strange. I used the new CSS3 generated content. It allows you to use element attributes as css content attributes. Here is the special CSS for prettyprint, highlighted with prettyprint. How meta.

    pre[title]:before {
      font-family: 'Source Code Pro',monospace;
      font-weight: 700;
      display: block;
      position: relative;
      top: -10px;
      left: -25px;
      content: attr(title);
      width: auto;
      height: 20px;
      color: #FFF;
      padding: .1em 1.5em .3em;
      background: #91B6C7;
      text-shadow: 0 1px 0 rgba(0, 0, 0, .3);
      -webkit-box-shadow: 2px 2px 4px rgba(0, 0, 0, .2);
      box-shadow: 2px 2px 4px rgba(0, 0, 0, .2);
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

The special part of this style is the `content: attr(title);`. This grabs the title attribute, and its value, and sets it as the content. This is pretty cool. Also the support is high, IE7 and down. Let me know what you think in the newly enabled comments section!
