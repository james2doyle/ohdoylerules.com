---
Title: "When And Where To Compromise Your App Design"
Date: "2018-10-21"
Category: "Web"
Template: "post"
Description: "When initially developing an application or a new feature we are constantly trying to balance best practices in design with delivering a finished product."
Keywords: ["application", "design", "database", "API", "JSON", "packages", "vendor"]
---

_**You won't believe number 3!**_

When initially developing an application or a new feature we are constantly trying to balance best practices in system/application design with delivering a finished product. Usually, things like scaling or flexibility become a secondary thought or something that would be *"nice to have, if we had the time"*.

Given those restrictions or that type of scenario, we need to pick places to *compromise on purpose*. We need to actively choose a section of the app to cut corners and hide garbage. Fun! Right?

> Should we hardcore this? Should we store this in a column instead of a pivot table? Can we stick it in the HTML for now?

We have all heard (or spoken) these types of phrases at some point. If you haven't, well it must be nice to live in a fantasy land full of rainbows, puppies, and perfectly designed systems.

So here is my list of the top 3 places you should not compromise when getting stuck in a situation where compromise is necessary.

### 3. HTTP JSON API design

Building a crappy API for you service or application can be crippling. It can stifle updates, cause a lot of "patch" code inside consumers and clients to fix issues, create uncomfortable conversations with customers who need to update (because you didn't think about versioning), and even force you to maintain multiple implementations of similar end-points that are almost identical because you had to fill in gaps after the fact.

Think of HTTP APIs as contracts. I mean literal contracts not just "code contracts" or interfaces.

What happens if you enter into an agreement with someone and the contract is missing key information? You could end up really missing out on a lot, or worse still, _being sucked into something that you didn't understand you were getting into with no feasible escape_ beyond writing a new contract and getting every single party to sign again. Gross.

My advice would be to spend more time on designing a robust and verbose API with lots of tests and less time on organizing things behind the scenes. Organization can always come later. I would edge more towards including more information than you need in a response than you are actually using. Maybe even including keys that are empty if you know you are going to need to use them in the near future. Consider using "501 Not Implemented" responses for endpoints that are coming in the future.

Changing an API once it's in the wild is difficult and annoying. If you have a single-page app, this could mean refactoring major parts of the front-end to work with new datasets and responses. So consider what you need now, and in the near future, when designing that JSON response object. Also, try to keep your types consistent. Having to deal use with mixed types and constant variation of types is incredibly painful and adds a lot of type checking for API consumers!

### 2. Leveraging vendor code/tools

As developers we like making stuff. Sometimes that stuff is mixed quality, quickly assembled, or just plain buggy. In the last 10 years or so, the quality and volume of excellent production-grade open source projects has been phenomenal. Unless you are on the bleeding edge of some burgeoning industry or technology, there is probably an open source equivalent of pretty much everything you need.

I've typically seen people develop their own solutions and spend a lot of energy thinking about problems that someone has already solved. On top of that, instead of choosing a package or service that provides all they need, they decided on a DIY solution or a patchwork of different offerings. Too many times I've seen a project rapidly go from a bespoke group of loose packages to a company's main offering with a handful of developers charged to take care of it.

It's not just server-side apps, I've seen this a lot in front-end development. I've done it to myself a dozen times. I can't even count the number of hours I spent building my own sliders that were never really perfect and often had bugs in some specific browser because I didn't test it enough. Whoops!

When it comes to support infrastructure like queues, caches, CDNs, and databases, unless you have the time or need, you shouldn't be spinning up your own on a dedicated host. There are a lot of services that are reasonably priced that can manage all that for you. It's hard to set things up correctly (secure defaults, scalability, interoperability, etc) with tight time frames. So don't bother. Choose your flavour of hosting and pick the service that fits your needs and move on. Use those saved hours for more development time. Like organization of code, you can always swap things later when you find the time or you grow to a place where it matters.

### 1. Database design

This is my number one place to spend all your time. Doing database tweaks early on is not too hard. But once you start getting a few hundred thousand rows, data in the gigabytes, or distributed databases, migrations become super painful. They need to be meticulously programmed, tested, and then timed properly in order not to break things or take the service down.

I don't have much experience with no-SQL databases at scale. So I can't really speak to much on them. But generally, I think the advice is similar to relational database design: big migrations are painful. So try to make sure you have a scalable and sustainable design is important.

Regarding relation datastores, my advice is mostly about relationships. Too often I see things like `address1`, `address2`, `address3`, etc. You get the deal. Instead of using a pivot table, someone decided it was too much work. So now you are growing the table horizontally and with each row instead of, get this, _being relational_.

Another one I've been bit by is using one-to-many relationships instead of designing for many-to-many with a `LIMIT 1` by default. It is so much easier to turn a many-to-many into a one-to-many than it is to do the reverse. How many times have you made something and then a week or a month later someone from product development or business asks *"how hard it would be to make it so that X could have many Y's?"* Only to be met with you screaming at the top of your lungs because you need to not only migrate the existing database but update all the code as well.

### In Summation

I've really become a fan of "where should we hide our garbage?". It's always going to happen so we should figure out where to put the mess so that it's either easy to clean up or it isn't somewhere critical.
