---
Title: "Running Go (golang) in Docker"
Description: "How to run and deploy golang applications inside a Docker container."
Date: "2017-04-28"
Category: "Snippets"
Template: "post"
Keywords: ["golang", "docker", "container", "dockerfile", "deploy", "now.sh"]
---

Lately, I have been trying to learn golang. This means playing with a lot of tools and busting up my local environment.

In order to keep things simple, I have been using Docker container to run my applications when I am ready to deploy or build them.

<script src="https://gist.github.com/james2doyle/6489d3e60d994222ce0404c8cd500a93.js"></script>

I use [now.sh](https://zeit.co/now) to deploy the applications. Since now.sh support deploying Docker, using the Dockerfile approach makes it really simple to deploy.
