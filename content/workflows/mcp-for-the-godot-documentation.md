+++
title = "A MCP for the Godot documentation"
description = "Use the Godot Docs MCP to aide in your development of Godot games"
date = "2025-12-07"
category = "Workflows"
template = "post.html"
[taxonomies]
keywords = ["godot", "mcp", "documentation", "http", "llm", "ai", "agent"]
+++

I have been playing with game development lately and have found it to be a really refreshing break from working in the web development space. It is so different from the way that websites are built. That being said, I have some web dev habits I wanted to bring to my game development workflow.

I have been using [Godot](https://godotengine.org/), [Defold](https://defold.com/), [Love2D](https://love2d.org/), and even playing with [Raylib](https://www.raylib.com/) a bit, to get the hang of things and try out a bunch of really different workflows.

I found that AI tools are generally pretty good at writing `gdscript`. But I did find that they often lack a proper understanding of what nodes are currently available in the version of Godot that I am working in.

I figured an MCP that only serves valid documentation for the version of Godot you are using would be great.

There are a couple of them out there. I really wanted something that was an HTTP MCP and **just the docs**. That combo didn’t seem to exist. So I thought it might be cool to try and write my own and a great chance to try out the [hosted Cloudflare Agents framework](https://developers.cloudflare.com/agents/).

After about half a day, I had a working MCP that can:

- Look up documentation in Godot using fuzz search
- Fetch specific pages of documentation
- Lock the documentation version to one you specify

### Screenshots

{{ image(title="godot mcp example screenshot 1", src="/images/godot-mcp-1.png", style="max-width:95%") }}

{{ image(title="godot mcp example screenshot 2", src="/images/godot-mcp-2.png", style="max-width:95%") }}

{{ image(title="godot mcp example screenshot 3", src="/images/godot-mcp-3.png", style="max-width:95%") }}

{{ image(title="godot mcp example screenshot 4", src="/images/godot-mcp-4.png", style="max-width:95%") }}

*These screenshots are using the [Chevey339/kelivo](https://github.com/Chevey339/kelivo) app for OSX*

The MCP allows you to look up documentation in `stable`, `latest`, `4.5`, `4.4`, and `4.3` versions. The default version is "stable".

### Tools

**search_docs**

`(searchTerm: string, version: "stable" | "latest" | "4.5" | "4.4" | "4.3" = "stable")`

> Search the Godot docs by term. Will return URLs to the documentation for each matching term. The resulting URLs will need to have their page content fetched to see the documentation.

**get_docs_page_for_term**

`(searchTerm: string, version: "stable" | "latest" | "4.5" | "4.4" | "4.3" = "stable")`

> Get the Godot docs content by term. Will return the full documentation page for the first matching result.

### Configure the MCP server

To use the hosted HTTP server:

```json
{
  "mcpServers": {
    "godot": {
      "type": "http",
      "url": "https://godot-docs-mcp.j2d.workers.dev/mcp"
    }
  }
}
```

The hosted MCP at `https://godot-docs-mcp.j2d.workers.dev/mcp` is free to use. As long as I don’t get crushed with a huge Cloudflare bill.

Or, to connect to the MCP server using a `stdio` server:

```json
{
  "mcpServers": {
    "godot": {
      "command": "npx",
      "args": [
        "mcp-remote",
        "https://godot-docs-mcp.j2d.workers.dev/mcp"
      ]
    }
  }
}
```

### How this works

The docs site uses a frontend search tool to handle their docs search. There is a file called `searchindex.js` in the docs site that contains an index of all the pages (URLs and titles, not content) on the site.

This project takes advantage of that in the following ways:

- downloads each of those `searchindex.js` files for each version of the docs
- converts the `searchindex.js` to a `searchindex.js.json` that is just json we need
- indexes that new json using [lucaong/minisearch](https://github.com/lucaong/minisearch)
- when a docs page is requested, the URL for the page is converted from HTML to markdown

The project is open source and you can find it on my [on my GitHub](https://github.com/james2doyle/godot-docs-mcp).