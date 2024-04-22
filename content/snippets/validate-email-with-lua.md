+++
title = "Validate Email With Lua"
description = "A verbose email validation function for Lua"
date = "2015-09-06"
category = "Snippets"
template = "post.html"
[taxonomies]
keywords = ["Lua", "valid", "email", "address", "test"]
+++

Checking if an email is valid should be easy, right? WRONG.

This took about 3-4 hours to finally get. I scoured the web for a good email validation function. But, I was unable to find any that actually handled all the valid email variations.

If you didn't know, the [spec for email](https://en.wikipedia.org/wiki/Email_address#Examples) is actually pretty complex. It allows a lot more than just a web-safe prefix and a domain sandwiched between an `@` symbol. You can use quotes, brackets, escapes, and more `@` symbols.

Looking at the results that Wikipedia gives me for emails that should fail or pass a validation, I knew this would require more than just a simple pattern match.

Here is the final product. I added some nice comments to explain some of the rules as well.

{{ gist(src="https://gist.github.com/james2doyle/67846afd05335822c149.js") }}

You can see there is a lot more logic than expected. I also made this function have multiple returns.

If the email passes the function returns `true` and `nil`, but if it fails, it will return `nil` and the reason that the validation failed. Pretty slick!

Anyway, this was a tedious task. So go forth and leverage my pain in your next form submission.
