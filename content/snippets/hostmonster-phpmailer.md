---
Title: "HostMonster PHPMailer Settings"
Description: "How to setup PHPMailer on a HostMonster hosting server"
Date: "2013-11-19"
Category: "Snippets"
Template: "post"
Keywords: ["hostmonster", "phpmailer", "smtp", "hosting", "mail", "host", "monster", "setup"]
---

God Damn!! This one was a b\*tch to get right. I have a small plugin for a site that makes doing AJAX contact forms a breeze.

But, of course, it likes to be a pain in the ass when I am trying to set it up. Also you usually have to be on the correct domain to allow the script to send the right email. So doubly annoying.

Here is the code that worked for me:

```php
$mail = new PHPMailer; // basic class declaration
$mail->isSMTP(); // duh!
$mail->SMTPDebug = 0; // no debug
$mail->SMTPAuth = true; // yes to auth please
$mail->Port = 26; // nope not port 25, 26!!
$mail->Host = 'host286.hostmonster.com';
```

Now your host may differ. I used [this tool](http://mxtoolbox.com/) to check the MX records for the domain. After the check is complete, you will see a small table showing the hostname, IP address, TTL, and some links. **Click "SMTP Test"**.

Once that text completes, you will see another table. The first result is the "SMTP Reverse Banner Check". Copy the hostname, which is the domain in that value field.

Hopefully this works for you. I had a hell of a time getting the correct settings. *My pain is your gain*.

