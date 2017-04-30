---
Title: "Purge A File From A Github Repo"
Description: "How to permanently remove a file from a repo and it's history"
Date: "2014-05-18"
Category: "Snippets"
Template: "post"
Keywords: ["github", "git", "bash", "command", "line", "cli", "terminal", "function", "arguments", "remove", "repo", "purge", "history"]
---

Ever wanted to permanently remove a file from a repo and it's history?

Add this snippet to the end of your `.bashrc` (or `.zshrc` if you are a cool guy developer):

```sh
# remove a file from the repo and from the history
git-purge() {
  FN="git rm --cached --ignore-unmatch $1"
  git filter-branch --force --index-filter $FN --prune-empty --tag-name-filter cat -- --all
}
```

This was taken from the [Github article about removing files](https://help.github.com/articles/remove-sensitive-data "Github - Remove Sensitive Data"). Here is what they said about the function:

> Run git filter-branch, forcing (--force) Git to process—but not check out (--index-filter)—the entire history of every branch and tag (--tag-name-filter cat -- --all), removing the specified file ('git rm --cached --ignore-unmatch MYFILE') and any empty commits generated as a result (--prune-empty). Note that you need to specify the path to the file you want to remove, not just its filename. Be careful! This will overwrite your existing tags.

You should also add the file to your `.gitignore`:

```sh
echo "MYFILE" >> .gitignore
git add .gitignore
git commit -m "Add MYFILE to .gitignore"
```

Then to update the live repo, run `git push origin master --force`.

This process will remove the file from your repo, and from the history. This is in-case you committed a sensitive file. If you get in a real pickle, you can use the [BFG Repo-Cleaner](http://rtyley.github.io/bfg-repo-cleaner/ "BFG Repo-Cleaner").

