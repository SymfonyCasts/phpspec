# Describing for Exception Messages

In the `Exception` directory that we copied a few minutes ago, there's another
exception class called the `DinosaursAreRunningRampantException`. Here's the
problem we're facing: we have these enclosures, but... they don't have any
security - no electric fence, or guard tower. We need to add that capability
to enclosures *and* throw this new exception if we try to add a `Dinosaur` to
an `Enclosure` before adding security. Because... honestly... we're having a
*real* problem where people add dinosaurs to an enclosure and then just leave
the door *wide* open. 

In `EnclosureSpec`, let's create a new example to describe this:
`it_should_not_allow_to_add_dinosaurs_to_unsecure_enclosures()`. And I want you
to temporarily ignore or forget *all* the other examples that we've been working
on, because this example is going to seemingly break all of them.

First... how does "security" for our enclosures need to be designed? A boolean property
on Enclosure to activate it? Something more complex? Actually,right now, it doesn't
matter! 

Check it out: in this example, I want to describe that if you
*simply* create a new `Enclosure`, that is not enough: it's not secure. Describe
that by saying `$this->shouldThrow()`. And this time, instead of passing the class
name of the exception that should be thrown, I'll say
`new DinosaursAreRunningRampantException()` and pass this a message: `Are you craaazy?!?`.

Are am I doing this differently? It's really up to you: you can pass the class name
if you *only* need to make sure it's an instance of that class *or* if you want to
make sure that the message is also correct, you can create the exception object
with the message you expect.

Next, the exception should be thrown `->duringAddDinosaur(new Dinosaur())` with
`Velociraptor` and `true`.

Oh, and this language is *also* a bit different than before. Earlier, we used
`during()` and passed `addDinosaur()` as an argument to that method. Well, you
can also use this more magical way: `duringAddDinosaur()`. That's a bit more
antural because you can then pass each argument like real arguments - instead
of putting them inside an array. It's up to you: they're identical.

The point is: we *now* have a test that describes that you *can't* just create
an `Enclosure` and start putting dinosaurs into it. Somehow, security needs to
be activated... whatever that means.

Let's move over and run phpspec:

```terminal-silent
./vendor/bin/phpspec run
``` 
 
Awesome! That *does* fail because it *is* still possible to add dinosaurs to
enclosures without activating security.

## Designing the Security

Ok... so how do we need enclosure security to work? The right answer depends on
your dinosaur park. But the process is universal: think about what *requirements*
you have. Is security just something you turn on or off - like with a
`activateSecurity()` method on `Enclosure`? In our case, it's a bit more complex:
we need the ability to add different types of security to different Enclosures -
electric fences around some, guard towers around another, and maybe just a sign
that says "Please stay inside" if we get really busy.

Back in the `tutorial/` directory, check out the `Entity/` directory. See that
`Security` class? Copy that and put into our `src/Entity/` folder. *Not* `spec/Entity`,
I'm *totally* messing this up right now and will pay for it later.

And, yes, yes, we're going to cheat a bit: we're going to skip the spec processes
for the `Security` class and start with something I've already created.

Each `Security` has a name - like "electric fence" or "guard tower" and a boolean
for whether it's active or not. And we pass in the `Enclosure` that this `Security`
will be attached to. For the methods - just one: `getIsActive()`.

To get the example in `EnclosureSpec` to pass, somehow, we need a way to attach
`Security` objects to our `Enclosure` class. And then, when we add a dinosaur,
we can check to make sure the `Enclosure` has at least one active `Security`.

Ok... cool! To hold the securities, let's create a `$securities` and set it to
an empty array. This will *really* be an array of `Security` objects, so let's
document that.

Now, this is interesting. If we're adding a `securities` property, shouldn't we
describe this more directly with some examples that show... I don't know... some
`addSecurity()` or `getSecurities()` methods? Well... maybe? Maybe because... we
might not need these methods! Right now, what we *do* know is that, if there are
no active securities, an exception should be thrown. And of course, we *will*
need to update some of our examples from earlier once we get this working so that
each has some active security.

Anyways, down in `addDinosaur()`, let's call another new method
`if (!$this->isSecurityActive())` we will throw a
`new DinosaursAreRunningRampantException()` and pass it the same message that we
described in our example - because we're testing for this *exact* string.

In reality, this is a bit silly example. In real life, I probably wouldn't want
to test for that exact message - the class is enough.

I'll put my cursor on the method name and hit Alt + Enter to add that method. This
will return a `bool` and inside, we can loop over the `$securities` with
`$this->securities as $security`. If at least *one* `Security` object
attached to this enclosure is active, then our enclosure is secure.
So `if ($security->getIsActive())`, then `return true`. And if *none* of them are
active, `return false`.

Okay, that should work! Move back to the terminal. Oh, see this 41? That means
the example lives on line 41 of the spec class. Ok, re-run phpspec:

```terminal-silent
./vendor/bin/phpspec run
```

It works! Sort of. Notice, line 41 *is* gone - that example is passing! By the way,
instead of running *all* your spec classes, you can run just one by passing the
filename to this command:

```terminal-silent
./vendor/bin/phpspec run spec/Entity/EnclosureSpec.php
```

*Or*, you can run just *one* example by adding colon then the line number. The
example we're working on should be line 41 - yep! There it is. Try it:

```terminal-silent
./vendor/bin/phpspec run spec/Entity/EnclosureSpec.php:41
```

Cool! 1 passed. But if we run all of them, we have a few failures.

Next: we made a change to our app that *broke* our existing examples. Let's
think about the correct way to handle this and add a few more nice features to
our `Enclosure`.