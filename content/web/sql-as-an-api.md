+++
title = "SQL As An API"
date = "2019-05-12"
category = "Web"
template = "post.html"
description = "An example of how to use SQL as an API instead of reaching for something like GraphQL"
[taxonomies]
keywords = ["sql", "graphql", "api", "sqlite", "json", "query", "php"]
+++

There has been a lot of fanfare around the idea of [GraphQL](https://graphql.org/) lately. For good reason in my opinion.

GraphQL allows you to essentially define your API with your query. For example, if you want to only include a single field then you can do that. If you want to nest related items, or not, you can do that as well.

If you take a quick look at the GraphQL website (as it is today) you can see how they lay this out:

```
# Describe your data
type Project {
  name: String
  tagline: String
  created_at: Int
}

# Ask for what you want
{
  project(name: "My Project") {
    tagline
  }
}

# Get predictable results
{
  "project": {
    "tagline": "A query language for APIs"
  }
}
```

Pretty straightforward. You create a model of your data that describes it, write a query that matches the model, and get the results.

Although, this should already look familiar to anyone that has used a relational database before. What if we massage this example so it fits a more classic datastore:

```
# Describe your data
CREATE TABLE "project"
(
    [name] NVARCHAR(40),
    [tagline] NVARCHAR(120),
    [created_at] INTEGER NOT NULL
);

# Ask for what you want
SELECT `tagline` FROM `projects` WHERE `name` = "My Project"

# Get predictable results
[
  {
    "tagline": "A query language for APIs"
  }
]
```

So this really is just another way to store and query your data. We describe the structure, query it using the specified query language with our expected structure, and print out the results.

> So can we create a GraphQL experience using just SQL?

So can we create a GraphQL experience using just SQL? Short answer, yes. This isn't a new concept though. There is a tool called [datasette](https://simonwillison.net/2017/Nov/13/datasette/#Arbitrary_SQL_55) that does just this.

So where do we start? Well, we don't want users to be able to modify our database. We want to safely expose SQL to the internet. Crazy idea but it just might work.

So what we want to do is open a Sqlite database using the "ro" (read only) mode (see [mode details here](http://www.sqlite.org/draft/c3ref/open.html)). This mode means that you *cannot modify the database*. You can only run queries that are reads. This is a great feature as we need to expose this database to the public internet if we are going to use it as an API.

Once we have a mounted sqlite database that is set to "read only" mode, we can then pass queries right to it and return the results.

### Basic Example

We are going to whip up this example using PHP and the `chinook` database [from this site](http://www.sqlitetutorial.net/sqlite-sample-database/). It is insanely easy to get this working using the `SQLite3` class and a single `json_encode` call.

Let's see how to get this done:

```php
<?php
// be sure to open with `SQLITE3_OPEN_READONLY`
$db = new SQLite3('chinook.sqlite', SQLITE3_OPEN_READONLY);
// pull out the query from the POST request
$rows = $db->query($_POST['query']);
$results = [];
while ($row = $rows->fetchArray(SQLITE3_ASSOC)) {
    $results[] = $row;
}
echo json_encode($results);
```

OK. That was easy. This is all we need to support calls to this "server". Let's save this to `index.php`. And start a webserver on port `8000`. If you didn't know this, PHP has a built-in server just like the one python has. We can start it like so:

```sh
php -S localhost:8000
```

You should see some output information about what the server is doing. Now we can make calls to this API:

```sh
curl --request POST \
  --url http://localhost:8000 \
  --header 'Content-Type: application/x-www-form-urlencoded' \
  --data 'query=SELECT LastName FROM employees'
```

We should see the following output in our console:

```json
[
  {
    "LastName": "Adams"
  },
  {
    "LastName": "Edwards"
  },
  {
    "LastName": "Peacock"
  },
  {
    "LastName": "Park"
  },
  {
    "LastName": "Johnson"
  },
  {
    "LastName": "Mitchell"
  },
  {
    "LastName": "King"
  },
  {
    "LastName": "Callahan"
  }
]
```

### Getting fancier

Nice! So this works. Let's try to do something a little more fancy:

```sh
curl --request POST \
  --url http://localhost:8000 \
  --header 'Content-Type: application/x-www-form-urlencoded' \
  --data 'query=SELECT printf("%s %s", FirstName, LastName) AS FullName, FirstName, LastName FROM employees'
```

Our output:

```json
[
  {
    "FullName": "Andrew Adams",
    "FirstName": "Andrew",
    "LastName": "Adams"
  },
  {
    "FullName": "Nancy Edwards",
    "FirstName": "Nancy",
    "LastName": "Edwards"
  },
  {
    "FullName": "Jane Peacock",
    "FirstName": "Jane",
    "LastName": "Peacock"
  },
  {
    "FullName": "Margaret Park",
    "FirstName": "Margaret",
    "LastName": "Park"
  },
  {
    "FullName": "Steve Johnson",
    "FirstName": "Steve",
    "LastName": "Johnson"
  },
  {
    "FullName": "Michael Mitchell",
    "FirstName": "Michael",
    "LastName": "Mitchell"
  },
  {
    "FullName": "Robert King",
    "FirstName": "Robert",
    "LastName": "King"
  },
  {
    "FullName": "Laura Callahan",
    "FirstName": "Laura",
    "LastName": "Callahan"
  }
]
```

How about a little example that searches a users name?

```sh
curl --request POST \
  --url http://localhost:8000 \
  --header 'Content-Type: application/x-www-form-urlencoded' \
  --data 'query=SELECT printf ("%s %s", employees.FirstName, employees.LastName) AS full_name FROM employees WHERE full_name LIKE "an%"'
```

We see that we found the user:

```json
[
  {
    "full_name": "Andrew Adams"
  }
]
```

Let's do an even more sophisticated example:

```sh
curl --request POST \
  --url http://localhost:8000 \
  --header 'Content-Type: application/x-www-form-urlencoded' \
  --data 'query=SELECT e2.EmployeeId AS employee_id, e2.ReportsTo AS reports_to, printf ("%s %s", e2.FirstName, e2.LastName) AS employee_full_name, printf ("%s %s", e1.FirstName, e1.LastName) AS reports_to_full_name FROM employees e1 INNER JOIN employees e2 ON e1.EmployeeId = e2.ReportsTo WHERE e1.ReportsTo IS NOT NULL'
```

And our output:

```json
[
  {
    "employee_id": 3,
    "reports_to": 2,
    "employee_full_name": "Jane Peacock",
    "reports_to_full_name": "Nancy Edwards"
  },
  {
    "employee_id": 4,
    "reports_to": 2,
    "employee_full_name": "Margaret Park",
    "reports_to_full_name": "Nancy Edwards"
  },
  {
    "employee_id": 5,
    "reports_to": 2,
    "employee_full_name": "Steve Johnson",
    "reports_to_full_name": "Nancy Edwards"
  },
  {
    "employee_id": 7,
    "reports_to": 6,
    "employee_full_name": "Robert King",
    "reports_to_full_name": "Michael Mitchell"
  },
  {
    "employee_id": 8,
    "reports_to": 6,
    "employee_full_name": "Laura Callahan",
    "reports_to_full_name": "Michael Mitchell"
  }
]
```

Awesome! As you can see this is pretty great! We have a basic API that we can use not only to read but to handle relationships as well. Sweet!

### Handling malicious queries

Let's try to execute a bad command:

```sh
curl --request POST \
  --url http://localhost:8000 \
  --header 'Content-Type: application/x-www-form-urlencoded' \
  --data 'query=INSERT INTO "artists" ("Name") VALUES ("Philip Glass Ensemble")'
```

We should see this output from the server:

```html
<br />
<b>Warning</b>:  SQLite3::query(): Unable to execute statement: attempt to write a readonly database in <b>/Users/james/Sites/sqliteapi/index.php</b> on line <b>6</b><br />
<br />
<b>Fatal error</b>:  Uncaught Error: Call to a member function fetchArray() on bool in /Users/james/Sites/sqliteapi/index.php:8
Stack trace:
#0 {main}
  thrown in <b>/Users/james/Sites/sqliteapi/index.php</b> on line <b>8</b><br />
```

As you can see, we try to execute a bad query that would manipulate the data and we get blocked.

### Super example

Here is a much more robust example with some error handling, proper status codes, parsing of JSON input, and it also allows you to put the `query` in a `GET` or a `POST` request.

{{ gist(src="https://gist.github.com/james2doyle/9e4b2b4f17e33bfb236fbdaf96c41a4c.js") }}

Try running the example above and giving things a test. Here is our new request that uses JSON instead:

```sh
curl -X POST \
  http://localhost:8000 \
  -H 'Content-Type: application/json' \
  -d '{ "query": "SELECT LastName FROM employees" }'
```

Now we have the following output:

```json
{
  "data": [
    {
      "LastName": "Adams"
    },
    {
      "LastName": "Edwards"
    },
    {
      "LastName": "Peacock"
    },
    {
      "LastName": "Park"
    },
    {
      "LastName": "Johnson"
    },
    {
      "LastName": "Mitchell"
    },
    {
      "LastName": "King"
    },
    {
      "LastName": "Callahan"
    }
  ],
  "meta": {
    "query": "SELECT LastName FROM employees",
    "total": 8
  }
}
```

So there you go. A pretty robust solution that has excellent performance, a simple and well-known query language, and supports almost any combination of data.

### In summation

So this could be a great option for a lot of applications. You can quickly imagine how this could be used for something like a simple search API. You could have an application hook to add data to this special database when your data is changed. Sqlite is a really viable option for a lot of things as it can grow to 140 TB, supports [`json_` functions](https://www.sqlite.org/json1.html), and even [binary data](https://effbot.org/zone/sqlite-blob.htm).

Keep in mind that you can't really nest the same way you can in GraphQL. But you might be ok with that depending on your use case.
