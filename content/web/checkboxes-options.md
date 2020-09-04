---
Title: "Making Checkboxes in WordPress options pages"
Description: "Making Checkboxes in WordPress options pages"
Date: "2012-08-11"
Category: "Web"
Template: "post"
Keywords: ["checkbox", "checkboxes", "checked", "HTML", "input", "options", "PHP", "WordPress"]
---

I am in the process of building my first WordPress plugin. Of course I am wildly researching how to do things. One thing that was particularly hard to find was how to use checkboxes in options pages. Here is the solution I used.

WordPress has a function called [checked()](http://codex.wordpress.org/Function_Reference/checked "WordPress Codex For Checked Function"). This basically returns a true checked attribute if the conditions it is passed are met. Here is how I used it:

    <input type="checkbox" name="my_options" <?php checked( get_option('my_option') == 'on',true); ?> />

What I found is that when the option was getting updated it was being stored as 'on'. So this little PHP snippet says: "If the option named 'my_option' is equal to 'on' then add a checked="checked" attribute to this input tag." Anyway, I found it quite hard to get a straight up answer to this problem. Since the reason I made this blog is to share my discoveries; here you go.
