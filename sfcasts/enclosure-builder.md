# The EnclosureBuilderService

Because we're creating lots of dinosaurs and we're creating lots of enclosures, I
think it might be a good idea to get organized and create a new helper service class
called `EnclosureBuilderService`. You know what that means... description time!

```terminal
./vendor/bin/phpspec describe App/Service/EnclosureBuilderService
``` 

That creates the new spec class and. And *thanks* to that new spec class, we can
generate the class immediately with:

```terminal
./vendor/bin/phpspec run
``` 

to generate that new class immediately. And... there it is!

## Describing the new Feature

Here's the new plan: we'll add a method to the new service where we can pass it
the number of dinosaurs we want, how much security we want, and... it will take
care of the rest!

Let's put that into an example! How about
`function it_builds_enclosure_with_dinosaurs()`. Inside, let's see, I'd like to be
able to create a new `Enclosure` by saying `$enclosure = $this->buildEnclosure()`.
We'll pass that the number of security systems we want - 1 - and the number of
dinosaurs we want: 2. Now, we can do some basic checks, like
`$enclosure->shouldBeAnInstance()` to make sure an `Enclosure` is returned.

Oh, and very important! I want to make sure the new `Enclosure` has active security:
`$enclosure->isSecurityActive()`. Wait... but that's not auto-completing - I thought
we added that method! Oh, it *does* exist, but it's private. We'll need to fix that
in a minute. Anyways, use `$enclosure->isSecurityActive()->shouldReturn(true)`.

Simple enough! We're not asserting anything about the dinosaurs yet, but it's a
good start. In `Enclosure`, make `isSecurityActive()` public: we've discovered
that we *do* need to use this from outside of this class. And *because* it's public...
and because I like to keep things organized, let's move it up above the private
functions.

Much better. Let's try this!

```terminal-silent
./vendor/bin/phpspec run
``` 

It fails, but generates the new method for us. Then it fails again... because that
method is empty. I hope these steps are boringly routine at this point.

## Implementing the Feature

With the tests red, let's write some code! Open `EnclosureBuilderService` and...
fill in the method! I'll break the arguments into multiple lines - they're gonna
be long - and advertise that this returns an `Enclosure`. Change the args to
`int $numberOfSecuritySystems` and I'll default it to 1 and
`in $numberOfDinosaurs = 3`. Then, `$enclosure = new Enclosure()` and we'll offload
the real work into other private methods:
`$this->addSecuritySystems($numberOfSecuritySystems, $enclosure)`.

At the bottom, return `$enclosure` - we'll worry about the dinosaurs in a minute.
For the `addSecuritySystems()` method, I'm going to cheat and paste that in - you
can find get this code on the code block on this page. Make sure to re-type the
`y` on `Security` and hit tab to auto-complete that and get the `use` statement
on top.

It's nothing special: it takes in the `$numberOfSecuritySystems`, does a `for` loop,
chooses a random name and sets the "is active" lag to true.

We're not adding any dinosaurs yet, which is fine because we're not asserting
anything about them yet. We'll worry about that in a minute. Right now, run phpspec!

```terminal-silent
./vendor/bin/phpspec run
``` 

Green! This wasn't anything new, but now we have an *awesome* problem. In 
`EnclosureBuilderService`, we need to create some dinosaurs... but we are *not*
going to create them by hand. Nope, we already have this beautiful `DinosaurFactory`
that's able to create dinosaurs. So, we're going to use this instead. And that
means that `EnclosureBuilderService` will need `DinosaurFactory` as a dependency.
And *that* means, in order to finish the example, we are going to need to mock
`DinosaurFactory`.

That's next.
