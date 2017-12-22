---
Title: "Slack Meta Data For URLs and Links"
Date: "2015-10-31"
Category: "Web"
Template: "post"
Description: "Tips to get Slack to resolve the correct meta data for your website URL"
Keywords: ["slack", "meta", "data", "website", "tag", "url", "link", "image", "issues", "fixes", "list", "test"]
---

If you use [Slack](https://slack.com/), then you have probably noticed the awesome feature they have for generating nice meta data whenever you paste a URL or an image.

<div class="center">
  <a href="/images/slack-example.png" title="Slack meta tag fetching example" target="_blank"><img alt="Slack meta tag fetching example" src="/images/slack-example.png" ></a>
</div>

That is pretty slick! So how does it know what to grab for us?

From the Slack website:

> It fetches as little of the page as it can (using HTTP Range headers) to extract meta tags about the content. Specifically, we are looking for <a target="_blank" href="http://oembed.com/">oEmbed</a> and <a target="_blank" href="https://dev.twitter.com/docs/cards">Twitter Card</a> / <a target="_blank" href="http://ogp.me/">Open Graph</a> tags. If a page's tags refer to an image, video, or audio file, we will fetch that file as well to check validity and extract other metadata.

I've never used *oEmbed*, so I am going to skip that.

Let's break down each part of the resulting meta fetch by Slack. Here is what we have, and the order it appears.

* WARPAINT Media (Site Title)
* Homepage | WARPAINT Media (Page Title)
* WARPAINT Media specializes in improving customer experience through marketing, design, analytics, and development. (Meta Description)

Now we can look at the Open Graph meta tags that are being used to generate these results:

```html
<meta property="og:site_name" content="WARPAINT Media">
<meta property="og:title" content="Homepage | WARPAINT Media">
<meta property="og:description" content="WARPAINT Media specializes in improving customer experience through marketing, design, analytics, and development.">
<meta property="og:image" content="http://warpaintmedia.ca/img/meta-image.jpg">
<meta property="og:url" content="http://warpaintmedia.ca">
```

Open Graph tags are pretty popular. The biggest user of Open Graph is Facebook. Here is the result when the link is shared on Facebook:

<div class="center">
  <a href="/images/warpaint-facebook.png" title="Facebook meta tag fetching example" target="_blank"><img alt="Facebook meta tag fetching example" src="/images/warpaint-facebook.png" ></a>
</div>

Make sure you test your tags using the [Facebook Open Graph Object Debugger](https://developers.facebook.com/tools/debug/og/object/). This will help you spot errors in your tags. If there are errors, **Slack will not load the content**. You need to have valid tags to make Slack work nicely.

How about the [Twitter Card](https://dev.twitter.com/cards/overview) meta tags?

```html
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Homepage | WARPAINT Media">
<meta name="twitter:description" content="WARPAINT Media specializes in improving customer experience through marketing, design, analytics, and development.">
<meta name="twitter:site" content="@warpaintmedia">
<meta name="twitter:creator" content="@warpaintmedia">
<meta name="twitter:url" content="http://warpaintmedia.ca">
<meta name="twitter:image:src" content="http://warpaintmedia.ca/img/meta-image.jpg">
```

As you noticed, there is no "site title" being set. You can also see in the screenshot that Twitter doesn't really care about the site title, they just show the page title. If that was something you wanted to adjust, then you would tweak the `twitter:title` tag to reflect what you wanted for a page title.

Now you may have copied these Twitter meta tags and pasted them in your site and filled in your information. That **will not work**. You need to use the [Twitter Card Validator](https://cards-dev.twitter.com/validator) to test, and then register, your account and URL.

When you
