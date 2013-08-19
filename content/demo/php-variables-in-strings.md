/*
Title: PHP Variables in strings
Date: 2013-03-21
Category: Demo,Fiddle,Web
Template: post
Keywords: 
*/

I have been getting quite annoyed lately when escaping a string to
output a PHP variable. So I decided to make a little test so I could see
what the best way to tackle this was.

~~~~ {.prettyprint .lang-php title="PHP Variables in strings"}
// tested on PHP 5.4.4
$var = "variable value";
echo "tell me the ".$var." please"; // variable value
echo "tell me the ",$var," please"; // variable value
echo "tell me the $var please"; // variable value
echo "tell me the {$var} please"; // variable value
echo 'tell me the ',$var,' please'; // variable value
echo 'tell me the $var please'; // $var
echo 'tell me the {$var} please'; // {$var}
~~~~

Maybe I am a little dumb for not knowing this. But I would always escape
my strings like:

~~~~ {.prettyprint .lang-php title="PHP Variables escape in string"}
echo "my little ".$var." went to the market.";
~~~~

when I could have just used "\$var" with double quotes... Everything in
single quotes is treated as a plain string and anything with double is
interpreted. I saw something saying that some of these will not output
properly in older versions of PHP.
