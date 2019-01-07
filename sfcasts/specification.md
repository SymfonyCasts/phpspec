# Buzzwords! Specification & Examples

So if phpspec is all about helping you design your classes - helping you ask: how
do I want this class to look and behave? - how... does it actually do that? The idea
is cool: instead of jumping straight into your code and hacking until something works...
or you get sleepy... stop... step back... and instead, *first*, *describe* how
you want your class to *behave*.

We do that by creating a class called a... *specification*. That's a fancy... or
maybe *boring* word that means that, before coding, we will *first* create a class
where we simply *describe* how our future class will work and act.

## Generating the Specification

Let's see this in action. Remember the two commands of the phpspec executable?
The first is `describe` - run it with `-h`:

```terminal
./vendor/bin/phpspec describe -h
```

I'm passing `-h` to see the help details. Basically, each time you want to create
a new class, you should *first* use this command to create a corresponding
*specification* class. Oh, notice that forward slashes are used for the namespaces,
that's just to avoid escaping problems.

Anyways, because we're building a dinosaur park, the *first* class we need is...
`Dinosaur`! So let's run:

```terminal
./vendor/bin/phpspec describe App/Entity/Dinosaur
```

I could have chosen any namespace starting with `App` - that's up to how you want
to organize your code. But, if you're used to Doctrine in Symfony, this will feel
familiar.

## What are Examples?

Ok! One new file: `DinosaurSpec.php`. Let's go check it out! Ok - so `phpspec` creates
a `spec/` directory, which is meant to have the same file structure that our classes
will eventually have in `src/`.

Open the new file. Ok... these spec classes look a little weird at first - and
we're going to talk a *lot* about them. The *purpose* of this class is for us to
describe the behavior of our future `Dinosaur` class. On a philosophical level,
we do this by writing example code: using our `Dinosaur` class as if it already
existed and was finished.

On a more concrete level: we describe the behavior through *examples*. Every function
in this class that starts with `it_` or `its_` will be read by phpspec as an "example".
They are the *key* to phpspec, and also the most complex part.

There are *two* very important things to understand about the code inside these example
methods. First, and this is *truly* magic, you're supposed to use the `$this` variable
as *if* we were inside of the `Dinosuar` class itself. Literally: you treat `$this`
like a `Dinosaur` object - showing *examples* of how you want it to work by calling
methods on that class - like `$this->getLength()` if the `Dinosaur` class had a
`getLength()` method.

## Hello Matchers

In addition to using `$this` to call methods that exist - or *should* exist - inside
`Dinosaur`, the *second* important thing to know is that you can *also* call a huge
number of methods that start with `should` or `shouldNot`. These are called
"matchers" - and they are the way you *assert* that things are working correctly
in phpspec.

In the one generated example function, because we're *pretending* to be inside
the `Dinosaur` class, we pretend that `$this` is a `Dinosaur` object. When we call
`->shouldHaveType(Dinosaur::class)`, this *asserts* that the object is an instance
of that class... which, by the way, doesn't even exist yet! It's a pretty pointless
test - but I usually keep it.

Oh, and the *last* strange thing about this class is that... it violates coding
standards! Did you notice the missing `public` before the functions? That's totally
legal in php - methods are public by default. And the method names are written using
snake-case instead of camel case. Both of these things are done on purpose for one
important reason: readability. We're writing PHP - but this class is meant to be
a human-readable description of our future `Dinosaur` class. And right now, our
specification says nothing more than a `Dinosaur` object should be... a `Dinosaur`
object.

## Generating the Class with run

Ready to execute the *other* phpspec command? It's called run - let's show the
help details on this one too:

```terminal
./vendor/bin/phpspec run -h
```

This is the *main* command in phpspec. Its job is to look at all of our spec
files - just one right now - and all of the *example* methods inside - and verify
whether or not the actual class *behaves* like we've described with that example code.

Now... you might think that's a bit crazy. After all, how can phpspec look to see
if our `Dinosaur` class has the correct "behavior"? The `Dinosaur` class doesn't
even exist yet! Heck, there's nothing in our `src/` directory at all! Well... let's
see what happens:

```terminal
./vendor/bin/phpspec run
```

At first, it *does* fail because `App\Entity\Dinosaur` does not exist. That's
expected. But check this out: it's asking: do you want me to create it for you?
This is what makes `phpspec` so fun! When it sees that you've described some
behavior that's missing, it can create it for you! Let's choose yes, of course!

Cool! Go look - in `src/`... there it is! It doesn't *do* anything, but... actually...
our new class *now* has the *behavior* described in our spec. To prove it, re-run
phpspec:

```terminal-silent
./vendor/bin/phpspec run
```

Woh! It works! That... does make sense. Even though we don't understand much
about how the "examples" work yet, after generating the code, if you try to create
an instance of a `Dinosaur` class..... you *do* get a `Dinosaur` object! Eureka!

Next: let's start creating some meaningful examples of how our class should behave
and see how phpspec can help us build that.
