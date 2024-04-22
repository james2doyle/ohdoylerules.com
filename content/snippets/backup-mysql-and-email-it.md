+++
title = "Backup MySQL And Email It"
description = "Don't bother paying for a SaaS that creates MySQL backups and emails them to you on a schedule, you can do this with CRON and a small script"
date = "2016-03-24"
category = "Snippets"
template = "post.html"
[taxonomies]
keywords = ["mysql", "backup", "email", "mailgun", "curl", "mysqldump", "shell", "script", "cron", "sendmail", "mail"]
+++

Recently, a friend of mine asked me what we use for managing the backups for our clients. I mentioned that we use `mysqldump` running on a `CRON` schedule. He said that he used a paid service for managing all the servers and their backups. He mentioned it sends to an Amazon S3 bucket, and also sends a notification.

With my setup, he noted that I could be in trouble if the hard drive failed, or the site gets wiped because my backups are stored locally right beside the site itself.

I thought to myself, "Hmmm. What would help me back these files up, let me know that it is done, access them quickly, and also cost no money?". Email + `CRON`. Email is a pretty reasonable solution for this.

With Email, you get the following:

* A notification of when the backup is done
* An "offsite" backup of the file
* A searchable history of the files/backups
* Forwarding of the backup to someone else
* CC multiple accounts and have the backup available to multiple people
* Send a copy to the client, so they can have one too

So I whipped up a script with `mysqldump`, `curl`, and `CRON`.

Although you can send email `sendmail` or `mail`, I opted for [Mailgun](http://www.mailgun.com/). It is something we are already using, so hooking it up took no time at all. They also have an excellent API, which is faster than *SMTP*.

On top of the regular email features I listed above, with Mailgun, I also get:

* read receipts
* delivery reports
* logging
* web hooks (you can catch emails with individual subjects or recipients)

So, without spending any money, I can get a SaaS experience using some built-in tools.

You can see the script here:

{{ gist(src="https://gist.github.com/james2doyle/6e471dee73124eddda8c.js") }}

I included some rules for the `crontab` settings. I used `0 0 * * 1 *` which is once a week on Monday at midnight.

You can still run the script above *without using `CRON`*. Just put it somewhere on your server and run it like you normally would: `./backup-mysql-db.sh`.
