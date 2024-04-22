+++
title = "Use Your Numberpad To Control Google Hangouts/Meet"
date = "2023-03-10"
category = "Tricks"
template = "post.html"
description = "Using Hammerspoon to create shortcuts on a number pad that can control Google Hangouts/Meet"
[taxonomies]
keywords = ["hammerspoon", "number", "pad", "shortcuts", "lua", "google", "hangouts", "meet", "toggle", "mute"]
+++

### The number pad

Number pads can be pretty handy. Not just for accountants or spreadsheet junkies. Did you know that the keys on a number pad register in their own way? If your number pad is setup right, pressing a `1` on your keyboard number row and pressing `1` on your number pad, will be different keys. I have a bunch of my number keys on my number pad set to control the window positions on my desktop.

I also use the `0` key and the `.` key to control Google Hangouts/Meet. Read more to find out how.

### Hammerspoon

If you aren't using [Hammerspoon](https://www.hammerspoon.org/) on OSX, you are missing out! It has some great features! I will write some more articles on using Hammerspoon to control your Apple trackpad and also tricks with "hyper" keys to control your desktop.

Back on track. These are all the keys on the number pad that Hammerspoon will treat as "unique":

```
pad., pad*, pad+, pad/, pad-, pad=,
pad0, pad1, pad2,
pad3, pad4, pad5,
pad6, pad7, pad8, pad9,
padclear, padenter
```

This means you can bind functionality to those keys without them also applying to the number row. Cool, right?

### Switch to Google Hangouts/Meet

The following code is used to focus Chrome and then switch to the hangouts tab when `pad0` is pressed:

```lua
local shortcutsLogger = hs.logger.new('shortcuts/shortcuts','debug')

-- "pad0" -- focus the Chrome, switch to the hangouts tab
hs.hotkey.bind({}, "pad0", "Focus Hangouts", function ()
  shortcutsLogger:d("[pad0] pressed")
end, function ()
  shortcutsLogger:d("[pad0] released")
  local win = hs.appfinder.appFromName("Google Chrome")
  win:activate()
  -- @see https://www.hammerspoon.org/docs/hs.eventtap.html#keyStroke
  hs.eventtap.keyStroke({"cmd","shift"}, "A", 300, win)
  -- needed in order to use the tab search
  hs.timer.doAfter(0.3, function()
    hs.eventtap.keyStrokes("meet", win)
    hs.timer.doAfter(0.2, function()
      hs.eventtap.keyStroke({}, "Return", 100, win)
    end)
  end)
end, function ()
  shortcutsLogger:d("[pad0] repeated")
end)
```

You can see that we do need to "wait" a bit between key presses in order to make sure we are triggering things properly.

One of the great things about using `cmd+shift+A` is that it will find **tabs across windows**. This means you can have multiple windows open or even multiple desktops and it should still work!

### Switch to Google Hangouts/Meet

I have another shortcut setup on `pad.` that will switch to the hangouts tab and toggle "mute":

```lua,hl_lines=15-18
-- "pad." -- focus the Chrome, switch to the hangouts tab, toggle mute
hs.hotkey.bind({}, "pad.", "Toggle Hangouts Mute", function ()
  shortcutsLogger:d("[pad.] pressed")
end, function ()
  shortcutsLogger:d("[pad.] released")
  local win = hs.appfinder.appFromName("Google Chrome")
  win:activate()
  -- @see https://www.hammerspoon.org/docs/hs.eventtap.html#keyStroke
  hs.eventtap.keyStroke({"cmd","shift"}, "A", 300, win)
  -- needed in order to use the tab search
  hs.timer.doAfter(0.3, function()
    hs.eventtap.keyStrokes("meet", win)
    hs.timer.doAfter(0.2, function()
      hs.eventtap.keyStroke({}, "Return", 100, win)
      -- presses this combo after the tab is in focus
      hs.timer.doAfter(0.3, function()
        hs.eventtap.keyStroke({"cmd"}, "D", 100, win)
      end)
    end)
  end)
end, function ()
  shortcutsLogger:d("[pad.] repeated")
end)
```

Those added lines trigger the keyboard shortcut that will toggle mute in hangouts.

### Different browsers?

If you want to modify the code above to work in other browsers, just change the line for `hs.appfinder.appFromName("Google Chrome")` to your browser. You will also need to figure out what the key combo is for finding tabs in that browser.

In Firefox, for example, you can search the open tabs using `%` in the search bar. So you would need to do something like the following:

```
1. cmd+L (activate the search bar)
2. % (start the tab search)
3. "meet" (type meet into the bar)
4. Return (press enter to go to the tab)
```

This is just a list of possible steps. Try it yourself and report back to me!
