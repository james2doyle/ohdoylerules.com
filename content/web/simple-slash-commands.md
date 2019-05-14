---
Title: "Simple Slack Slash Supplier"
Date: "2019-05-13"
Category: "Web"
Template: "post"
Description: "A lambda function that provides a simple mechanism for mapping Slack slash commands to pre-built responses"
Keywords: ["slack", "slash", "commands", "node", "lambda"]
---

*This is a reprint of the README from my project [simple-slack-slash-supplier](https://github.com/james2doyle/simple-slack-slash-supplier).*

This examples project showcases a simple way to create new slash commands without having to work too hard.

This example assumes you have access to [AWS Lambda](https://aws.amazon.com/lambda/) as well as have [created a Slash command in Slack](https://api.slack.com/slash-commands).

### Handling `application/x-www-form-urlencoded`

Slack sends their `POST` requests using `Content-Type: application/x-www-form-urlencoded`. This is not a content type that Lambda supports out-of-the-box. We need to do some legwork in order to map that raw request body to `JSON` which we can understand more easily in our Node.js handler function.

Preliminary setup:

* You must create a standalone `POST` resource action
* Be sure "Integration type" is set to "Lambda Function"
* Make sure `Use Lambda Proxy integration` is checked
* Remove the original `ANY` resource action to be sure it doesn't conflict

#### Mapping templates

In order to properly handle `application/x-www-form-urlencoded`, we need to make a mapping template for it.

Here are the steps:

* Click on "Integration Request" when viewing the details of your `POST` resource action
* Pop open the "Mapping templates" accordion
* Click "Add mapping template"
* Use `application/x-www-form-urlencoded` in the field that appears
* Scroll down and see the new form to enter in your template details
* Select "Method request passthrough" from the "Generate template" dropdown
* Put the following content in the textarea:

```
##  Ripped from "https://stackoverflow.com/a/52705985/1170664"
{
    "body-json" : $input.json('$'),
    "params" : {
        #foreach( $token in $input.path('$').split('&') )
            #set( $keyVal = $token.split('=') )
            #set( $keyValSize = $keyVal.size() )
            #if( $keyValSize >= 1 )
                #set( $key = $util.urlDecode($keyVal[0]) )
                #if( $keyValSize >= 2 )
                    #set( $val = $util.urlDecode($keyVal[1]) )
                #else
                    #set( $val = '' )
                #end
                "$key": "$util.escapeJavaScript($val)"#if($foreach.hasNext),#end
            #end
        #end
    },
    "stage-variables" : {
        #foreach($key in $stageVariables.keySet())
        "$key" : "$util.escapeJavaScript($stageVariables.get($key))"
            #if($foreach.hasNext),#end
        #end
    },
    "context" : {
        "account-id" : "$context.identity.accountId",
        "api-id" : "$context.apiId",
        "api-key" : "$context.identity.apiKey",
        "authorizer-principal-id" : "$context.authorizer.principalId",
        "caller" : "$context.identity.caller",
        "cognito-authentication-provider" : "$context.identity.cognitoAuthenticationProvider",
        "cognito-authentication-type" : "$context.identity.cognitoAuthenticationType",
        "cognito-identity-id" : "$context.identity.cognitoIdentityId",
        "cognito-identity-pool-id" : "$context.identity.cognitoIdentityPoolId",
        "http-method" : "$context.httpMethod",
        "stage" : "$context.stage",
        "source-ip" : "$context.identity.sourceIp",
        "user" : "$context.identity.user",
        "user-agent" : "$context.identity.userAgent",
        "user-arn" : "$context.identity.userArn",
        "request-id" : "$context.requestId",
        "resource-id" : "$context.resourceId",
        "resource-path" : "$context.resourcePath"
    }
}
```

* Paste the content above in the textarea
* Click "Save" to confirm the content of the textarea
* From the "Actions" dropdown select "Deploy API"
* Deploy the API changes as you normally would

Now you should now be able to handle `POST` requests with content type of `application/x-www-form-urlencoded` and they will be converted right into `JSON` automatically!

### Testing

You can edit `hello-command.json` to add details about your command in order to test the different handlers. Add new files and new tests scripts to `package.json` to keep going.

Run the commands with:

```
npm install
npm run test
```
