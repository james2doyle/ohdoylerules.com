---
Title: "PHP WebSocket Chat"
Description: "PHP websocket chat application example"
Date: "2014-02-08"
Category: "Personal Project"
Template: "post"
Keywords: ["php", "websocket", "html5", "socket", "long poll", "interval", "ajax", "post", "get"]
---

About 6 months ago, I made a little [socket.io chat app](https://github.com/james2doyle/socket-chat-example). At the time, this was really only possible with Node.js because the [HTML5 WebSocket support](http://caniuse.com/#feat=websockets) was too low.

But now, months later, the support for WebSockets is actually very good.Looking at [caniuse.com](http://caniuse.com) right now, there is better support for WebSocket than there is WebGL. I would argue that WebGL support is actually more important than the WebSocket support, but I digress. Here is a non-jargon-laden explanation from [HTML5Rocks](http://www.html5rocks.com/en/tutorials/websockets/basics/#toc-introduction-sockets):

> The WebSocket specification defines an API establishing "socket" connections between a web browser and a server. In plain words: There is an persistent connection between the client and the server and both parties can start sending data at any time.

Here is a little more technical explanation.

> A WebSocket creates a TCP connection to server, and keeps it as long as needed. The Server or client can easily close it. It uses Bidirectional communication - so server and client can exchange data both directions at any time. It is very efficient if the application requires frequent messages. WebSockets have data framing that includes masking for each message sent from client to server so data is simply encrypted.

If you want a technically in-depth overview, checkout [websocket.org](http://www.websocket.org/quantum.html).

Anyway, I made a [little chat app](https://github.com/james2doyle/php-socket-chat) with [Ratchet](http://socketo.me/). People knock PHP for all the bad things it does. But getting the WebSocket example running, actually wasn't that bad. Apparently Apache doesn't play nice with Ratchet (not sure about *pure* WebSockets) so you have to use the [built-in PHP server](http://www.php.net/manual/en/features.commandline.webserver.php) which comes with PHP 5.4.

<div class="center">
  <a href="http://ohdoylerules.com/images/php-socket-animation.gif" target="_blank" title="php ratchet socket server form example"><img alt="php ratchet socket server form example" src="http://ohdoylerules.com/images/php-socket-animation.gif" width="252" height="246" ></a>
</div>

The app I made is pretty much a copy paste from the [Rachet Hello World Example](http://socketo.me/docs/hello-world) but tried to make the simplest chat app I could. The server is actually pretty close the Hello World code, just with a bunch of extra client-side javascript.

Once you [download the app](https://github.com/james2doyle/php-socket-chat), if you have PHP properly installed and in your path, you can use `php bin/chat-server.php` in the root folder to start the server. You can then hit the index page and see the green connection message. You will also see some information in your terminal.

You can then open a new browser (or incognito/private window) and "create" another user to chat with.

You can see your messages going back and forth. Pretty slick. With the way I develop things at [WARPAINT Media](http://warpaintmedia.ca), I really can't wait to create some sites and apps that use the WebSocket server.