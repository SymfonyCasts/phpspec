# Describing Object Construction

Let's describe a new behavior that we need for our `Dinosaur` class. I want to
be able to easily get a "description" of the Dinosaur - a string that will contain
the type of dinosaur, whether or not it's likes to eat people and its length.

Let's turn that into a new example: `function it_should_return_full_description()`.
For this first example, we'll describe what the description should look like if
we set *no* data. Let's say that there should be a new `getDescription()` method
that `shouldReturn()`:

> The Unknown non-carnivorous dinosaur is 0 meters long

Cool! Our `Dinosaur` doesn't even *have* anything on it about what "type" of
`Dinosaur` it is, or whether it's carnivorous or non-carnivorous - but those are
details for future Ryan to worry about. Let's live in the now! Run the test:

```terminal
./vendor/bin/phpspec run
```

Yay failure! And it happily offers to generate that `getDescription()` method for
us. Yes please! When it re-executes itself, it fails like normal - that new method
is blank.

## The Wonderful Lesson of Hardcoding Return Values

Ok, remember red, green, refactor cycle? For step two, we're technically supposed
to make this test green with as *little* work as possible. Yea, to follow that
perfectly, we can literally copy this string, go into `Dinosaur`, find the new
method, and return that hardcoded string. We are *awesome* at programming! For
extra credit, let's add a return type.

Yes, I *do* realize how silly this is. And no, I don't ever do this while I'm
coding for real. But, there's something beautiful about it: it's a reminder to
focus on what we *truly* need to accomplish in this method - and to *not* over-complicate
things or add extra options we don't need yet. BDD says: if you need your code
to be more flexible, you'll discover that naturally after describing that new
behavior in a spec file. The design of your code "emerges" naturally after writing
those examples and getting them to pass.

When we try phpspec again:

```terminal-silent
./vendor/bin/phpspec run
```

Shocking! It passes!

## Describing Constructor Arguments

Head back to our `DinosaurSpec` class - to fully describe how we want the new
`getDescription()` method to work, we need a few more examples. Let's see: the
description contains details about the "type" or "genus" of dinosaur - like a Tyrannosaurus
or Stegosaurus - and whether or not it wants to eat you. I mean, whether or not
it's carnivorous.

Right now, our `Dinosaur` class doesn't even have a way to set this type information.
We need to fix that. Hmm, how do we want to set that info? For the length, we added
a `setLength()` property. But, I think that the *type* of dinosaur and whether or
not it's carnivorous are *so* important, that they should be passed via a constructor
when instantiating a `Dinosaur`.

Let's create an example: `it_should_return_full_description_for_tyrannosaurus()`.
Until now, we know that, behind the scenes, phpspec handles instantiating a new
`Dinosaur` object for us so that when we called `getDescription()`, it eventually
calls that method on the real object.

That's cool, but what's *cooler* is that we can control *how* it's instantiated.
To do that, say `$this->beConstructedWith()` and - quite literally - we just pass
the arguments here that we want to pass to the new `Dinosaur` object. Hmm, I think
the first argument should be the dinosaur type - tyrannosaurus - and the second
a boolean for whether or not it's carnivorous - definitely `true`.

Now... keep going like normal! Let's set a length - `$this->setLength(12)` - and
then assert that `$this->getDescription()->shouldReturn()` the string

> The Tyrannosaurus carnivorous dinosaur should be 12 meters long

Perfect! And thanks to *this* new example... our hardcoded return statement? Yea,
that's not going to work anymore.

## How the Objects are Constructed

Oh, by the way, what if we had *two* `beConstructedWith()` lines with different
arguments? I know, this looks silly - but this *can* happen in some cases when
you use a nice setup function called `let()` that we'll learn about later.

Anyways, what would happen here? And error? Nope! The *last* call always wins.
The *reason* is the most interesting part. Behind the scenes, phpspec *delays*
instantiating the object as *long* as it can. In this case, it doesn't actually
instantiate the `Dinosaur` object until we call a method on it like `setLength()`.
At *that* moment, phpspec realizes it needs to instantiate the object and creates
it using the arguments that were passed to the last `beConstructedWith()` call.

Ok, let's run phpspec and get to the "red" part of the cycle:

```terminal
./vendor/bin/phpspec run
```

Hey! This is really interesting: it says that the method `__construct()` was not
found! It *realizes* that we're saying `beConstructedWith()`... but we're missing
that method! And of course, it even offers to generate it. Say yes.

Next, let's hook up the constructor and work with phpspec to get our examples
passing.
