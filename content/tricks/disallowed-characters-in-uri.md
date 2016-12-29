/*
Title: Disallowed Characters In URI
Description: The URI you submitted has disallowed characters
Date: 2015-03-31
Category: Tricks
Template: post
Keywords: php, codeigniter, disallowed, characters, 400, error, paragraph ending, %E2%80%8B
*/

How to fix "The URI you submitted has disallowed characters" error.

Does this screenshot look familiar?

<div class="center">
  <a href="http://ohdoylerules.com/content/images/error-400-disallowed-characters.png" target="_blank"><img alt="codeigniter 400 error for disallowed characters" src="http://ohdoylerules.com/content/images/error-400-disallowed-characters.png" ></a>
</div>

Well, it has been killing me for the last 2 hours. I have encountered this error before, but I never realized what caused it, or how it was fixed. I would just try random stuff, entering in different content, moving different functions. Eventually it would go away...

### Symptoms

In this situation, whenever I would click on a particular link I got the error. I copied and pasted the URL from the browser into Sublime Text. It looked like this:

```
http://localhost:8080/website/page%E2%80%8B
```

What the heck? I never added those characters. They never showed in the browser URL, and trying to replace them in my code was not working.

I tried editing the entries in my database in order to remove the character. I deleted and edited each field. I even tried converting the character encoding and trimming the URL. *Nothing worked!*

I then read a post on the [PyroCMS Forum](https://forum.pyrocms.com/discussion/24142/does-pagesurl-return-with-disallowed-characters-for-you-too) that said there is probably a hidden character somewhere in the code. Well, I looked in my PHP and I didn't find anything, looking in my HTML there was nothing there either.

So what to do? When in doubt, *use vim*. I dusted off my vim and looked at the PHP file, nothing! Then I opened the HTML file...

**HEY! There is a tiny little hidden character in my HTML!!**

### The Fix

I removed the character and everything worked perfectly. Here is the diff after I removed the character:

<div class="center">
  <a href="http://ohdoylerules.com/content/images/hidden-character-diff.png" target="_blank"><img alt="git diff for hidden character" src="http://ohdoylerules.com/content/images/hidden-character-diff.png" ></a>
</div>

You can see there is a little trailing character there. I don't know exactly how this got in there, but god damn was it driving me crazy.

### In Summation

The real problem is, this *didn't show in Sublime Text* or in the *Chrome elements panel*. Even the commit on *Github* didn't show the hidden character I removed.

<div class="center">
  <a href="http://ohdoylerules.com/content/images/github-hidden-character-diff.png" target="_blank"><img alt="github diff for hidden character" src="http://ohdoylerules.com/content/images/github-hidden-character-diff.png" ></a>
</div>

The only way it would show up is when I opened the file in **vim**!