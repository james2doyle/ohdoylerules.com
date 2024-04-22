+++
title = "Handle spaces and no-spaces in MySQL where-like clauses"
description = "Have you ever wanted to write a WHERE LIKE for a query with and without spaces? Well, now you can with this trick!"
date = "2017-07-08"
category = "Tricks"
template = "post.html"
[taxonomies]
keywords = ["mysql", "like", "where", "spaces", "no spaces", "concat"]
+++

Have you ever been writing a search for MySQL and had an issue where the search wouldn't handle spaces properly?

I was writing a search for a `users` table and wanted to find a user by their first name or last name or a combination of both.

I started with a query like this:

```sql
SELECT * FROM `users`
  WHERE LOWER(`users`.`first_name`)
      LIKE LOWER(:searchTerm)
    OR LOWER(`users`.`last_name`)
      LIKE LOWER(:searchTerm)
```

Here is the list for the matches, given that there is a user with the `first_name` of "James" and `last_name` of "Doyle":

* "%james%" - **match**
* "%doyle%" - **match**
* "%james d%" - _no match_
* "%j doyle%" - _no match_
* "%james doyle%" - _no match_

The issue comes in when you add spaces into the search query. I didn't want to split the word into an array and do a search for each word. That would require querying the database multiple times. And I don't want to try to do `RLIKE` and all these string hacks to get this to match more accurately.

Well, I found this trick where you can create fake columns using the `CONCAT` and then replace any space character with `%`.

So if I queried like this: `%james doyle%`, that will actually become `%james%doyle%` when it gets to the actual SQL WHERE query.

This allows you to *get a better match more often* if the user types in more content in a query with a space.

```sql
SELECT * FROM `users`
  WHERE
    LOWER(CONCAT(`users`.`first_name`,`users`.`last_name`))
      LIKE LOWER(REPLACE(:searchTerm, " ", "%"))
```

Here is a list of terms that will be matched in this query:

* "%james%" - **match**
* "%doyle%" - **match**
* "%james d%" - **match**
* "%j doyle%" (becomes "%j%doyle%" due to `REPLACE`) - **match**
* "%james doyle%" (becomes "%james%doyle%" due to `REPLACE`) - **match**

#### Sidenote

The only downside of this query is that you may get more matches if the string you are searching for is too small. Like 2 - 3 characters. At that point though, you should notify the user that they should enter in more characters to get more accurate results.

Another great thing is that if you added a `middle_name` column, it will handle searches where someone is searching for a known first and middle name as well. It can still match as the `CONCAT` builds a nice string to match against.
