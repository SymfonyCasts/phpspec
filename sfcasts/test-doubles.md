# Test Doubles

It's *finally* time to talk about one of the most critical parts of unit testing:
mocking. Oh, and it's kind of the most fun part too!

## To Mock or Not to Mock

Check out `EnclosureSpec`: we already had at *least* one situation where we called
a method and needed to pass *another* object as an argument - a `Dinosaur` in this case.
When the object you're testing has a *dependency* on another object like this, you
have two options. First, you can just pass the real object, and that's what we've
been doing so far. This is a simple and excellent solution when the object you're
passing is easy to instantiate and doesn't have any side effects - most commonly,
objects that just hold data.

The *second* solution - mocking - is perfect for all the *other* situations: when
the object you're using is a pain to instantiate, its behavior is complex or its
methods *do* things - like it makes database queries. In those cases, we do *not*
want to use the real object: we want to mock... or create a test double... or a dummy.
These are all terms that sorta describe the same thing - we'll discuss as we go along.

## Creating a Mock Object

Let's see this in action! Create a new example:
`function it_should_allow_to_check_if_two_dinosaurs_have_same_diet_using_stub()`.
Yea, we'll discuss that word "stub" along the way.

Check this out: instead of creating a new `Dinosaur` object, add an *argument* to
the example method with a `Dinosaur` type-hint. Let's `var_dump($dinosaur)` and
then see what happens when we run phpspec:

```terminal-silent
./vendor/bin/phpspec run
```

Oh... interesting! It's some sort of a `Collaborator` object. But what I *really*
want you to see is that, inside of it, is something called an `ObjectProphecy`. Woh,
cool name.

Technically speaking, phpspec doesn't have its own mocking system - it uses a
totally independent library called prophecy. Well, the truth is that the phpspec
team made and maintains both libraries - but prophecy *is* its own library, and
can even be used in PHPUnit.

But the point is, this is *not* a real `Dinosaur` object, it's a "fake" object that
looks and *smells* like a `Dinosaur` object and one that we can completely control.
And getting a mock object is easy! Just add an argument type-hinted with the class
or interface you need to mock - phpspec & prophecy take care of the rest. I *love*
that.

## Controlling Method Return Values

So... what can we do with this `$dinosaur` mock? Well, you could take *full*
control over the return value of *any* of its methods. Or you can check to make
sure that one of its methods was called. We have 100% control over how this object
behaves.

For this example, we're testing that the `hasSameDietAs()` method behaves correctly.
We're basically doing the *same* example as before, but with a mock. And so, when
our code calls `isCarnivorous()` on the mocked `Dinosaur`, we need that to return
false.

Cool - let's tell our mock about this: `$dinosaur->isCarnivorous()->willReturn(false)`.
I like that! It feels a *lot* like normal phpspec code! Except instead of
`getGenus()->shouldBe()` to assert a return value, we're instead *training* the
mock: we're *teaching* it how it should behave.

*Now* we can say `$this->shouldHaveSameDietAs($dinosaur)` - remembering that
`$this` will *not* be carnivorous, because it was constructed with no arguments.

Cool! So let's see what phpspec thinks:

```terminal-silent
./vendor/bin/phpspec run
``` 

Ha! That actually passes!

## Mocks, test doubles, spies, stubs, Larry

These fake objects are called test doubles, but you'll hear them called by a number
of other names as well, like `stubs`, `spies`, `mocks` and sometimes even `Larry`.
When you hear these words, they're all basically referring to the same idea, though
*technically*, each word - like `stub` or `spy` refer to different cool "things"
that you can do with these objects.

For example, when you want to control the return value of an object, then suddenly
this "fake" object is known as a stub. So, in our example, `$dinosaur` is
technically a stub. Later, we're going to do things like assert that a certain
method was called. Like, we could say: I want to assert that the `isCarnivorous()`
method was called exactly one time. When we do *that*, the test double object
will be known as a spy or a mock.

The point is: these terms are all different ways to describe the same idea of getting
a fake object from phpspec and then either training it to have some sort of behavior
or asserting that certain methods were called on it. To some people, this distinction
is super important. For me, I can never remember the difference, and I don't care
that much. Though, as we'll see later, prophecy's documentation uses these words a
lot - so it's good to know a little bit about them.

But before we get there, let's add another service to our application - an
`EnclosureBuilderService`. This will let us build enclosures faster and, more
importantly, is going to be a kick-butt example for mocking.