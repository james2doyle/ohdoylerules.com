---
Title: "Simple Benchmarks With Apache AB"
Date: "2015-09-22"
Category: "Web"
Template: "post"
Description: "a tutorial for generating simple benchmarks using the Apache ab tool"
Keywords: ["ab", "apache", "bench", "load", "test", "request", "mock", "performance", "response"]
---

### Why Benchmark?

Did you know that Apache has a benchmarking tool for testing the HTTP server? It is called [ab](http://httpd.apache.org/docs/2.4/programs/ab.html "Apache ab"), and it is pretty great!

As your site grows in popularity, complexity, or size, you will want to test the site to see how it preforms. Having the site crash or lock up during peak time can be devastating for a small blog or e-commerce site. It means lost revenue, and can leave a visitor with a bad impression of your site. This can drive them to generate a bad referral, or worse, go to your competitor.

Users aren't going to care if your site is being bombarded with traffic constantly, they really only care about *their own personal experience*.

[Studies and analytics show](https://blog.kissmetrics.com/loading-time/?wide=1 "Kiss Metrics loading time infographic") that the slower your site is, the impact on your sales or target actions is affected exponentially.

### Getting ab

The `ab` tool can be found in most default Apache (httpd 2.2 and 2.4) setups. If you don't have it, you can install the `apache2-utils` package and get it from there.

### Testing

I found [a great article on this site](https://www.devside.net/wamp-server/load-testing-apache-with-ab-apache-bench "Load testing apache with ab apache bench") that explains a lot of details about using ab, setting up Apache, configuring PHP, and information about the results. You should check it out.

I used the following script, based on that article above, that tests a site in succession and prints the results to a file.

<script src="https://gist.github.com/james2doyle/1b77386317af93a0e5b2.js"></script>

To run the script, download it and unzip it. Then run `chmod +x bench.sh` to allow the script to run. Then you can use `./bench` and the script will begin.

The article I linked to above mentioned using a [delay of 4 minutes](https://www.devside.net/wamp-server/load-testing-apache-with-ab-apache-bench "Load testing apache with ab apache bench") between running `ab`.

Be careful using `ab`, as it essentially emulates a DDOS attack, in that it generates as many requests as possible as fast as possible. There is no delay option in ab, so there is no way to emulate something like "10 hits every 10 seconds" or anything like that.

### Results

Here are the things you are going to want to pay attention to. These definitions are taken from the [ab site](http://httpd.apache.org/docs/2.4/programs/ab.html "Apache ab").

* **Failed requests:** The number of requests that were considered a failure. If the number is greater than zero, another line will be printed showing the number of requests that failed due to connecting, reading, incorrect content length, or exceptions.
* **Non-2xx responses:** The number of responses that were not in the 200 series of response codes. If all responses were 200, this field is not printed.
* **Requests per second:** This is the number of requests per second. This value is the result of dividing the number of requests by the total time taken.
* **Time per request:** The average time spent per request. The first value is calculated with the formula (concurrency \* timetaken \* 1000 / done) while the second value is calculated with the formula (timetaken \* 1000 / done).

Failures and errors are generally not good. You should check your logs for anything that happened during your requests.

For *Requests Per Second*, this tells you how quickly your site was able to process all those requests. Higher is better because it means that your site was able to serve the content without hiccups.

The *Time Per Request*, although that article says it isn't important in the context of ab, I think it is still important to watch. This metric tells you how long the average request takes. Keep in mind we don't have javascript running, or
