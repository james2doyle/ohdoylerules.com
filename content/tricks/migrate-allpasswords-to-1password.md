/*
Title: Migrate AllPasswords To 1Password
Description: How to import your allpasswords csv into 1password
Date: 2014-10-11
Category: Tricks
Template: post
Keywords: 1password, allpasswords, export, import, csv, format, osx
*/

[AllPasswords](https://itunes.apple.com/ca/app/allpasswords-handy-personal/id588258846?mt=12) is an awesome, free, app for [iPhone](https://itunes.apple.com/ca/app/allpasswords/id578246311?mt=8) and [OSX](https://itunes.apple.com/ca/app/allpasswords-handy-personal/id588258846?mt=12). It has a nice, simple interface, there is an awesome password generator, and it has iCloud sync.

The problem is, I recently bought an iPhone 6 and updated to iOS 8. It seems that the iCloud sync has busted for AllPasswords, at least on my device. With the advent of the [1Password app getting a free version](http://bgr.com/2014/09/17/1password-for-ios-free-download/) I decided it might be time to switch. 

I have about 130 logins in AllPasswords, so I wasn't about to manually enter in each account. Instead, I had to format the exported CSV from AllPasswords to be able to import into 1Password. Here is how I did it:

### AllPasswords Export Format

> Title, Username, Password, URL, Notes

The above line is the export format for AllPasswords.

Now this isn't going to work when you try to import it into 1Password. You will need to do some *massaging* of the CSV to get it to work properly.

Here is an export example:

> ODR PW,super_cool_guy,ilovepuppies5000,http\://ohdoylerules\.com,"This is a fake entry"

Here is one that is less ideal, or maybe had some info missing:

> ODR PW,super_cool_guy,ilovepuppies5000,,

### 1Password Import Expectations

> "Title","Location (URL)","Username","Password","Notes"

Now we need to put our CSV in this format. We need to *wrap the sections in quotes*, and we need to make sure that the *empty fields are just empty quotes*.

Here is how we would arrange those 2 examples from before.

> "ODR PW","http\://ohdoylerules\.com","super_cool_guy","ilovepuppies5000","This is a fake entry"

Here is the ugly one, and how to fix it:

> "ODR PW","","super_cool_guy","ilovepuppies5000",""

### Finding Issues

When you are trying to import, you will notice that 1Passwords gives no feedback on what is wrong with the CSV, it will just deny the import.

The trick is to go through the file and make sure there are *5 sets of quotes*. That is what helped me.

So far I have been very happy with 1Password. It seems like a really solid app. I opted for Dropbox as the sync storage, and I downloaded the Chrome extension that will prompt me for pasting or saving of logins.




