---
Title: "Using Node.js in an AppleScript"
Description: "How to use Node.js in an AppleScript"
Date: "2014-07-12"
Category: "Snippets"
Template: "post"
Keywords: ["osx", "apple", "applescript", "automator", "finder", "node", "javascript", "js", "marked", "markdown", "md", "scpt"]
---

A few days ago, I wrote an article about [how to create a service in Automator to copy the selected file's path to the clipboard while in the Finder.app](https://ohdoylerules.com/snippets/copy-file-path-clipboard-osx "Copy filepath to clipboard in OSX").

I was playing around some more and thought it would be cool to be able to right click and convert a markdown file to HTML. This can be useful for lazy people who don't want to open and app or terminal just to convert.

> Here is the trick, you need absolute paths to node and the target module (or bin entry js file) file you are trying to run

Here is the code:

```applescript
-- setup some valid extensions for markdown files
property validExtensions : {"md", "markdown", "mdown"}
tell application "Finder"
  set theFile to item 1 of (get selection)
  -- check if the extension is correct
  if (the name extension of theFile is in the validExtensions) then
    set selectedItem to the selection as text
    set thePath to POSIX path of selectedItem
    -- created a quoted path in case there are special characters
    set nicePath to quoted form of thePath
    -- here is the trick, you need absolute paths to node and the target bin
    -- just tack on the extension for html
    do shell script "/usr/local/bin/node /usr/local/share/npm/bin/marked --gfm " & nicePath & " > " & nicePath & ".html"
    -- find out what the new file is called
    set outName to (do shell script "basename " & nicePath & ".html ") of result
    -- since there is no progress, let me know when your done
    display notification outName & " created successfully" with title "Markdown Conversion Finished"
    -- allow time for the notification to show
    delay 2
  else
    -- wrong file so show this
    display dialog "the file is not a valid Markdown file" with title "Conversion Error"
    -- allow time for the notification to show
    delay 2
  end if
end tell
```

Now this can be used in an *Automator Service*, which you can find out how to make in the [previous article](https://ohdoylerules.com/snippets/copy-file-path-clipboard-osx "Copy filepath to clipboard in OSX").

If you modify this for any other cool node tools, please let me know!

**PS**: Keep in mind that this doesn't iterate through multiple files. Only single files.

