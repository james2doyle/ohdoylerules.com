---
Title: "Easy FFmpeg Video Posters"
Description: "Take in a list of video files and generate a poster image for each one"
Date: "2015-03-19"
Category: "Snippets"
Template: "post"
Keywords: ["ffmpeg", "video", "poster", "screenshot", "image", "thumbnail", "command line"]
---

A week ago I was tasked with uploading about 20 different videos to a CMS. Normally for the HTML5 Video element to look nice, you should upload a [poster image](http://www.w3.org/TR/2012/WD-html5-20121025/the-video-element.html#attr-video-poster) so that there can be something showing before the video starts to play.

In my case, I had to generate a poster for each of these 20 videos. This would have taken a long time, so I scripted it using FFmpeg!

Here is the script:

```sh
#!/usr/bin/env bash

# take in mp4, take screenshot at 5 seconds
# output same filename, but with jpg extension
for FILE in *.mp4
  do
    # save the filename but swap the extension
    NEWFILE="${FILE%.mp4}.jpg"
    ffmpeg -y -i $FILE -f mjpeg -vframes 1 -ss 5 $NEWFILE
done
```

*If your videos are not mp4 format, just change the extension.*

To use this script:

* save this script as `poster.sh`
* put it in the folder with all your video files
* own the script with `chmod +x poster.sh`
* run the script with `./poster.sh`

You should see a bunch of text fly in your command line, and a couple of seconds later, the conversion should be done. You will see some nice little posters right beside your videos! And, they will all be nicely named too!
