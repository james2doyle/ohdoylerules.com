---
Title: "Create JSON Sections In Shopify"
Date: "2020-01-05"
Category: "Web"
Template: "post"
Description: "A demo on how to create a section in Shopify that returns JSON and HTML"
Keywords: ["shopify", "theme", "editor", "builder", "section", "JSON", "render", "liquid"]
---

If you're like me, you're probably constantly running into issues with the flexibility of Shopify themes. There are a lot of issues that come up when trying to squeeze in features and functionality that are "shop-adjacent". Shopify does a good job at running a store but it can be difficult to reach beyond that and make some more interactive experiences.

Recently, I wanted to share the content from one section on one page to another section on another page. This isn't really possible using liquid because you can't pass variables to sections. So even including them both on the same page wouldn't work. You also can't include sections in other sections. So that also won't work.

So how can you pass data between sections? Well, I managed to get this done by using the [Section Rendering API](https://help.shopify.com/en/themes/development/sections/section-rendering-api). Now, this is not something in liquid, but it can be used as a JS API. Specifically, you can render a section in isolation and without the surrounding page content.

Now, since you can call this API in JS, how would you use this content? You can just go ahead and use it as HTML, but I wanted to use it as JSON. How do we do that? How can we make sure the section works normally when rendered on a page but returns "JSON" when rendered through the section API?

Well, this is possible by taking advantage of the "page state" when being called via the API.

Here is an example of the if statement required:

```liquid
{% comment %}https://help.shopify.com/en/themes/development/sections/section-rendering-api{% endcomment %}
{% comment %}request.page_type will be "index" when using the section rendering API{% endcomment %}
{%- if request.page_type == 'index' -%}
{
  {%- for block in section.blocks -%}
    {%- assign slug = block.settings.title | downcase -%}
    "{{ slug }}": {{- block.settings | json -}}{%- unless forloop.last -%},{%- endunless -%}
  {%- endfor -%}
}
{%- else -%}
  {%- for block in section.blocks -%}
    {%- assign slug = block.settings.title | downcase -%}
    <div id="{{ slug }}">{{ block.settings.title }}</div>
  {%- endfor -%}
{%- endif -%}
```

As you can see from the comment, `request.page_type` will be equal to `"index"` when rendered via the API. This means, we can use that state to return a string of JSON.

When this is returned from the section API, it will still be treated as HTML and wrapped with markup. It will look something like this:

```html
<div id="my-section-id" class="shopify-section">
{
  "my-block-title": {"title": "My Block Title", "subtitle": "This is my subtitle"},
  "second-block-title": {"title": "Second Block Title", "subtitle": "This is my second subtitle"}
}
</div>
```

As you can tell, you can't just `JSON.parse` this. It has text inside that will bust up our JSON parser. How can we confidently parse the content inside the `div` and get that sweet schema in the center?

Let me introduce the [DOMParser API](https://developer.mozilla.org/en-US/docs/Web/API/DOMParser). This is a [well-supported](https://caniuse.com/#feat=xml-serializer) API that will allow you to parse different types of structured documents.

In this case we are going to treat this content as `text/html` (which it is) and then use other DOM APIs to extract the JSON from the wrapper `div` surrounding it.

Here is the little function I came up with to fetch the rendered section, parse the content as HTML, extract the JSON inside, and return the object it contains.

See below:

```js
/**
 * Get section from the rendering API
 * @see https://help.shopify.com/en/themes/development/sections/section-rendering-api
 *
 * @param {string} section
 *
 * @returns {Promise<Object>}
 */
async function getSection(section) {
  try {
    // call the rendering API
    const data = await (await fetch(`/?section_id=${section}`)).text();
    // create a DOMParser and get the inside content of the section
    const parser = new DOMParser();
    const node = parser.parseFromString(data.toString(), 'text/html').querySelector('.shopify-section');
    if (!node) {
      console.error('No node found in', data);

      return {};
    }

    const content = (node.textContent || '').trim();

    // parse that content as JSON
    return JSON.parse(content);
  } catch (e) {
    console.error(e);
  }

  return {};
}
```

Nice, right? Pretty simple! We pass a string that represents the file name of the section we want to render, pass that to our DOMParser parse method, fetch the wrapper `div`, grab the text content inside, and pass that all to `JSON.parse`.

This seems strange _but it really works!_ It works really really well!

```js
// usage:
getSection('name-of-section-template-file')
.then((data) => {
  // do stuff with the object...
});
```

That is how you use this function. Just pass in the filename of the section template (without the `.liquid` on the end) and you will get JSON back! The best part about this is that it still works with the normal HTML. So you can use this in both cases without any issues. This whole setup allows website admins to visually design JSON output for your more complex features.

*Side Note*

Shopify likes to change things up every once in a while. They recently [deprecated the `include` tag in favour of a new `render` tag](https://developers.shopify.com/changelog/deprecating-the-include-liquid-tag-and-introducing-the-render-tag). So there is no promise this will work forever.

_You have been warned!_
