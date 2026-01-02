+++
title = "How I use AI in Sublime Text"
description = "I still use Sublime Text and this is how I use it with AI tooling"
date = "2026-01-02"
category = "Tricks"
template = "post.html"
[taxonomies]
keywords = ["sublime text", "ai", "llm", "tools", "plugin", "extension"]
+++

## My Editor Situation

In my [previous article about Sublime Text (Why I Still Like Sublime Text In 2025)](/workflows/why-i-still-like-sublime-text-in-2025/), I mentioned all the reasons I still like using Sublime Text over any of the other editors I have tried.

In quick summary, the overall speed/performance, snippets, LSP support, project workspaces, keybinding features, build system, and plugin ecosystem/interface are still unrivaled (in my opinion) when compared across the board with other editors.

Before you mention your favourite editor, I have likely tried it—maybe with the exception of Emacs. Even then, I am unlikely to switch to anything other than [_maybe_ Zed](https://zed.dev/).

## How I Use My AI

{{ video(title="Sublime SimpleAI demo video 2", src="/videos/simple-ai-demo-2.mp4", caption="Sublime SimpleAI demo using HTML file") }}

I have been a professional web developer since about 2012, so I have quite a bit of experience. The way I use AI is likely very different from someone who only has a couple of years of experience or is only familiar with TypeScript and React.

During my day job, I do use TypeScript and React most of the time. However, I am also using [Astro](https://astro.build/), [Alpine.js](https://alpinejs.dev/), various CI/CD scripts for BitBucket and GitHub Actions, Dockerfiles, raw CSS, and occasionally Twig, Liquid, and PHP via Laravel with and without Livewire.

Outside work projects, I am regularly writing fish shell, Lua and Luau, Python, and GDScript. Keep that in mind regarding what my needs are from AI tools.

I typically **do not want or need** inline autocomplete driven by AI. "AI autocomplete" is really not for me. I prefer to converse with an AI about what I am trying to do and iterate on a snippet of code until it is what I want. Then I bring it into my editor. I have various ways of doing this, which I will cover later.

> Checking my hand written code, adding comments, writing tests, PR reviews, generating fake data. These are all things I think it is great at. These are chores I struggle to find the time to do myself. So I will delegate those to the robot for 0.01 cents per million tokens.

I am also someone who still reads the docs. Shocking, I know. But I still think the best way to get started in a framework is to read the entire documentation. Yes, read all the official documentation. I recently did this with Astro and it was incredibly helpful.

It is not a quick endeavour, but by reading about every detail of the tool, I believe it embeds something in your subconscious that helps you in ways you may not realize. But I digress.

I will usually try to visit the docs for the thing I am working on to see if there is a solution there before I turn to AI to actually generate the code for me. I think this also primes your prompting to make it more specific and hardened against common pitfalls or outdated LLM knowledge.

On to how I do use it.

### In The Editor

Given the proliferation of AI tools, it has never been easier to generate plugins for Sublime. I found an existing plugin that I liked, forked it, and made my own changes. I called the plugin [sublime-simpleai](https://github.com/james2doyle/sublime-simpleai) and it has two main features: *"complete the current line"* and *"prompt with the current file or selection"*.

The way this plugin works is that it supports OpenAI-compatible API endpoints and sends one-off requests to them. The plugin itself is very basic.

The reason it is not pinned to a specific API is that I like to bounce around to multiple LLMs depending on the task. I also like to test out new releases when they come out. This helps me do that.

One interesting part is that I used Sublime's snippet system for managing the two prompts. This is handy because it allows you to use the `$TM_` variables (editor context variables like line position, file name, project name, etc.) in your prompt.

I also insert custom variables that are helpful for writing prompts based on the editor context. One such variable is `$SYNTAX`, which uses the current syntax that the file is set to instead of a flaky mapping of the file extension to a file type. This takes advantage of how you have your editor set up. Imagine working on a `.eslintrc` file that you have set to "JSON" syntax. That file should be treated as JSON, and the file extension (of which there is none in this case) has nothing to do with the actual source code.

I even made it so that you can override any of the plugin settings at the project workspace level, including the prompts and which AI service/endpoint and model you are using. This is similar to what you would expect a VSCode-style editor to do if the integration was native.

The two functions work as follows:

#### "complete the current line"

All this does is try to complete the current line given the entire file as context. The prompt is currently:

````markdown
You are a helpful $SYNTAX coding assistant.
Complete the following code to the best of your ability.
Do not wrap the output with backticks.
Do not respond with anything other than the code completion.

Here is the snippet that you will complete:

```$SYNTAX
$SOURCE_CODE
```
````

The idea is to generate a stand-alone snippet that replaces the current line or selection. I almost never use this.

#### "prompt with the current file or selection"

Using the whole file or a selection, this attaches an additional prompt/message and opens a new "scratch" view (like a read-only tab/buffer) with the response from the AI.

The prompt for this one is quite a bit more involved, but I have had very consistent results with it and it gives me what I want most of the time.

````markdown
You are a highly skilled software engineer with extensive knowledge in many programming languages, frameworks, design patterns, and best practices.

## Communication

1. Be conversational but professional.
2. Refer to the user in the second person and yourself in the first person.
3. Format your responses in markdown. Use backticks to format file, directory, function, and class names.
4. NEVER lie or make things up.
5. Refrain from apologizing all the time when results are unexpected. Instead, just try your best to proceed or explain the circumstances to the user without apologizing.
6. Never end the response with a question as the user cannot respond.

You are being tasked with providing a response, but you have no ability to use tools or to read or write any aspect of the user's system (other than any context the user might have provided to you).

As such, if you need the user to perform any actions for you, you must request them explicitly. Bias towards giving a response to the best of your ability, and then making requests for the user to take action (e.g. to give you more context) only optionally.

The one exception to this is if the user references something you don't know about - for example, the name of a source code file, function, type, or other piece of code that you have no awareness of. In this case, you MUST NOT MAKE SOMETHING UP, or assume you know what that thing is or how it works. Instead, you must ask the user for clarification rather than giving a response.

## Code Block Formatting

You can respond with markdown. Only make changes that are necessary to fulfill the prompt, leave everything else as-is. All surrounding $SYNTAX will be preserved.

Start at the indentation level in the original file in the rewritten $SYNTAX. Don't stop until you've rewritten the entire section, even if you have no more changes to make, always write out the whole section with no unnecessary elisions.

## System Information

Operating System: $OS
Default Shell: $SHELL
Project path: $PROJECT_PATH
File name: $FILE_NAME

## User's Custom Instructions

The following additional instructions are provided by the user, and should be followed to the best of your ability.

Generate $SYNTAX based on the following prompt:

<prompt>
$INSTRUCTIONS
</prompt>

They provided the following $SYNTAX code that they wanted you to act on based on that prompt:

<document>
```$SYNTAX
$SOURCE_CODE
```
</document>
````

A small breakdown:

- First, we give it a little help with the role.
- Then we tell it how to format the output.
- Attach some system information, which can be helpful for specific languages or advice.
- Give the `$INSTRUCTIONS`, which is the content the user provided inside a Sublime dialog.
- Attach the selected code or the entire source code.

{{ video(title="Sublime SimpleAI demo video 1", src="/videos/simple-ai-demo-1.mp4", caption="Sublime SimpleAI demo using webmanifest file") }}

{{ video(title="Sublime SimpleAI demo video 2", src="/videos/simple-ai-demo-2.mp4", caption="Sublime SimpleAI demo using HTML file") }}

{{ video(title="Sublime SimpleAI demo video 3", src="/videos/simple-ai-demo-3.mp4", caption="Sublime SimpleAI demo using React component in Astro") }}

This may seem like a pretty crude way to use AI given all the new tools, but this approach allows me to reduce the distance I have to travel to get an AI answer for something I am in the middle of working on. This also puts the tool in my editor of choice in the way I prefer.

That is not the only way I use AI, though. I have a variety of other tools I use in the CLI rather than directly in the editor.

### Outside The Editor

#### CLI Tools

In order of how often I use them:

**[Crush](https://github.com/charmbracelet/crush)**

I use [Crush](https://github.com/charmbracelet/crush) perhaps the most out of the AI terminal tools. The UI is super slick and I like that it is integrated with LSP and MCP to help provide the best experience when working on code. It seems like other tools are also going this way, as Claude Code is now using LSP more.

**[Vibe](https://github.com/mistralai/mistral-vibe)**

I have been using [Vibe](https://github.com/mistralai/mistral-vibe) since it was released. I really like the speed and it seems well-tuned to following tasks.

**[OpenCode](https://opencode.ai/)**

I use [OpenCode](https://opencode.ai/) a little less than I used to, but they are constantly adding new features. I actually [use their Zen service](https://opencode.ai/zen) for Crush—which I’m sure is blasphemy if you know the history between the two.

**[Goose](https://block.github.io/goose/)**

I find [Goose](https://block.github.io/goose/) a little hit-or-miss, but I do find their [recipe system](https://block.github.io/goose/docs/guides/recipes/) to be a nice way to create reusable logic. They had this before "skills" and MCP actually took off.

**[Gemini CLI](https://geminicli.com/)**

I sometimes lean on [Gemini CLI](https://geminicli.com/) as they have a generous free tier and some cool capabilities with their ["extensions" system](https://geminicli.com/extensions/). Extensions package up different tools (MCP, prompts, etc.) in one package that makes them easy to install and update.

**[Aider](https://aider.chat/)**

I used to use [Aider](https://aider.chat/) quite a bit, but it fell out of favor given the lack of MCP support. There are a few PRs for this, but as of this post, none are in a current (~0.86.0) release.

I’ll toss an honorable mention to [gptme](https://gptme.org/) and [Simon Willison's LLM tool](https://llm.datasette.io/en/stable/) with the [llm-cmd plugin](https://github.com/simonw/llm-cmd). I will often use the llm-cmd plugin to help me write more complicated snippets in the terminal.

#### Other tools

**[Brave "Ask"](https://search.brave.com/ask)**

I really like the [Brave "Ask"](https://search.brave.com/ask) search tool. I have used [Perplexity](https://www.perplexity.ai/) and [Phind](https://www.phind.com/) but have since ditched both for Brave. I like the emphasis it puts on search and references; they make it really easy to find the actual links where the results came from.

**[ChatWise](https://chatwise.app/)**

I use [ChatWise](https://chatwise.app/) as my desktop AI/LLM application. It has a simple UI with a solid UX.

**[Gemini App Site](https://gemini.google.com/app)**

I will often use the [Gemini App Site](https://gemini.google.com/app) with the "canvas" tool turned on. I like using this to generate single HTML files. I actually used this workflow to write a couple of Sublime plugins as well. Very handy.

#### Codex, Claude, Etc.

I have dabbled with Codex and Claude a little bit. But the costs of those models just turn me off. I would prefer to use OpenRouter and then select the models through there but not be tied to a subscription or have to worry about switching tools or accounts. I just switch the model when I need one of the other ones.

Since I am employed as a company that is a Google Workspace customer, I have access to Gemini Pro. I have found it to be more than enough for my needs when I really need to churn on something. Especially with Gemini 3.

## For The Skeptics

There is clearly a lot of pressure for people to use these AI tools. Maybe it is because they are all losing money and are in a battle for your monthly payment?

There are clearly cases where it can be a productivity booster. Checking my hand written code, adding comments, writing tests, PR reviews, generating fake data. These are all things I think it is great at. These are chores I struggle to find the time to do myself. So I will delegate those to the robot for 0.01 cents per million tokens. And that is on the high side depending on which you pick.

So if you have been skeptical or have been struggling to find a place for AI in your workflow, maybe you are just using the wrong tools. The LLM tools are as ubiquitous as NPM packages these days, so I’m sure you can find one that works for you. Or do as I did, and build your own!
