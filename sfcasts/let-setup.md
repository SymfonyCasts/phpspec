# Let: The Setup Function

This this example executing really well...

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

let's go back and run *all* of the examples in this spec class.

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php
```

Ah, oh yea! `it_is_initializable()` is still failing: too few arguments to the
constructor: zero passed, expected one. That makes sense: we added
`$this->beConstructedWith()` to our `it_builds_enclosures_with_dinosaurs()` example,
but not in the first example.

The easiest solution is just to... ya know... duplicate it! But... it does kind
of make me think: it would be nice if we could call a method *before* each example
was executed - a method that could, sort of, setup some things. After all, we're
going to need to call `$this->beConstructedWith()` in *every* single example function.

## Hello let()

Unfortunately... this is not possible... and the tutorial is now over. Kidding!
This is totally possible by creating a function called `let()`. Yep! `let()` will
be called once *before* each example function is executed. So, `let()` then
`it_is_initializable()`, then `let()` again and `it_builds_enclosures_with_dinosaurs()`.

Inside `let()`, we can do the *exact* same things as our normal methods... meaning,
if we need a test double, we can add a `DinosaurFactory $dinosaurFactory` argument.
And *this* allows us to move the `beConstructedWith()` call up to `let()`.

Ok, let's look at this: `let()` will be called first, and will be passed the
`$dinosaurFactory` test double. But then, down in the example, we need to make sure
that we get that *exact* same `DinosaurFactory` test double because *that* is the
object that we need to add behavior to.

And that is *exactly* how this will work. But, it's not just because these are
both `DinosaurFactory` objects. Nope. phpspec matches by the *argument* name:
because the argument is called `$dinosaurFactory` in `let()` *and* because it
has the same name below, phpspec knows to pass the *same* object... instead of creating
a brand-new test double.

So... unless we've mucked something up, this should make everything happy! Try it:

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

Woohoo!

## Using Mocks/Spies to Guarantee Saving to the Database

So let's do *one* last thing before you all go off and take over the world with
your new phpspec knowledge. One of the things I want my `EnclosureBuilderService`
to do is to *save* the new `EnclosureBuilder`  to the database after it finishes
building it. Now, obviously, we don't have a database in this application... but
we can fake it!

Open up that `tutorial/` directory that you should have if you downloaded the
course code. In the `Service/` directory there is an `EntityManagerInterface.php`
file. Copy that and put it into your `Service/` directory.

If you're a Doctrine user, this will look familiar. But, no, I'm not recommending
that you actually create or move the `EntityManagerInterface` into your app like
this. We're adding this interface as a convenient way to "pretend" like Doctrine
exists in our app. This interface looks *just* like the one from Doctrine, with
the same `persist()` and `flush()` methods.

## Guaranteeing the Object is Saved

Back in the example, I want to describe that `persist()` and `flush()` should be
called on the `EntityManagerInterface` when we call `buildEnclosure()` - I want
to guarantee that we didn't forget to save this to the database. And *that* means
that our `EnclosureBuilderService` will have a second dependency. In `let()`, add
a second argument: `EntityManagerInterface $entityManager`. Pass that as the second
argument to `beConstructedWith()`.

Then, down in the actual example, we want to assert that `persist()` and `flush()`
have been called on it. We'll get that same test double here by *also* saying
`EntityManagerInterface $entityManager` - using these same argument name as above.

At this point, we can use the mock or spy functionality - it makes no difference
at all. I'll do it as a spy. Start with `$entityManager->persist()`. This should
be passed an `Enclosure` object. So let's say `Argument::type()` with `Enclosure::class`.
Then, `->shouldHaveBeenCalled()`.

Repeat this with `flush()`, except that `flush()` doesn't take any arguments.

This time, we're not giving the test double *any* behavior - it's a *pure* spy.
Try it:

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php
```

Woo! It fails:

> no calls have been made that match `persist()` with type Enclosure, but expected
> at least one.

Open `EnclosureBuilderService` and let's code that up. Start by adding the
`EntityManagerInterface $entityManager` argument. I'll hit Alt + Enter to create
that property and set it. Finally, at the bottom of the method,
`$this->entityManager->persist($enclosure)` and `$this->entityManager->flush()`.

This looks *great*. Run those tests *one* final time.

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php
```

It passes! Try the entire test suite:

```terminal-silent
./vendor/bin/phpspec run
```

It works too!

Friends! That's it. phpspec is wonderful tool to help you write unit tests... but
*really* focus on the design of your object. Yes, you *do* need to get used to
a lot of the magic it does. But once you embrace the magic, the experience is
*wonderful*... and the code generation isn't too bad either.

One word of warning that I always like to give people is that just because you
have a wonderful testing tool like phpspec, it doesn't mean you need to test every
single thing. For example, in `DinosaurSpec`, we're doing a lot of testing on the
getter and setter methods. You *can* do that... but I think it's overkill. Think
of testing less as an all or nothing, and more of a *priority* system: make it
a high priority to test, or *describe* the classes that have a lot of complexity...
or that scare you.

Ok, get out there, describe some *great* classes, and we'll seeya next time!
