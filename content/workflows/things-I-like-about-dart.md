+++
title = "Things I like about Dart"
description = ""
date = "2025-02-08"
category = "Workflows"
template = "post.html"
[taxonomies]
keywords = ["dart", "typescript", "javascript", "node", "frontend", "server", "flutter"]
+++

{{ image(title="Dart logo", src="/images/dart-logo.png") }}

### Preface

The main perspective here is comparing Node.js to Dart.

If you take the temperature of JS developers today, you'll likely find frustration. Common complaints include dependency management, build systems, framework bloat, upgrade woes, and the increasing expectation of using TypeScript over plain JS, which adds its own tooling and cognitive overhead.

### Wait! What about Bun, Deno, etc?

I have used both just to play with and see how they work. A major advantage of both Bun and Deno is their built-in TypeScript support, eliminating configuration hassles. This is a significant win for developer experience.

I really like what Bun is trying to do. I think their goal of including things you need to make "web" projects ("serve" API, database support, file API, "S3" API, etc.) is the right move. I'd like if they added more built-in tooling to eliminate the need for separate linters and formatters.

In *Deno land*, I think their "secure by default" approach is smart. Especially since we are seeing a lot of packages get "backdoored" (taken over, maliciously modified, then published as a new version) or taken over by malicious actors. I'm not sure how much of a difference that will make, as many Node projects I've worked on require extensive permissions due to the limited out-of-the-box experience.

Deno does have a linter (`lint`, `check`), formatter (`fmt`), test runner, bench tool, and package manager built-in. So that allows you to remove a lot of cruft from your `package.json` and get a lot done with a single command. They even have a built-in LSP... just like Dart - wink wink.

Unlike Bun, Deno has a hosted standard library. While I understand the approach, I'm hesitant to add more packages to install and manage. It would be preferable to have basic functionality like JSON support included by default instead of relying on external packages.

Ultimately, until platforms like Vercel and Netlify offer Bun and Deno as engine version options alongside Node LTS, it's difficult to fully commit to them. Hopefully, that will change soon.

All that being said, let me tell you about this Dart thing...

### All Inclusive

I'm not even going to try to convince anyone to use Dart. I like it. I think it makes sense for writing servers and apps. I think the language's simple approach to types can be frustrating but also satisfying when it finally clicks.

I really want to focus on the *Developer Experience* for now. Because I think that is the thing that really shines when using it.

The `dart` command does a lot. Of course it can build and run your programs, but that is just a part of what you would want when developing modern apps and programs.

```
$ dart --help
A command-line utility for Dart development.

Usage: dart <command|dart-file> [arguments]

Global options:
-v, --verbose               Show additional command output.
    --version               Print the Dart SDK version.
    --enable-analytics      Enable analytics.
    --disable-analytics     Disable analytics.
    --suppress-analytics    Disallow analytics for this `dart *` run without
                              changing the analytics configuration.
-h, --help                  Print this usage information.

Available commands:
  analyze    Analyze Dart code in a directory.
  compile    Compile Dart to various formats.
  create     Create a new Dart project.
  devtools   Open DevTools (optionally connecting to an existing application).
  doc        Generate API documentation for Dart projects.
  fix        Apply automated fixes to Dart source code.
  format     Idiomatically format Dart source code.
  info       Show diagnostic information about the installed tooling.
  pub        Work with packages.
  run        Run a Dart program.
  test       Run tests for a project.

Run "dart help <command>" for more information about a command.
See https://dart.dev/tools/dart-tool for detailed documentation.
```

Here is just a short list:

### Manage packages (install, uninstall, upgrade, etc.)

Pretty self-explanatory here. You can manage your dependencies with the `dart` command without any additional tools. The specific command is `dart pub`. If you wanted to install a package you would run `dart pub add jiffy` and that would install `jiffy`.

In case you aren't aware, in the Node.js world, you need to pick your flavour of package manager. Be it `npm`, `pnpm`, or `yarn`, just to name the popular ones. Using `npm` has for all intents and purposes become the default. I see `pnpm` out there a lot more now but still a 3rd place to `yarn` in my experience.

### Formatting, linting, and code analysis

Dart has 3 different commands for doing checks on your code. Dart has `dart format`, `dart analyse`, and `dart fix`.

**Key Differences Summarized**

| Feature          | `dart analyze`                                  | `dart fix`                                      | `dart format`                                    |
|-------------------|-------------------------------------------------|---------------------------------------------------|---------------------------------------------------|
| **Primary Focus** | Correctness, type safety, null safety, errors   | Automated code fixes for analysis issues        | Code formatting, consistency, uniformity        |
| **Detects**       | Errors, warnings, hints, lint violations        | Issues that have associated automated fixes       | Formatting inconsistencies                       |
| **Fixes**         | No (reports issues)                             | Yes (automatically applies fixes)               | Yes (automatically reformats code)              |
| **Goal**          | Prevent runtime errors and ensure code reliability | Reduce manual effort in fixing common issues     | Automate code formatting and enforce a consistent style |
| **Configuration** | `analysis_options.yaml` (general analysis)      | `analysis_options.yaml` (uses analysis settings) | Minimal configuration (line length)             |

So already, without any additional dependencies, you can skip your `prettier`, `eslint`, and all associated plugins for that.

{{ image(title="Dart format and analyse demo", src="/images/dart-format-analyse.gif", lazy=true) }}

One of the great things about having these features centralized in the tool, is that there is a common interface for those tools. When you install a Dart package, that package can also register its own analysis options and fix rules! Very handy!

### Running tests

Dart has a test runner included in it's tool chest.

It is just another thing you don't need to think about. Node.js has a few popular projects like Jest and Vitest, but again, more things to install and learn. Also, want linting and code fixes in your tests? Oh good! Just install `eslint-plugin-jest` (or `eslint-plugin-vitest`) as well!

{{ image(title="Dart test demo", src="/images/dart-test.gif", lazy=true) }}

### Scaffolding new projects

With Dart, you can run `dart create` and it will scaffold a new project for you. They have a few included templates:

```
[cli]                  A command-line application with basic argument parsing.
[console] (default)    A command-line application.
[package]              A package containing shared Dart libraries.
[server-shelf]         A server app using package:shelf.
[web]                  A web app that uses only core Dart libraries.
```

These can be run offline and without downloading additional dependencies.

Comparing this with the equivalent on the Node side, `npx`, I think it is more specific and less capable than `npx`, but again, not another command to install/learn. Just the same old predictable tool.

### Generating documentation

This one is pretty underappreciated in my experience. Just run `dart doc` and you can generate a documentation for your project. How great is that?

The `dart doc` command actually generates a whole static HTML site. Complete with a dark mode and a search feature!

{{ image(title="Dart doc demo", src="/images/dart-doc.png", lazy=true) }}

If you want to see an example, just check out Dart's own documentation. It is generated with `dart doc`: [https://api.dart.dev/](https://api.dart.dev/)

### Devtools

The Dart devtools have to be one of the best parts about using Dart. They work a lot like the Chrome devtools. When you run `dart devtools` or run a Dart program, a website is automatically served locally for you to use the tool at. It is super similar to the Chrome devtools if you've used those before.

{{ image(title="Dart devtools demo debugger", src="/images/dart-devtools-1.png", lazy=true) }}
{{ image(title="Dart devtools demo memory", src="/images/dart-devtools-2.png", lazy=true) }}

Have you tried to use the Node devtools? I have found them to be nothing but frustrating. Usually there are multiple Node processes running and I never know which one to use. It seems to randomly stop listening to my debugger statements or will just hang. It has been endlessly frustrating.

I am really quite shocked about how bad the devtools experience is in Node. If you know, you know.

### Built in Language Server Protocol (LSP)

Having an LSP included in the tool is also a modern nicety. If you aren't aware of what an LSP is, well it is basically a server that runs in the background and gives your editor extra information about your code. It powers all those nice pop-ups and code actions you see in your editor.

Node.js doesn't natively include an LSP and it is something that needs to be setup separately. Usually people will just run the TypeScript language server over their projects even when it isn't using TypeScript. Just because that is easier and it is a high quality solution.

### Why does this all matter?

There is one really simple reason that having all these tools bundled together under the one umbrella, and that is versioning.

If you have a project written with Dart 3.3, you can install Dart 3.3 and be pretty confident that the project will run and work as it did the last time you used Dart 3.3 on that project. You can format, lint, test, fix, etc. etc. the way you did when you had Dart 3.3 last time.

Node however, well, it depends.

You need to make sure the Node version matches, the NPM version matches (remember when NPM changed lock file and peer dependencies?), and also that all the dependencies in your `package.json` were pinned at the correct versions and a lock file was present.

The sad thing about returning to some project that are developed using Node is that they can be really hard to reboot after being left alone for a while. The site or app still works perfectly fine in the deployed environment, but it has become a real chore to actually restart development on.

### In Summation

Dart isn't perfect. It has some real warts (code gen, `build_runner`) but I find that when using Dart, I feel a lot more secure and focused on building towards the actual solution in my head and not just playing **dependency conductor** trying to get all the parts to work in harmony.

I can just work and know that the tools I need to build work that I can confidently deploy.
