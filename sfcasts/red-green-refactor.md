# Red, Green, Refactor Cycle + More Dinosaurs

So there's *one* more little bit of theory. Well, less *theory* - more a strategy
that you get to use with BDD or TDD and... it's *really* rewarding. It's called the
red, green, refactor cycle. It goes like this: whenever you need to add a feature
or fix a bug, you follow this simple three-step process.

First, write a test! Or, in phpspec, write an "example" showing the behavior you
want. Then, run your test to make sure it's failing - that's the "red" part.

Second, write *just* enough code to get that test to pass - and *no* more. This is
the green part of the cycle - and it's more interesting than it seems at first. The
*key* thing with this step is that you're supposed to write *just* enough code to
get your test to pass... *not* focus on writing a perfect, pretty or extensible
solution.

And then, *once* the test is green, you're free to do step 3: refactor. My favorite
thing about this cycle is that it gives you permission on step 2 to write bad or
duplicated code! I *love* this! It lets me focus on solving the *problem*, without
over-thinking the details. And if you *do* need to refactor, you can do it confidently
knowing that you're not going to break anything.

## Theory: Follow some of It

But ultimately... these are all just "recommendations". In the world of testing,
there are a *lot* of philosophical pointers and best practices that are thrown around.
At the end of the day, do whatever is best for you. Just writing *any* tests will
make your app more robust.

In this tutorial, we're going to do things - more or less - the "right" way - with
BDD and the red-green-refactor cycle. But sometimes I do the opposite! Sometimes
I write the code first and *then* the tests. It depends on the situation and
nobody is perfect. Be pragmatic.

I also don't unit test everything - actually *far* from it! Earlier, we tested the
`getLength()` and `setLength()` methods. Those were great examples - but that code
is *so* simple, I would *not* normally test it. I unit test a method if it scares
me - and then rely on integration and functional tests to cover how all the little
pieces work together.

## Output Formatters

Ok, as promised, after *all* that theory, we're going to do something fun... then
keep going. We already know how to run phpspec:

```terminal
./vendor/bin/phpspec run
```

Awesome! You can *also* pass a `format` option. This accepts a number of different
values, but one of the *best* is `pretty`:

```terminal-silent
./vendor/bin/phpspec run --format=pretty
```

Emojis! Since these check marks are super hipster, let's make phpspec use this format
by default. Open `phpspec.yml` and add `formatter.name: pretty`. 

[[[ code('b8843f44f6') ]]]

As soon as we do that, we can remove the `format` option and *still* get those check marks.

```terminal-silent
./vendor/bin/phpspec run
```

## The Nyan Cat Formatter

But... come on... this is a dinosaur tutorial! And so, what I *really* need while
practicing BDD and the red-green-refactor cycle is a *dinosaur* to tell me if my
tests are passing. Fortunately, the authors of phpspec knew this would happen,
and created the `phpspec/nyan-formatters` repository. Copy the name of the library
and run:

```terminal
composer require phpspec/nyan-formatters:dev-master --dev
```

We need to use the `master` branch because it doesn't have a proper release yet that's
compatible with phpspec 5, which is fine. While we're waiting for that, move back
to the docs and copy the extensions code. I mentioned earlier that "extensions" are
the word phpspec uses for its plugins. An extension can pretty much do anything:
it can give you custom matchers, custom formatters or even change how the generated
code is rendered - like to add more type-hints for arguments. There's a whole page
on phpspec's docs listing some of the most popular extensions.

To activate an extension, open `phpspec.yml`, add `extensions:` and then paste the
extension class name. That's it. Let's go check on the terminal... yes! It's done!

[[[ code('1683e93e31') ]]]

The purpose of *this* extension is to give us a few new formatters. One of them is
called `nyan.dino`. Ok! Run phpspec again:

[[[ code('aa551d92cc') ]]]

```terminal-silent
./vendor/bin/phpspec run
```

Hello Dino! Ok, ok - time to get back to the *real* work. Next: let's demystify all
the magic behind phpspec by looking into the `ObjectBehavior` class. That's the class
our spec class extends - and *it* is responsible for allowing us to use `$this`
as *if* we were in a Dinosaur class. Understand how that works and you'll be unstoppable!
