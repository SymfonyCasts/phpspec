# Coding & Debugging

phpspec just generated the `__construct()` method for us. Thanks buddy! Go check
it out! Two cool things here. First, in `Dinosaur`, yes, it *did* add the constructor
method. As a bonus, it even put it in the right place: after the properties, but
above all the other public functions. phpspec, are you trying to take my job?

Second, when phpspec re-ran all of the examples, well... they're almost *all* failing
now: too few arguments to `Dinosaur::__construct()`. And... that makes sense! We
just *massively* changed the way that our `Dinosaur` class is designed. And so, any
existing coding using that class will probably be totally borked! This is a great
example of how our tests can give us feedback. They're saying:

> Ryan! Do you realize that you just broke *all* of the code
> in your app that creates new `Dinosaur` objects???

If we did that on accident... well... that would be a *pretty* good warning to get.

## Implementing the Constructor

Let's get to work: the first argument should be a `string $genus` and the second
`bool $isCarnivorous`. I'll press Alt+Enter and select "Initialize Fields"... which
is a shortcut to create those two properties and set them. Remove the TODO.

This is cool. But... I'm going to make both of these arguments *optional*. Why?
Well, it's *entirely* up to you how you want your class to work. Look back at
`DinosaurSpec`. According to this example, it looks like it *should* be legal
to create a `Dinosaur` object with no information. If you do, the type should be
"unknown" and it should default to *not* eat you... which is kinda nice. *This* is
"design by spec": we're using our examples to *drive* how the class is built.

Default `$genus` to `Unknown` and `$isCarnivorous` to `false`.

[[[ code('af50014748') ]]]

## Using --verbose

The `getDescription()` method is still wrong. But, we *did* just get a step closer,
so let's try phpspec again:

```terminal-silent
./vendor/bin/phpspec run
```

Yep! The two strings don't match. By the way, see how it truncates the
two strings? Sometimes that makes it hard to figure out what's going on. If you
need more info, run phpspec with the `--verbose` option:

```terminal-silent
./vendor/bin/phpspec run --verbose
```

Back in `Dinosaur`, let's finish the `getDescription()` method. Wrap the string in
`sprintf()` then add a few wildcards: one for the genus, one for the `non-`
part and one for the length. Fill these in with `$this->genus`, a ternary to print
either nothing, or `non-`, and then `$this->length`.

[[[ code('5996435953') ]]]

Oh, and let's make a typo to spice things up! Then, move over, take off the `--verbose`
option and run spec:

```terminal-silent
./vendor/bin/phpspec run
```

It *does* fail... but... it's not exactly obvious *why*: the truncated strings
look identical! *This* is when running with the verbose option is handy:

```terminal-silent
./vendor/bin/phpspec run --verbose
```

Much better - the typo is super obvious now. Fix that, then try it again:

```terminal-silent
./vendor/bin/phpspec run --verbose
```

Ah! It *still* fails! Whoops - I made a mistake in the spec file - but it's obvious.
I've been using phpspec for *so* long that I can't avoid saying "should" in everything
I type. Change `should be` to `is`: that's the language we want.

[[[ code('55a9ca7201') ]]]

Try it one more time:

```terminal-silent
./vendor/bin/phpspec run
```

It passes! Next: with production ramping up, we need a factory for our dinosaurs.
Let's see how we can describe that with phpspec.
