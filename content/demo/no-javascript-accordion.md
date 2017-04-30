---
Title: "No Javascript CSS Accordion"
Description: "Build an Accordion with just CSS and no Javascript"
Date: "2012-10-17"
Category: "Demo"
Template: "post"
Keywords: ["no", "javascript", "accordion", "target", "css", "only", "codepen", "fiddle"]
---

I made this today. It's a little CSS-only accordion. It uses the `:target` selector. The `:target` selector is rather new. It also has some quirks. It is almost like an onclick without the javascript.

<div class="center">
  <img src="http://ohdoylerules.com/content/images/Screen-Shot-2012-10-17-at-1.54.00-PM11.png" alt="no-js accordion" >
</div>

The thing I find is that the name is being passed through the URL when using this method. This is nice when you want to refresh the page and keep the same item active. But that is also a downside because maybe when you refresh you want everything to reset. In that case, you would need to delete the variable/id out of the URL and then refresh.

But just [check it out](http://codepen.io/james2doyle/pen/tgxDr "no-js accordion") already!
