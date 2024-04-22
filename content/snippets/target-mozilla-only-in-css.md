+++
title = "Target Mozilla-only in CSS"
description = "Target Mozilla-only in CSS"
date = "2012-10-11"
category = "Snippets"
template = "post.html"
[taxonomies]
keywords = ["CSS", "document", "firefox", "media queries", "mozilla", "url-prefix"]
+++

I had some issues in Firefox recently. I was building a complicated “item” in CSS and it looked great in Chrome. I got an email later saying that the sizing was all off for a bunch of things. I thought this was really strange. I went back to the CSS and Chrome and I could not see any issues.

I then fired up Firefox and, yikes! There was a bunch of weird issues. This is strange because normally Chrome to Firefox translates pretty well. I was using the `::first-letter` element and a few `::before` elements. But somehow, someway they got messed up. Anyway, I discovered this little snippet:

```css
@-moz-document url-prefix() {
  /* firefox only styles */
}
```

It works. But what does it mean? The url-prefix() is a way to serve specific styles to a specific URL. In this case, I just want to target a -moz- device. [Here is a more in depth definition](https://developer.mozilla.org/en-US/docs/CSS/@document?redirectlocale=en-US&redirectslug=CSS%2F%40-moz-document "MDN @Document"). This worked nicely, and so it will stay into production.