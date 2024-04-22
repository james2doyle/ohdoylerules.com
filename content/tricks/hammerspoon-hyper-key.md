+++
title = "Hammerspoon hyper key"
description = "Use Hammerspoon to create hyper key shortcuts to automate window focus"
date = "2024-04-21"
category = "Web"
template = "post.html"
[taxonomies]
keywords = ["lua", "hammerspoon", "hyper", "osx", "automation"]
+++

If you aren't using [Hammerspoon](https://www.hammerspoon.org/) on OSX, you are missing out!

It has some great features that you can use to control your desktop, automate tasks, build small UIs and toolbar apps. It can also trigger key presses and modifiers like shift, alt, etc.

Here is the script I use to create "hyper" key shortcuts. If you aren't aware, the hyper key is a modifier key that combines the Shift, Control, Alt, and Command/Windows keys simultaneously. Then you can press a regular key and use that for shortcuts.

I wrote an article a while back to ["Use Your Numberpad To Control Google Hangouts/Meet"](/tricks/hammerspoon-number-pad-shortcuts/) which is pretty handy. It uses a similar trick to play out a combination of keys and trigger actions in Chrome.

The script below watches the keyboard for the hyper key + another key. In the script below, I just bind the hyper key + some letter keys to trigger apps to focus.

```lua
-- verbose logging
-- hs.logger.setGlobalLogLevel(5)
local hyperKeyLogger = hs.logger.new('hyperkey','debug')

-- a table of mapping single keys to the apps they open/switch to
local hyper_key_shortcuts = {}
hyper_key_shortcuts["C"] = "Google Chrome"
hyper_key_shortcuts["F"] = "Finder"
hyper_key_shortcuts["S"] = "Sublime Text"
hyper_key_shortcuts["T"] = "WezTerm"
hyper_key_shortcuts["W"] = "WhatsApp"
hyper_key_shortcuts["Z"] = "Zed"
-- you can add some more apps here

-- sort through all the items in the table and add the listeners for them
for key,title in hs.fnutils.sortByKeys(hyper_key_shortcuts) do
  hs.hotkey.bind({"cmd","ctrl","option","shift"}, key, title, function ()
    hyperKeyLogger:v("[hyper "..key.."] pressed")
  end, function ()
    hyperKeyLogger:v("[hyper "..key.."] released")
    -- @see https://www.hammerspoon.org/docs/hs.application.html#open
    -- this will open the app if it is closed, or focus it if it is open
    hs.application.open(title)
  end, function ()
    hyperKeyLogger:v("[hyper "..key.."] repeated")
  end)
end
```
