/*
Title: compare md5 multiple hashes
Date: 2013-09-15
Category: Snippets, Personal Project, Web
Template: post
Keywords: md5, hash, multiple, files, shell, bash, trim, compare
*/

Sometimes you need to check a file against a `md5` hash. This can be annoying. Just look at this output:

```shell
# command
md5 file.xml ~/Downloads/file.xml file2.xml

# output
MD5 (file.xml) = 389a537b7443108f610038b4e4dd549a
MD5 (/Users/james2doyle/Downloads/file.xml) = 389a537b7443108f610038b4e4dd549a
MD5 (file.xml) = 389a537b7443108f610038b4e4dd549a
```

Well it would be nice to not see all that junk in front of the hash. If they were lined up then it would be easier to compare them. Like so:

```shell
# command
md5-check file.xml ~/Downloads/file.xml file2.xml

# output
389a537b7443108f610038b4e4dd549a
389a537b7443108f610038b4e4dd549a
389a537b7443108f610038b4e4dd549a
```

Better. Here is the `md5-check` function I wrote to take an array of arguments and then trim out all the garabage.

```shell
function md5-check() {
  for ARG in "$@"
  do
    temp=$(md5 $ARG | cut -d'=' -f2)
    echo $temp | tr -d ' '
  done
}
```

It is also good for saving the output of a md5 hash:

```shell
# output into file
md5-check Downloads/logo.jpg | > check.md5

# check the contents of the check.md5 file
cat check.md5
6ed200ea7afa42e3bd90010fb14b06fd
```

Or you can read the file contents and compare it to the file's md5 hash:

```shell
md5-check Downloads/logo.jpg && cat check.md5
```

this would output like so:

    6ed200ea7afa42e3bd90010fb14b06fd
    6ed200ea7afa42e3bd90010fb14b06fd

Seems a bit easier to compare the results of the hashes. Although I never really use them, I think it makes sense when you are transfering large files or you are downloading files in chunks.