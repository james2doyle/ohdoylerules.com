+++
title = "Tips For Using SVGs"
description = "I found using SVGs can be both amazing and extremely frustrating, so I have to share this information so no one looses their mind."
date = "2014-05-17"
category = "Web"
template = "post.html"
[taxonomies]
keywords = ["svg", "image", "pattern", "base64", "embed", "object", "safari", "issues", "viewbox", "requestAnimationFrame", "mask", "animations", "transitions"]
+++

I found using SVGs can be both amazing and extremely frustrating, so I have to share this information so no one looses their mind.

### Use Viewbox

This one is a little gem. The `viewBox` property allows you to set the dimensions of the image but it will also allow you can have responsive SVGs.

They maintain their ratios, but they will scale to 100% width and height. If you have an SVG that is 64 by 64, the syntax for the viewBox property would be `viewBox="0 0 64 64"`. Pretty simple. Just make sure you remove the width and height on the base SVG tag when using viewBox.

If you open an SVG in a new window, like opening a new file in the browser, you will notice that when zooming in, if `viewBox` property set properly, the image stays the same size. It won't zoom.

### Use base64 Images

So there are a couple ways you can embed an image in an SVG. I have found that the best way is to use a [base 64 encoded string](http://b1nary.ch/base64/ "embed base64 - easy, client side base64 encoder") as the image href.

```xml
<svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
  <defs>
    <pattern id="background-image" patternUnits="userSpaceOnUse" width="64" height="64">
      <!-- the width and height of the image should match the pattern, in most cases -->
      <image xlink:href="data:image/gif;base64,R0lGODdhQABAAOMAAMzMzJaWlr6+vqOjo8XFxZycnLGxsbe3t6qqqgAAAAAAAAAAAAAAAAAAAAAAAAAAACwAAAAAQABAAAAEpBDISau9OOvNu/9gKI5kaZ5oqq5s675wLM90bd94ru987//AoHBILBqPyKRyyRwSQk+bYDA5IDbT6rVGKAgmhSim+5WEbYbBQWItTBDwLSC9BrRthcHgGnaD/WZ6fF1cAQBdBAEFAXUAcBOJh2GKjDUBBAdUkpAFZxKXmRKENQedZaMAAwZpVaaigE2xsrO0tba3uLm6u7y9vr/AwcLDxMXGxxURADs=" x="0" y="0" width="64" height="64" id="svg-background" />
    </pattern>
  </defs>
  <g>
    <ellipse ry="32" rx="32" id="svg_1" cy="32" cx="32" fill="url(#background-image)"/>
  </g>
</svg>
```

This is what the [outputted image](/images/placeholder.svg) would look like.

*I'm using a very small gif so that the base64 string isn't giant*.

You can also see `viewBox` in action (try zooming). The reason I use this technique, is because it cuts down on requests but also cuts down on file size (for the most part). When you need to have multiple images inside the SVG, this works very well. Instead of having multiple requests (SVG, image1.jpg, image2.jpg, etc.) you get one request.

#### Note

---

For some reason, Safari does not like the following scenario: **an SVG, in an img tag, that has a base64 image in it**. I solved this problem, and this is how I did it.

I changed this:

```html
<img src="img/fun.svg" height="989" width="989">
```

To this:

```html
<object height="989px" width="989px" data="img/fun.svg" type="image/svg+xml"></object>
```

Then it worked. In an `img` tag, the image worked fine in all browsers, yes even IE (checked 11 and 10), but in Safari (7.0.3) it would not render. If I opened the SVG directly in a new tab, it worked fine. So there was some sort of reason that it would not render inside of an `img` tag. Annoying.

---

### Be Careful With Masks

Masking in SVG seems to be a magical mistress. I find sometimes it works wonderfully, and sometimes it is just wrong. Firefox is a pain with this one.

### Simple Is Better

Always check your files to make sure there aren't any hidden layers. Firefox, again, will punish you for this. I find a lot of SVG documents will have some strange layers that are just empty paths or unfilled objects. This usually is the product of using live trace.

### Text To Outlines

Always outline your text. Enough said. Without it, the person may see a font that you didn't intend. I would only use a system font if I had to make sure it stayed as text. A case for this might be dynamically creating SVGs on the fly or something.

### Use CSS Fo
