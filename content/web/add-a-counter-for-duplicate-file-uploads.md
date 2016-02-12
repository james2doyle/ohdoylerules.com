/*
Title: Add A Counter For Duplicate Uploads
Date: 2016-02-12
Category: Web
Template: post
Description: A short script to detect if a folder contains a duplicate filename, and if it does, the filename gets a counter prepended to the front of the filename
Keywords: php, upload, duplicate, name, laravel, symphony, file, rename, append, prepend, counter, increment
*/

Wouldn't it be nice if, when you uploaded a file, the duplicate filenames just get a counter added in front?

Some people add timestamps on their files, and add some type of date, but I always found that to be very cumbersome.

How about something like this?

```
some-file.jpg
1-some-file.jpg
2-some-file.jpg
3-some-file.jpg
```

Well, now you can! I have used this little script a couple times to remove any conflicting filenames when uploading files with the same name.

I use this in [Laravel](https://laravel.com) (with an instance of `Symfony\Component\HttpFoundation\File\UploadedFile` which extends [SplFileInfo](http://php.net/SplFileInfo)) but it can easily be modified for any other framework or system.

<script src="https://gist.github.com/james2doyle/516483af423d4643ac83.js"></script>

If you are OCD, and wanted to all files to start with a number, just remove the if statement for the `$client_name`, only leaving the string concatenate line, and it will always add a the counter when the file is new.

So give it a shot, and if you modify it for some other framework, post the link in the comments.