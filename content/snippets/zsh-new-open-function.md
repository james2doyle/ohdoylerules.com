/*
Title: zsh new file && open file function
Date: 2012-10-13
Category: Snippets, Uncategorized
Template: post
Keywords: zsh, new, file, and, open, function, shell, bash, command
*/

Here is a little function that I made for [oh-my-zsh](https://github.com/robbyrussell/oh-my-zsh "oh-my-zsh"). I found myself constantly doing `sudo touch app.js && open app.js`.

What this little command does is create an empty file called `app.js` and then opens it with whatever your default editor is.

#### Here is the function:

    # create a new file in the current directory and then open it
    new () {
      sudo touch $1 && open $1
    }

#### How to use:

Open your `.zshrc` file and add this function at the bottom. If you haven't yet, uncomment the line that adds the zshconfig alias. If you are looking for example aliases, well, there are a couple in this section. When you want to create and then open a file just type `new myfile.xxx`. This will create the new file in the directory and then open it with whatever editor you want.
