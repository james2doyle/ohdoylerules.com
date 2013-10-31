/*
Title: Simple HTML5 Notifications
Description: Simple HTML5 Notifications
Date: 2013-08-29
Category: Snippets,Web
Template: post
Keywords: html5, notification, notify, growl, javascript, api
*/

I was playing around with HTML5 Notifications the other day. They are pretty slick! It allows you to essentially send growl notifications to your desktop from the browser.

This little function would be used during an event to request permission for notifications and then display it with a simple abstraction of the native API.

```javascript
function notify(title, body, timeout) {
  timeout = (timeout) ? timeout : 3000;
  Notification.requestPermission(function () {
    var nf = new Notification(title, {
      body: body,
      iconUrl: "test.png"
    });
    nf.onshow = function () {
      setTimeout(function () {
        nf.close()
      }, timeout)
    };
  });
}
// usage
notify('My Title', 'My hot body with a bunch of lorem in it');
```

It will then ask for permission, if your page doesn't have it already, then show the notification. Right now it just shows a small grey box for the test image.

The last parameter is for a custom timeout. I like the default of 3 seconds but if you need to you can override it without modifying the function.