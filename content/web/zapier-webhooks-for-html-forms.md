+++
title = "Using Zapier Webhooks for HTML forms"
date = "2019-09-28"
category = "Web"
template = "post.html"
description = "You can use Zapier webhooks to handle HTML form submissions - if you know how to set up your form"
[taxonomies]
keywords = ["zapier", "webhook", "html", "form", "post", "hook", "submit", "static", "headless"]
+++

If you don't know about [Zapier](https://zapier.com/), it's a service that allows you to "automate everything". I've been using it for over 4 years to automate tons of different things like posting daily Trello tasks to Slack, activity in Intercom to Emails, and even a custom scheduled job that gives me task information for the current day.

One of the best built-in zaps (that's what they call the tasks) is the [webhook zap](https://zapier.com/app-directory/webhook/integrations) which let's you send a `POST` request to Zapier and then connect that with the 100s of other integrations. You can use this for all types of things. One thing I have found it to be good for is handling form submissions on static sites.

As the concept of static sites and "serverless" keeps getting more and more popular, so do the services surrounding those concepts. But if you know where to look, and how to set things up, most of those "services" that supplement static sites can be replace with some savvy Zapier setups.

There are tons of "form" apps out there to allow you to create endpoints for your site to submit to. A lot of them even suggest using Zapier to handle the post-submission step. It's funny, because you can get a pretty robust setup just using Zapier on it's own and not having to use these services. Also, Zapier supports file uploads! So you can even handle attachments in your forms or `POST` request. Handy!

Anyway, on to the form. Here is an example of an HTML form that will successfully:

```html
<form action="https://hooks.zapier.com/hooks/catch/1234567/abcd123/"
  method="post"
  enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email">
    <label for="attachment">Attachment:</label>
    <input type="file" name="attachment" id="attachment">
    <input type="submit" name="submit" value="Submit">
</form>
```

Let's break down the content above and talk about the details.

##### Action

Pretty straightforward. This is the URL of your webhook. You get this after you create the zap for the first time.

##### Method

Obviously, we need this to be a `POST` since that is what the webhook is expecting. Nothing special here.

##### Enctype

Here is the weird part. If you are familiar with file uploads, you already know that in order to properly handling files, you need to make sure your request is using the correct encoding. Here is a description from the [HTML Spec](https://www.w3.org/TR/1999/REC-html401-19991224/interact/forms.html#adef-enctype):

> This attribute specifies the content type used to submit the form to the server (when the value of method is "post"). The default value for this attribute is "application/x-www-form-urlencoded". The value "multipart/form-data" should be used in combination with the INPUT element, type="file".

So there you go. Use this for files.

##### Caveats

One thing to keep in mind is, like all forms, the `name` of each field will be assign that value that was used on submission. So you can't really handle dynamic fields with Zapier. You also don't have any validation other than the HTML validation (or javascript validation, if applied) to rely on. People could submit values you don't expect or mess with the rules and submit other things you aren't expecting.

Something to keep in mind. I wouldn't use this method for anything other than simple contact forms that send emails or maybe forms that fill rows in a spreadsheet or something. Basic stuff.
