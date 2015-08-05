/*
Title: Simple PHP JSON Response
Description: Create a simple JSON response using PHP
Date: 2015-07-04
Category: Snippets,Web
Template: post
Keywords: PHP, json, response, headers, status, encoding, parse, stringify
*/

This is little snippet I use all the time when I am building simple flat sites that need a single route for an AJAX request.

There are a couple of things you need to do in order to create a proper JSON response.

#### Use json_encode

If you are really new to PHP, you may not have found [json_encode](http://php.net/manual/en/function.json-encode.php#refsect1-function.json-encode-examples). If that is the case, then look it up right now.

This function converts PHP arrays, strings, and objects, into a JSON safe string. This makes it simple for you to create safe responses that can be handled by your javascript.

#### Use Content-Type

This is usually the magic command that allows you to *receive* JSON from your script. If you don't set the header, PHP will simple return a string. Then in your javascript, you have to use `JSON.parse` in order to get the object that javascript can use.

```php
header('Content-Type: application/json');
```

No more strings! The request is now treated accordingly and is parsed for you. I am sure everyone has encountered this in the beginning.

#### Use Status

Here is another header that you need to set in order for things to work smoothly. By setting the status, you can tell your javascript, as well as your browser, what the status of the request it. By default, the requests are treated as `200 OK`. So although you may have sent a response with a failing message, with setting a failed status (usually 300 codes and above) the browser, and your javascript, think everything is fine.

```php
header('Status: 400 Bad Request');
```

This becomes very apparent in jQuery when using `$.get` or `$.post`. If you are using a Promise style request (using `$.get().then( ... )`), your error handler never gets called.

If you want to find the perfect header for your fantastic error, check out the Wikipedia for the [HTTP status codes](https://en.wikipedia.org/wiki/List_of_HTTP_status_codes).

#### Example

Here is an example of a simple script I might use when testing an AJAX response, or when building a flat-file site. I would place this somewhere in my websites directory, and then hit it directly with an AJAX request.

If my local path to my site was `http://localhost:8888/website`, I would save this script as `json.php`. Then I would then use the following jQuery to test the script:

```
$.get("http://localhost:8888/website/json.php")
.done(function(response){
  console.log(response);
});
```

If everything was organized correctly, I should get a successful response with the information I wanted.

Here is the script:

<script src="https://gist.github.com/james2doyle/33794328675a6c88edd6.js"></script>

You could always add more HTTP status codes, or use different key names for the array response. I like `status` and `message` because I may have a successful response, but I know something else went wrong when the `status` is false. I usually put whatever data I need in `message`. If message is a string, I know there is actually a message and not data I need to handle.