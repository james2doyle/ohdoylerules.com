+++
title = "Bitbucket Weekly Reports Using Make (Integromat)"
description = "Use Make (Integromat) to create a nice weekly report in Slack for all the closed pull-requests in a Bitbucket repository"
date = "2022-08-06"
category = "Tricks"
template = "post.html"
[taxonomies]
keywords = ["make", "Integromat", "Bitbucket", "report", "git", "slack", "pagination"]
+++

At my job, we like to keep our team updated with all the dev work we do each week. This means we have meetings every Monday to review the work that has happened since the previous week.

I often like to review the work done over that time frame by looking at the projects git log for all the pull-requests merged during that previous week.

Now, I could open up the `develop` branch and run a `git shortlog --since "1 week ago"` every Monday, but I would much rather automate this task so I don't have to remember to do anything and it stays consistent. I can just wake up on Monday and see a pretty little report printed in the project Slack channel.

The way I accomplished this is using [Make.com (formerly Integromat)](https://www.make.com/en?pc=jamesdoyle&fromImt=1). This is a "no-code" tool that allows you to use visual programming to build tools and apps.

Let's break down the solution I came up with:

<div class="center">
  <a href="/images/bb-integromat-make-01.png" target="_blank" title="Bitbucket integromat make 01">
    <img src="/images/bb-integromat-make-01.png" alt="Bitbucket integromat make 01" />
  </a>
</div>

With a final output something like this:

<pre>
<h5><strong>BitBucket Reporter  [APP]  9:01 AM</strong></h5>
<strong>List of BitBucket PRs since 2022-07-25 [1 of 2]</strong>
#824 - Feature/events [MERGED] by James Doyle
#825 - Bugfix/appointments and invoices [MERGED] by Sr. Developer
#826 - Feature/auto submit changes [MERGED] by Sr. Developer
#827 - Feature/events [MERGED] by James Doyle
#828 - Fixed: case where missing was not correct [MERGED] by James Doyle
#829 - Fixed: another issue with the wrong conditions showing up [MERGED] by James Doyle
#830 - Bugfix/appointment and admin notes [MERGED] by Sr. Developer
#831 - Feature/user-profile-header [MERGED] by Jr. Developer
#832 - Feature/user profile treatment plan [OPEN] by Sr. Developer
#833 - Fixed: loading wrong classes and incorrect state [MERGED] by James Doyle
<strong>List of BitBucket PRs since 2022-07-25 [2 of 2]</strong>
#834 - Fix/users documents style tweaks [MERGED] by Jr. Developer
#835 - Feature/insurance claims [OPEN] by Jr. Developer
#836 - Feature/forms [MERGED] by James Doyle
#837 - Bugfix/user tickets [OPEN] by Jr. Developer
</pre>

Here is the overall solution laid out. As you can see, it wasn't as simple as it might seem.

I will go through the solution step-by-step and explain each node. I will assume you already have Slack and BitBucket connected.

### Step 1

<div class="center">
  <a href="/images/bb-integromat-make-02.png" target="_blank" title="Bitbucket integromat make 02">
    <img src="/images/bb-integromat-make-02.png" alt="Bitbucket integromat make 02" />
  </a>
</div>

First we need set the schedule to run each Monday. Nothing fancy here. I set it to 9:01 just because I am usually on the computer by then so I will see the channel notification.

### Step 2

<div class="center">
  <a href="/images/bb-integromat-make-03.png" target="_blank" title="Bitbucket integromat make 03">
    <img src="/images/bb-integromat-make-03.png" alt="Bitbucket integromat make 03" />
  </a>
</div>

Here is the reason this is so complicated: the BitBucket API is paginated and there is no way to easily page through the results. So we need to loop through each page from the results and append them to a variable we eventually send to Slack.

In this request, we ask BitBucket for the "merged" and "open" pull-requests that happened last week. There was no nice way to calculate the previous weeks date, so we have this fun code to get the date of the previous Monday.

You can copy the text below for the query:

```
(state="merged" OR state="open") AND created_on>="{{formatDate(setDay(parseDate(timestamp - 604800; "X"); "monday"); "YYYY-MM-DD")}}"
```

The only reason we run this first request just so we can get the page count that we will then use to create a loop to make the real requests.

### Step 3

<div class="center">
  <a href="/images/bb-integromat-make-04.png" target="_blank" title="Bitbucket integromat make 04">
    <img src="/images/bb-integromat-make-04.png" alt="Bitbucket integromat make 04" />
  </a>
</div>

Here is the loop that we use to iterate over the pages in the results. We check the page size and make sure we repeat the right amount of times.

<div class="center">
  <a href="/images/bb-integromat-make-04a.png" target="_blank" title="Bitbucket integromat make 04 A">
    <img src="/images/bb-integromat-make-04a.png" alt="Bitbucket integromat make 04 A" />
  </a>
</div>

Our first route (the top one) is the condition that the loop continues to run in. You can see the condition is a basic for loop that repeats for each page in the loop.

### Step 4

<div class="center">
  <a href="/images/bb-integromat-make-05.png" target="_blank" title="Bitbucket integromat make 05">
    <img src="/images/bb-integromat-make-05.png" alt="Bitbucket integromat make 05" />
  </a>
</div>

Here is the request that happens within the loop. It is identical to the first one but we have a page parameter so that we can get each page of the results.

### Step 5

<div class="center">
  <a href="/images/bb-integromat-make-06.png" target="_blank" title="Bitbucket integromat make 06">
    <img src="/images/bb-integromat-make-06.png" alt="Bitbucket integromat make 06" />
  </a>
</div>

All we are doing in this node is sorting the pull requests by their title. We do this because the PR number is in the title and not sorting it would look off.

### Step 6

<div class="center">
  <a href="/images/bb-integromat-make-07.png" target="_blank" title="Bitbucket integromat make 07">
    <img src="/images/bb-integromat-make-07.png" alt="Bitbucket integromat make 07" />
  </a>
</div>

Here we are defining the string template for the PR titles that will go into our bulleted list. The output of this will be a single variable that contains all the row strings.

### Step 7

<div class="center">
  <a href="/images/bb-integromat-make-08.png" target="_blank" title="Bitbucket integromat make 08">
    <img src="/images/bb-integromat-make-08.png" alt="Bitbucket integromat make 08" />
  </a>
</div>

Nothing fancy here. Just getting the variable the we will be pushing the results of our text aggregation to.

### Step 8

<div class="center">
  <a href="/images/bb-integromat-make-09.png" target="_blank" title="Bitbucket integromat make 09">
    <img src="/images/bb-integromat-make-09.png" alt="Bitbucket integromat make 09" />
  </a>
</div>

Here we are updating our actual results that will be sent to Slack. We break up the list with a nice header that is chunked by page.

Here is the code in the box for setting the variable:

```
{{21.results}}{{newline}}*List of Project PRs since {{formatDate(setDay(parseDate(timestamp - 604800; "X"); "monday"); "YYYY-MM-DD")}} [{{13.i}} of {{ceil(1.body.size / 1.body.pagelen)}}]*{{newline}}{{11.text}}
```

### Step 9

<div class="center">
  <a href="/images/bb-integromat-make-10.png" target="_blank" title="Bitbucket integromat make 10">
    <img src="/images/bb-integromat-make-10.png" alt="Bitbucket integromat make 10" />
  </a>
</div>

Here is the other condition in the router that will run at the end of the loop. It checks that the loop variable is larger that the page count.

<div class="center">
  <a href="/images/bb-integromat-make-10a.png" target="_blank" title="Bitbucket integromat make 10 A">
    <img src="/images/bb-integromat-make-10a.png" alt="Bitbucket integromat make 10 A" />
  </a>
</div>

Our first step in the end case is to get the variable. We are passing this to the Slack body.

### Step 10

<div class="center">
  <a href="/images/bb-integromat-make-11.png" target="_blank" title="bb integromat make 11">
    <img src="/images/bb-integromat-make-11.png" alt="bb integromat make 11" />
  </a>
</div>

Our last step is to just shoot off that text to Slack. We have already formatted the text we are sending so we just slap it in.

### All Done!

That is it! Hopefully this helps anyone that is trying to use the BitBucket in [Make.com (Integromat)](https://www.make.com/en?pc=jamesdoyle&fromImt=1).
