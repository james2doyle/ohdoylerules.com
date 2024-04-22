+++
title = "Copy filepath to clipboard in OSX"
description = "How to copy a filepath to the clipboard in OSX"
date = "2014-07-10"
category = "Snippets"
template = "post.html"
[taxonomies]
keywords = ["osx", "apple", "mavericks", "10.9.3", "applescript", "automator", "finder", "clipboard", "copy", "paste", "shortcut"]
+++

At [WARPAINT](http://warpaintmedia.ca "WARPAINT Media"), we use [Dropbox](https://www.dropbox.com "Dropbox Homepage") for collaborating on our files. This is awesome, but a lot of the times you get some pretty nasty file paths. Especially when you are trying to guide someone to a place where you saved a file.

I wanted to solve this problem by creating an AppleScript service that would allow everyone to **Copy the selected file's path to the clipboard**. Here is how I did it.

+++

We are going to be using [Automator](http://en.wikipedia.org/wiki/Automator_(software)) to create a new service. Here is the description of Automator in case you don't know what it is:

> Automator is an application developed by Apple Inc. for OS X that implements point-and-click (or drag and drop) creation of workflows for automating repetitive tasks into batches for quicker alteration, thus saving time and effort over human intervention to manually change each file separately.

So the first thing is to open Automator and create a new service. Like so:

<div class="center">
  <a href="/images/clipboard-1.png" target="_blank" >
    <img src="/images/clipboard-1.png" width="720" />
  </a>
</div>

Then you need to select `files or folders` for "Service receives selected" and choose `Finder.app` for the second option. The do a search for `applescript` and drag the `Run AppleScript` choice into the window on the right.

You will need to paste the following code into the AppleScript window:

```applescript
tell application "Finder"
  set sel to the selection as text
  set the clipboard to POSIX path of sel
end tell
```

When that is all done, it should look something like this.

<div class="center">
  <a href="/images/clipboard-2.png" target="_blank" >
    <img src="/images/clipboard-2.png" width="720" />
  </a>
</div>

Go to `File > Save` or press `⌘S`. **Do not Save-As**. Enter in `Copy Path To Clipboard` as the name. *It shouldn't ask for a location*, it will just show an input field. This is perfectly fine.

Now open a new finder window and go to `Finder > Services > Services Preferences...` or `System Preferences > Keyboard > Shortcuts`. Select services on the left menu if it isn't already and scroll down to find `Copy Path To Clipboard`. This will open a window like this:

<div class="center">
  <a href="/images/clipboard-3.png" target="_blank" >
    <img src="/images/clipboard-3.png" width="720" />
  </a>
</div>

Click on that item and make sure it is checked off, it should be by default. Then add a shortcut by clicking on the right side where it says "add shortcut". I made mine `⌃⌘\`. But if you have [Alfred.app](http://www.alfredapp.com/) that might conflict with it's copy feature. So you choose.

<div class="center">
  <a href="/images/clipboard-4.png" target="_blank" >
    <img src="/images/clipboard-4.png" width="720" />
  </a>
</div>

You can use these steps to run any AppleScript on a file you choose. Pretty slick!

Now when you have a file of folder selected in the Finder, you can right-click, go to Services, and select `Copy Path To Clipboard`!

<div class="center">
  <a href="/images/clipboard-5.png" target="_blank" >
    <img src="/images/clipboard-5.png" width="646" />
  </a>
</div>

