---
Title: "Using Browser Devtools To Improve Your Bug Reports"
Date: "2023-03-09"
Category: "Tricks"
Template: "posts"
Description: "How to improve your bug reports using the browser dev tools"
Keywords: ["browser", "devtools", "bug", "reports", "screenshots", "har", "console", "output", "chrome", "firefox", "safari", "edge"]
---

### Good bug reports

Reporting bugs can be very difficult when you are not a developer. How do you make sure the bug can be recreated? How do you avoid the "it works on my machine" rebuttal?

Well, we can greatly improve bug reports on web apps by using some simple tools built into the browsers we use every day.

### Easy Screenshots

Did you know you can [take screenshots of DOM nodes](https://developer.chrome.com/blog/new-in-devtools-62/#node-screenshots) right from the browser?

<div class="center">
  <a href="/images/1-devtools.png" target="_blank" title="take a node screenshot in devtools">
    <img src="/images/1-devtools.png" alt="take a node screenshot in devtools" />
  </a>
</div>

Handy right? Use this to easy capture a smaller area of the screen and attach that to your bug report. Easy!

### Saving "console output"

Have you ever seen a blast of red in the console that states an error? You can try to explain what happened and where the error occurs. Or, you can export your console output to a log file and send it along to a developer!

<div class="center">
  <a href="/images/2-devtools.png" target="_blank" title="save console output to a file">
    <img src="/images/2-devtools.png" alt="save console output to a file" />
  </a>
</div>

The output will look something like the following:

```log
(index):233 Uncaught Error: Oh no! Something happened
    at (index):233:9
(anonymous) @ (index):233
(index):265 on localhost - not loading service worker. Query: http://localhost:1313/sw.js 2023-03-09
```

This will make it much easier for the developer to track down the area where the error occurred.

### Save "HAR" content

The ultimate way to report an error with a network call is to use a HAR file to capture the state of the network when the file is created.

What is a HAR file?

> HAR (HTTP Archive) is a file format used by several HTTP session tools to export the captured data. The format is basically a JSON object with a particular set of fields. Note that not all the fields in the HAR format are mandatory, and in many cases, some information won't be saved to the file.

You can capture a HAR file from the network tab in your devtools and then save that file to be attached to your bug report:

<div class="center">
  <a href="/images/3-devtools.png" target="_blank" title="save network requests to a HAR file">
    <img src="/images/3-devtools.png" alt="save network requests to a HAR file" />
  </a>
</div>

A HAR file is just JSON that follows the "HTTP Archive" specification that allows it to be read in various tools. Here is an example of the error above:

```json
{
  "log": {
    "version": "1.2",
    "creator": {
      "name": "WebInspector",
      "version": "537.36"
    },
    "pages": [
      {
        "startedDateTime": "2023-03-10T04:23:47.227Z",
        "id": "page_10",
        "title": "http://localhost:1313/tricks/using-browser-devtools-to-improve-your-bug-reports/",
        "pageTimings": {
          "onContentLoad": 282.40099999675294,
          "onLoad": 511.1339999930351
        }
      }
    ],
    "entries": [
      {
        "_initiator": {
          "type": "script",
          "stack": {
            "callFrames": [
              {
                "functionName": "",
                "scriptId": "700",
                "url": "",
                "lineNumber": 0,
                "columnNumber": 0
              }
            ]
          }
        },
        "_priority": "High",
        "_resourceType": "fetch",
        "cache": {},
        "connection": "121426",
        "pageref": "page_10",
        "request": {
          "method": "GET",
          "url": "http://localhost:1313/missing-file.json",
          "httpVersion": "HTTP/1.1",
          "headers": [
            {
              "name": "Accept",
              "value": "*/*"
            },
            {
              "name": "Accept-Encoding",
              "value": "gzip, deflate, br"
            },
            {
              "name": "Accept-Language",
              "value": "en-CA,en;q=0.9,en-GB;q=0.8,en-US;q=0.7,nb;q=0.6,ar;q=0.5,fr;q=0.4,la;q=0.3"
            },
            {
              "name": "Cache-Control",
              "value": "no-cache"
            },
            {
              "name": "Connection",
              "value": "keep-alive"
            },
            {
              "name": "Host",
              "value": "localhost:1313"
            },
            {
              "name": "Pragma",
              "value": "no-cache"
            },
            {
              "name": "Referer",
              "value": "http://localhost:1313/tricks/using-browser-devtools-to-improve-your-bug-reports/"
            },
            {
              "name": "Sec-Fetch-Dest",
              "value": "empty"
            },
            {
              "name": "Sec-Fetch-Mode",
              "value": "cors"
            },
            {
              "name": "Sec-Fetch-Site",
              "value": "same-origin"
            },
            {
              "name": "User-Agent",
              "value": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36"
            },
            {
              "name": "sec-ch-ua",
              "value": "\"Chromium\";v=\"110\", \"Not A(Brand\";v=\"24\", \"Google Chrome\";v=\"110\""
            },
            {
              "name": "sec-ch-ua-mobile",
              "value": "?0"
            },
            {
              "name": "sec-ch-ua-platform",
              "value": "\"macOS\""
            },
            {
              "name": "sec-gpc",
              "value": "1"
            }
          ],
          "queryString": [],
          "cookies": [],
          "headersSize": 701,
          "bodySize": 0
        },
        "response": {
          "status": 404,
          "statusText": "Not Found",
          "httpVersion": "HTTP/1.1",
          "headers": [
            {
              "name": "Content-Type",
              "value": "text/html; charset=utf-8"
            },
            {
              "name": "Date",
              "value": "Fri, 10 Mar 2023 04:23:55 GMT"
            },
            {
              "name": "Transfer-Encoding",
              "value": "chunked"
            }
          ],
          "cookies": [],
          "content": {
            "size": 8321,
            "mimeType": "text/html",
            "compression": -20,
            "text": "<!DOCTYPE html>\n<html lang=\"en\" class=\"no-js\">\n<head><script src=\"/livereload.js?mindelay=10&amp;v=2&amp;port=1313&amp;path=livereload\" data-no-instant defer></script>\n  <meta charset=\"utf-8\">\n  <meta http-equiv=\"Cache-control\" content=\"public\">\n  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n  <meta name=\"viewport\" content=\"width=device-width,initial-scale=1,maximum-scale=5\">\n  \n    <title>James Doyle | OhDoyleRules</title>\n    <meta name=\"twitter:title\" content=\"James Doyle | OhDoyleRules\">\n    <meta property=\"og:title\" content=\"James Doyle | OhDoyleRules\">\n  \n  <meta name=\"google-site-verification\" content=\"KM-5h_iJ7JJsGeUp4ncEoYCBKft1ko1A4gBpjIzT0p4\" />\n  <link href=\"https://plus.google.com/109231487156400680487\" rel=\"author publisher\" />\n  \n    <meta property=\"og:type\" content=\"website\" />\n    <meta property=\"og:title\" content=\"James Doyle\">\n  \n  <meta itemprop=\"name\" content=\"James Doyle\">\n  <meta property=\"og:site_name\" content=\"OhDoyleRules\">\n  <meta itemprop=\"url\" content=\"http://localhost:1313/404.html\">\n  <meta itemprop=\"email\" content=\"james2doyle@gmail.com\">\n  <meta property=\"og:url\" content=\"http://localhost:1313/404.html\">\n  <meta itemprop=\"image logo\" content=\"http://localhost:1313/icons/logo.png\">\n  <meta property=\"og:image\" content=\"http://localhost:1313/icons/logo.png\">\n  <link rel=\"apple-touch-icon\" sizes=\"57x57\" href=\"http://localhost:1313/icons/apple-icon-57x57.png\">\n  <link rel=\"apple-touch-icon\" sizes=\"60x60\" href=\"http://localhost:1313/icons/apple-icon-60x60.png\">\n  <link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"http://localhost:1313/icons/apple-icon-72x72.png\">\n  <link rel=\"apple-touch-icon\" sizes=\"76x76\" href=\"http://localhost:1313/icons/apple-icon-76x76.png\">\n  <link rel=\"apple-touch-icon\" sizes=\"114x114\" href=\"http://localhost:1313/icons/apple-icon-114x114.png\">\n  <link rel=\"apple-touch-icon\" sizes=\"120x120\" href=\"http://localhost:1313/icons/apple-icon-120x120.png\">\n  <link rel=\"apple-touch-icon\" sizes=\"144x144\" href=\"http://localhost:1313/icons/apple-icon-144x144.png\">\n  <link rel=\"apple-touch-icon\" sizes=\"152x152\" href=\"http://localhost:1313/icons/apple-icon-152x152.png\">\n  <link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"http://localhost:1313/icons/apple-icon-180x180.png\">\n  <link rel=\"icon\" type=\"image/png\" sizes=\"192x192\"  href=\"http://localhost:1313/icons/android-icon-192x192.png\">\n  <link rel=\"icon\" type=\"image/png\" sizes=\"32x32\" href=\"http://localhost:1313/icons/favicon-32x32.png\">\n  <link rel=\"icon\" type=\"image/png\" sizes=\"96x96\" href=\"http://localhost:1313/icons/favicon-96x96.png\">\n  <link rel=\"icon\" type=\"image/png\" sizes=\"16x16\" href=\"http://localhost:1313/icons/favicon-16x16.png\">\n  <link rel=\"manifest\" href=\"http://localhost:1313/manifest.json\">\n  <meta name=\"msapplication-TileColor\" content=\"#ffffff\">\n  <meta name=\"msapplication-TileImage\" content=\"http://localhost:1313/icons/ms-icon-144x144.png\">\n  <meta name=\"theme-color\" content=\"#333333\">\n  <meta name=\"twitter:card\" content=\"summary\">\n  <meta name=\"twitter:site\" content=\"@james2doyle\">\n  \n  <meta name=\"twitter:creator\" content=\"@james2doyle\">\n  <meta name=\"twitter:image\" content=\"http://localhost:1313/icons/logo.png\">\n  <meta name=\"twitter:domain\" content=\"http://localhost:1313/\">\n  <link rel=\"icon\" href=\"http://localhost:1313/icons/logo.svg\">\n  \n  \n  <link rel=\"dns-prefetch\" href=\"https://www.google-analytics.com\">\n  <link rel=\"shortcut icon\" href=\"http://localhost:1313/favicon.ico\" />\n  <link rel=\"canonical\" href=\"http://localhost:1313/404.html\">\n  <link rel=\"sitemap\" type=\"application/xml\" title=\"Sitemap\" href=\"http://localhost:1313/sitemap.xml\" />\n  <meta id=\"themes\" name=\"themes\" content=\"http://localhost:1313/css/new.light.css,http://localhost:1313/css/new.dark.css\">\n  <link id=\"stylesheet\" rel=\"stylesheet\" href=\"http://localhost:1313/css/new.light.css\">\n  <style type=\"text/css\">\n    body {\n      font-feature-settings: 'lnum' 1;\n      font-variant-numeric: slashed-zero;\n      text-rendering: geometricPrecision;\n      -webkit-font-smoothing: antialiased;\n      -moz-osx-font-smoothing: grayscale;\n      -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\n      -webkit-text-size-adjust: 100%;\n      -ms-text-size-adjust: 100%;\n      opacity: 0;\n      transition: opacity 0.2s ease;\n      will-change: opacity;\n    }\n    body.light, body.dark {\n      opacity: 1;\n    }\n    .show-on-light,\n    .show-on-dark {\n      display: none;\n    }\n    .light .show-on-light,\n    .dark .show-on-dark {\n      display: block;\n    }\n    .post-info {\n      margin-bottom: 1rem;\n    }\n    a.none {\n      color: inherit;\n      border: none;\n      opacity: 1;\n    }\n    a.none:hover {\n      background: none;\n      opacity: 0.6;\n    }\n    .center {\n      text-align: center;\n    }\n    .center img {\n      max-width: 100%;\n      height: auto;\n    }\n    pre {\n      color: #f8f8f2;\n      background-color: #282a36;\n      -moz-tab-size: 4;\n      -o-tab-size: 4;\n      tab-size: 4;\n    }\n    pre code.language-diff span:nth-child(1n + 7) {\n      color: #50fa7b;\n    }\n    .switch-wrapper {\n      display: flex;\n      align-items: center;\n      position: absolute;\n      top: 1rem;\n      right: 2rem;\n      font-size: 80%;\n    }\n    .switch {\n      position: relative;\n      margin: 0 0.4rem;\n    }\n    .switch input {\n      position: absolute;\n      width: 100%;\n      height: 100%;\n      z-index: 1;\n      opacity: 0;\n      cursor: pointer;\n    }\n    .switch label {\n      display: flex;\n      border-radius: 9999px;\n      height: 0.8rem;\n      width: 1.8rem;\n      background-color: rgba(0, 0, 0, .1);\n      border: 1px solid rgba(0, 0, 0, .3);\n    }\n    .switch input:checked + label {\n      background-color: #357edd;\n      border: 1px solid #357edd;\n      justify-content: flex-end;\n    }\n    .switch div {\n      width: calc(0.8rem - 2px);\n      height: calc(0.8rem - 2px);\n      border-radius: 9999px;\n      border: 1px solid rgba(0, 0, 0, .3);\n      background-color: #FFF;\n    }\n     \n    body.dark table.highlight tr:nth-child(even) {\n      background-color: rgb(246, 248, 250);\n    }\n    body.dark table.highlight td,\n    body.dark table.highlight th {\n      border-color: rgba(27,31,35,.3);\n    }\n  </style>\n  <script type=\"text/javascript\" charset=\"utf-8\" defer>\n    document.addEventListener('DOMContentLoaded', function() {\n      \n      const defaultIndex = window.matchMedia('(prefers-color-scheme)').media !== 'not all' ? '1' : '0';\n      \n      const activeIndex = JSON.parse(window.localStorage.getItem('activeIndex') || defaultIndex);\n\n      const themes = document.getElementById('themes').content.split(',');\n      const stylesheet = document.getElementById('stylesheet');\n      if (stylesheet.href !== themes[activeIndex]) {\n        stylesheet.href = themes[activeIndex];\n      }\n\n      document.body.className = activeIndex === 0 ? 'light' : 'dark';\n\n      const theSwitch = document.getElementById('switch');\n      theSwitch.checked = Boolean(activeIndex);\n      theSwitch.addEventListener('change', function() {\n        const newIndex = Number(this.checked);\n        stylesheet.href = themes[newIndex];\n        document.body.className = newIndex === 0 ? 'light' : 'dark';\n        window.localStorage.setItem('activeIndex', newIndex);\n      });\n    });\n  </script>\n</head>\n<body>\n<div class=\"switch-wrapper\">\n  <div>Light</div>\n  <div class=\"switch\">\n    <input id=\"switch\" type=\"checkbox\" style=\"display: none\" />\n    <label for=\"switch\">\n      <div></div>\n    </label>\n  </div>\n  <div>Dark</div>\n</div>\n\n<div class=\"container\">\n  <header class=\"grid -middle -center\">\n    <p>\n      <a href=\"http://localhost:1313/\" title=\"James Doyle\" class=\"none\">\n        <img class=\"show-on-light\" src=\"/icons/logo-light.svg\" alt=\"James Doyle Logo\" width=\"113\" height=\"57\">\n        <img class=\"show-on-dark\" src=\"/icons/logo-dark.svg\" alt=\"James Doyle Logo\" width=\"113\" height=\"57\">\n      </a>\n    </p>\n  </header>\n  <div class=\"the-loop\">\n    <article>\n      <h2>404 Page Not Found</h2>\n      <div class=\"post-intro\">\n        <p>The page you are looking for cannot be found. Please <a href=\"/\" title=\"Homepage\">return to the homepage</a>.</p>\n      </div>\n   </article>\n  </div>\n</div>\n\n\n<script defer>\n  \n  \n  console.info('on localhost - not loading service worker. Query: http:\\/\\/localhost:1313\\/sw.js 2023-03-09');\n  \n</script>\n</body>\n</html>\n\n"
          },
          "redirectURL": "",
          "headersSize": 131,
          "bodySize": 8341,
          "_transferSize": 8472,
          "_error": null
        },
        "serverIPAddress": "127.0.0.1",
        "startedDateTime": "2023-03-10T04:23:55.706Z",
        "time": 5.828000001201872,
        "timings": {
          "blocked": 3.4279999995124526,
          "dns": -1,
          "ssl": -1,
          "connect": -1,
          "send": 0.08699999999999997,
          "wait": 0.28199999806331477,
          "receive": 2.0310000036261044,
          "_blocked_queueing": 1.5889999995124526
        }
      }
    ]
  }
}
```

To read a HAR file that has already been exported, you can just **drag it into the network panel** of your devtools:

<div class="center">
  <video width="100%" autoplay loop muted preload="auto" poster="/images/5-devtools-poster.jpg">
    <source src="/images/5-devtools.mp4" type="video/mp4">
    <p>Sorry, your browser doesn't support embedded videos, but don't worry, you can <a href="/images/5-devtools.mp4" download>download it</a> and watch it with your favourite video player!</p>
  </video>
</div>

This will recreate the state of the world when the HAR file was captured.

You can also use a tool like the [Google Admin Toolbox HAR Analyzer](https://toolbox.googleapps.com/apps/har_analyzer/) to view HAR files on a webpage:

<div class="center">
  <a href="/images/4-devtools.png" target="_blank" title="save console output to a file">
    <img src="/images/4-devtools.png" alt="save console output to a file" />
  </a>
</div>

If you want to read more about capturing HAR files, just check out [this great list of steps on the IBM site](https://www.ibm.com/support/pages/how-generate-har-file-troubleshoot-issues) - of all places.

### In Summation

Hopefully these simple tips help improve your bug reports and make it easier for your team members to report them but also recreate them. Happy bug hunting!
