# Expecting Exceptions

Sometimes your code will throw an exception... it's just how things are. Actually,
*sometimes* it's super important that the *right* exception *is* thrown at the
exact right time. Let's see an example - and then, see how to describe that behavior
in a spec class.

If you downloaded the course code, you should have a `tutorial/` directory. Find
the `Exception/` directory inside of that and copy that *whole* darn thing into `src/`.
This holds two exception classes, and the first one that we're going to look at
is, the very important, `NotABuffetException`. You see, we've had this problem
where sometimes we accidentally put a veggiesaurus inside an `Enclosure` with
a carnivorous dinosaur. And, well, the results have been... messy.

[[[ code('a6715e3e64') ]]]

To make sure we stop doing that, we need to throw this exception if we try to mix
carnivorous and non-carnivorous dinosaurs into the same Enclosure. And this is
*such* an important thing, we need to make sure there is a test to *ensure*
the carnage stops.

## Example for an Exception

Open up `EnclousreSpec`: because we want the exception to be thrown when the `addDinosaur()`
method is called. Let's say:
`function it_should_not_allow_to_add_carnivorous_dinosaurs_to_non_carnivorous_enclosure()`.

[[[ code('abe8e186f5') ]]]

Wow! That's a long name - but... ok! It's a great description for this example.

Here's the plan: we're going to add one dinosaur that's a veggie dinosaur and
then add a another dinosaur that's carnivorous. And *that* should trigger
the exception. Start with `$this->addDinosaur(new Dinosaur())` and make this a
veggie eater by passing `false` as the second argument.

[[[ code('495e1383a4') ]]]

Now, here is the important part: *before* we call `addDinosaur()`, again, we need
to tell phpspec to *expect* that there should be an exception. And it's probably
no surprise that the *language* to do this is *really* natural: `$this->shouldThrow()`
`NotABuffetException::class`, `->during()`, and then we tell phpspec exactly what
method should trigger this: `addDinosaur` with an array of the arguments, and we
only have one: `new Dinosaur()`, `Velociraptor` and `true` for the carnivorous argument.

[[[ code('d5dd78ccaa') ]]]

That's it! Let's try it out:

```terminal
./vendor/bin/phpspec run
```

Cool! Failure because no exception was thrown.

## Implementing the Code

Time for us to get to work! In `addDinosaur()`, we need to determine whether or
not we're allowed to add this `Dinosaur`. Let's call a new function:
`if (!$this->canAddDinosaur())` - we'll create that method in a minute - then
`throw new NotABuffetException()`.

[[[ code('a47466c52c') ]]]

Now I can click back on `canAddDinosaur`, press Alt + Enter and click "Add Method"
to create a new `private` method at the bottom. Oh, and I'm just creating this as a
private method for code organization: I could have written the logic right up
in the `addDinosaur()` function. But, it *is* nice to have a method called 
`canAddDinosaur()` - it's really clear. I'm not making it `public` because, at least
so far, we don't have any need to use it outside of this class. That *also* means
that we won't write an example for this function: examples are only for public methods.

Anyways, let's add a return type and then say
`return count($this->dinosaurs) === 0` - because if there are no dinosaurs in this
enclosure, than we can *definitely* add one - *or* we can check if the first dinosaur,
index 0, has the same "diet" as the dinosaur being added, it should be allowed. So...
hmm, maybe we'll call `->isCarnivorus()`.

But, wait... that method does not exist in the `Dinosaur` class. And actually,
the *real* problem is that the `isCarnivorous` information is not available publicly
in *any* way, except as part of the description.

This is cool! We just discovered that we need to enhance the `Dinosaur` class to
get the new feature working. Before we do that, let's finish the `canAddDinosaur()`
method: you should be able to add the dinosaur if the first dinosaur `->isCarnivorous()`
value equals `$dinosaur->isCarnivorous()`. *If* they are compatible, this dinosaur
*can* be added to the enclosure... without being eaten... hopefully.

[[[ code('7a62a12247') ]]]

We know we're not done yet, but in the spirit of "doing as little work as possible
and letting phpspec tell us what to do next", let's run it now:

```terminal-silent
./vendor/bin/phpspec run
```

Failure!

> Call to undefined method `Dinosaur::isCarnivorous()`.

We *could* now go directly into the `Dinosaur` class and just... implement that!
It's a super-easy method. But... don't we need to write an example first before we
add the code? Maybe. So far, we've been testing a lot of simple getter and setter
methods. You *can* test simple methods like this, but at some point a method is
*so* simple that... in my opinion, testing them is overkill. Focus on testing what
scares you.

But, for our great learning adventure, we *will* add some examples for this method.
Why? Because it will introduce us to a really cool matcher for boolean methods. Let's
check it out next.
