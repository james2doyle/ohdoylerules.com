+++
title = "Generated content in CSS"
description = "How to use Generated content in CSS"
date = "2012-07-27"
category = "Fiddle"
template = "post.html"
[taxonomies]
keywords = ["generated", "content", "css", "css3", "attr", "pseduo", "elements"]
+++

I like [jsFiddle](http://jsfiddle.net/ "jsFiddle"). I often use it for prototyping. I might want to see what I can make in css or maybe I want to build a little template. A perfect example, I used it to mockup my [work](https://ohdoylerules.com/work/ "Work") section. Since it is just a repeating template, I built the classes and styles in jsFiddle and then just dropped in the php echos. Anyway, here is something I made. It uses generated content. You can use HTML attributes in CSS. This is a classic example:

```css
/* styles for printing */
@media print{
    /* all a tags with an href attribute */
    a[href]:after{
        /* display that href after the value */
        content: " (" attr(href) ")";
    }
}
```

What does this look like?

```html
Website
```

Would render as [Website (www.example.com/)](www.example.com/)

So with that in mind, I thought it would be cool to have a button that
would render a count. So in practical applications it might be used for
something like an inbox button. In the case I built it is a
notifications button.

<div class="center">
  <a href="http://jsfiddle.net/james2doyle/LjgzD" target="_blank" title="notifications button"><img src="/images/54368011.png" alt="notifications button"></a>
</div>

```css
button {
    color: #333;
    padding: 4px 10px;
    border: 1px solid #aaa;
    outline: none;
    font-weight: bold;
    font-size: 12px;
    font-family: 'Corbin';
    background: #eee;
    border-radius: 3px;
    box-shadow: 0 2px 0 rgba(0,0,0,0.5);
    text-shadow: 0 1px 0 rgba(255,255,255,0.8);
}

button:after {
    content: attr(data-count);
    border-radius: 10px;
    display: inline-block;
    background: #777;
    padding: 2px 5px;
    width: 15px;
    margin: 0 0 0 8px;
    color: white;
    font-weight: normal;
    border: 1px solid #555;
    box-shadow: inset 0 1px 2px rgba(255,255,255,0.5),
        inset 0 -1px 2px rgba(0,0,0,0.5);
    text-shadow: 0 1px 0 rgba(0,0,0,0.6);
}​
```

```html
Notifications​
```

If you would like to see that bad boy in action check out [this
fiddle](http://jsfiddle.net/james2doyle/LjgzD/ "jsFiddle css content").
