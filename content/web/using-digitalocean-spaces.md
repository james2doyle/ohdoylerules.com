---
Title: "Using DigitalOcean Spaces"
Date: "2017-11-18"
Category: "Web"
Template: "post"
Description: "An example project for how to use DigitalOcean Spaces with S3 tools"
Keywords: ["digitalocean", "spaces", "s3", "aws", "object store"]
---

If you are a fan of [DigitalOcean](https://m.do.co/c/802f151adea5), or you keep an eye on DevOps news, then you probably heard about the new [DigitalOcean Spaces](https://www.digitalocean.com/products/object-storage/) offering.

Spaces is essentially an AWS S3-compatible service but with that special DigitalOcean touch.

Now Spaces is not a 1:1 replacement for S3. There are quite a few features that have not yet been implemented. They also don't have any GUI interfaces for things like managing bucket policies or CORS configurations.

I made an example project for how to use Spaces with an S3 node module ([which you can find here](https://github.com/james2doyle/digitalocean-spaces-example)) to see what the differences were when actually using the service.

I was really surprised to find that it was almost identical.

Here is an example of how you might tweak your config from an S3 project:

```json
{
  region: 'nyc3', // very familiar setting
  endpoint: 'https://nyc3.digitaloceanspaces.com', // something you probably ignored before
  signatureVersion: 'v4', // spaces supports the V4 API
  s3DisableBodySigning: true // not sure if this is always required...
}
```

As you can see there is really nothing different. The main thing is `endpoint`. That controls the service basically. By default in S3 it is set to `{service}.{region}.amazonaws.com`.

Other than that, there was really nothing much different from the regular S3 usage. I found that DigitalOcean was _much easier_ to get started with. I created a bucket in a few seconds and generated an API key right away.

With S3, you usually have a few steps to create the bucket, then create an IAM user for the bucket, then update the policy, and finally, update the CORS configuration to allow the referrers and methods you want. That's a lot of steps.

If you need that level of control I would still recommend S3. But if you have a simple use-case like a public CDN, I think DigitalOcean Spaces would be a great option.
