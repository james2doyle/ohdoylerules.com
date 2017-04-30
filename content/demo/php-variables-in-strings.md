---
Title: "PHP Variables in strings"
Description: "A list of all the ways you can put PHP Variables in strings"
Date: "2013-03-21"
Category: "Demo"
Template: "post"
Keywords: ["php", "variables", "string", "interpolation", "vars", "in", "text", "render"]
---

I have been getting quite annoyed lately when escaping a string to output a PHP variable. So I decided to make a little test so I could see what the best way to tackle this was.

```php
// tested on PHP 5.4.4
$var = "variable value";
echo "tell me the ".$var." please"; // variable value
echo "tell me the ",$var," please"; // variable value
echo "tell me the $var please"; // variable value
echo "tell me the {$var} please"; // variable value
echo 'tell me the ',$var,' please'; // variable value
echo 'tell me the $var please'; // $var
echo 'tell me the {$var} please'; // {$var}
```

Maybe I am a little dumb for not knowing this. But I would always escape my strings like:

```php
echo "my little ".$var." went to the market.";
```

when I could have just used "\$var" with double quotes... Everything in single quotes is treated as a plain string and anything with double is interpreted. I saw something saying that some of these will not output properly in older versions of PHP.
