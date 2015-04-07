RainbowPHP
===

RainbowPHP is a set of tools for building rainbow tables and use them to retrieve hash real values.

Build a rainbow table
---

To build a rainbow table, you have to use the command ```rainbow:generate```:

```sh
$ bin/rainbowphp rainbow:generate -m 1 -e 8 -c "::Alpha::::numeric::&é\"'\(-è_çà\)=$ù\*\!\:\;\,\<\>\\" md5
```

The ```-m``` option allow you to precise the minimal size of the string. Default: 1
The ```-e``` option allow you to precise the maximal size to generate. Default: 8
The ```-c``` option allow you define your own character list to generate the table, you can use ```::alpha::``` for lowercase alphabet,
```::ALPHA::``` for uppercase, ```::Alpha::``` for both and ```::numeric::``` for numbers. Default: ```::Alpha::::numeric::```

```md5``` is the hash method to apply.
For now, here are available methods:
- md5
- sha1
- mysql_password

But you can chain them: if you want to generate the md5 of a md5 of a sha1, type ```md5,md5,sha1```

You can use the option ```-f``` to give the file to write in instead of the STDOUT.

Build a rainbow table from a dictionary
---

To build a rainbow table from a dictionary, use ```rainbow:generate``` with the ```-d``` option.

Example:

```sh
$ bin/rainbowphp rainbow:generate -d my_dictionary.txt sha1
```

Guess a hash type
---

You can try to guess a hash type with ```rainbow:guess```

All the possible results will be displayed.

Example:

```sh
$ bin/rainbowphp rainbow:guess foobar
The hash 'foo' seems to be not supported
$ bin/rainbowphp rainbow:guess 3858f62230ac3c915f300c664312c63f
1 type of hash has been found for the hash '3858f62230ac3c915f300c664312c63f': md5
```

Find a hash in a rainbow table
---

To find a hash, you have to use the ```rainbow:lookup``` command with the ```-r``` option.

Give the generated table to the ```-r``` option, and give the hash as the command argument.

You can use the ```-d|--deep-search``` option to find all the results in the table for the hash. If two values have the same hash, only the first found will be return without this option
You can use the ```-p|--partial``` option if you only have a partial hash. Combined with ```-d```, you can get all the possible values for the partial hash.

Example:

```sh
$ bin/rainbowphp rainbow:lookup -r table.txt 3858f62230ac3c915f300c664312c63f
$ bin/rainbowphp rainbow:lookup -r table.txt -pd 3858f62230ac3c915f300c664312c
```