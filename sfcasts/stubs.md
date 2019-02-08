# Stubs

There are basically two big things you can do with a test double. First, you
can add behavior: you can tell it *exactly* what value to return when a certain
method is called, instead of returning null. Second, you add expectations. For example,
you can assert that a certain method on `DinosaurFactory` should be called a certain
number of times and even with some specific arguments.

## Controlling Method Return Value

Right now, we need to control the return value of the `growVelociraptor()` method.
Instead of returning `null`, which will probably explode when `EnclosureBuilderService`
tries to add `null` to an `Enclosure`, we need it to return a `Dinosaur` object.

Check this out: create a `$dino1` variable set to `new Dinosaur()` with `Stegosaurus`
and `false`. And let's set its length to, how about, 6. *Here* is the key part: we
want our `DinosaurFactory` dummy object to return *this* `Dinosaur` when somebody
calls `growVelociraptor()`. I know... that's kind of confusing because this is *not*
a velociraptor... but that proves my point! We can *completely* control how this
behaves.

[[[ code('2649550663') ]]]

Do it with `$dinosaurFactory->growVelociraptor()`. So, we *pretend* like `$dinosaurFactory`
is a real object and, just like normal with phpspec, we call methods on that object
and pass in real arguments. Let's say that, whenever we use the `EnclosureBuildersService`,
it will *always* grow a velociraptor of length 5. Then, to control the return value,
say `->willReturn($dino1)`.

[[[ code('4243c067a0') ]]]

That's it! Actually, we just did *both* things that I said you could do with a
test double. First, by saying `$dinosaurFactory->growVelociraptor(5)`, we've added
an *assertion* that if this method is called, it *must* be passed the argument 5.
If any other value is passed, the test will fail. More on that later. And second,
we've controlled the return value with `->willReturn()`.

There are a few other "will" methods you can use to control the return value, and
the most useful by far is just to say `->will()` and pass that a callback function.
That's super useful if a method is called multiple times and you need to return
different values each time. More about *that* later too.

So... let's run the test!

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:18
```

Oh! That doesn't work! Because... yea - we're now on line 19. Try it again:

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

The test still passes... but we haven't *actually* added any new assertions yet.

## Using the Object in EnclosureBuilderService

Let's get to work! Open `EnclosureBuilderService`. Here I'll hit Alt + Enter on
`$dinosaurFactory` and select "Initialize Fields" to create and set that property.
Down below, let's call a new method called `addDinosaurs()` and pass it the
`$numberOfDinosaurs` argument. To add that new method, I'll put my cursor on
`addDinosaur()`, hit Alt + Enter and "Add Method".

[[[ code('b7c220432e') ]]]

Next, copy the inside of `addSecuritySystems()`, paste it here, then clear out the
inside of the loop. Change the variable to `$numberOfDinosaurs` and, very nicely,
we can say `$enclosure->addDinosaur()` and pass that 
`$this->dinosaurFactory->growVelociraptor()`. And, remember: in the example we
expected this to be called *always* with a length of `5`.

[[[ code('d87b9e8fe5') ]]]

Perfect! Move over and run the test again:
 
```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
``` 

It still passes. *And*, check out the wrapped object we're dumping: there are now
*two* dinosaurs inside! And... interesting! They're actually the *exact* same
`Dinosaur`. That makes sense: each time the `growVelociraptor()` method is called,
our test double returns that *same*, one `Dinosaur` object.

This is cool because we can add a great assertion down here:
`$enclosure->getDinosaurs()[0]` - to get the first `Dinosaur` - `->shouldBe($dino1)`.
And, it's a little odd, but we can even check that the *second* `Dinosaur` is *also*
this exact `$dino1` `Dinosaur`.

[[[ code('54ae4ef34c') ]]]

Try the test again:

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

Still green! This is the first, great superpower of these test doubles, or dummy
objects. By adding behavior to them, we can help control *exactly* what happens
inside the class we're testing. And, it often allows us to have very specific assertions.

## Returning a Different Object Each Time

To make this a bit more realistic, copy `$dino1` and make a new `$dino2` - how about
a `Baby Stegosaurus` with length 2. Adorable. I want to change the `$dinosaurFactory`
test double so that it returns `$dino1` the *first* time `growVelociraptor()` is
called and `$dino2` the second time it's called... which is a bit more how things
would work in the real world. How can we do this? By passing a second argument to
`willReturn()`.

[[[ code('939162762e') ]]]

That's it! Down below, the second object will now be `$dino2`. Try the tests one
last time.

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

Green! Geez - we didn't manage to break *anything* in this video - we gotta try
harder! By the way, when you control the return value of a test double, it's
then called a "Stub"... which is probably not that important to know, except for
impressing other programmers at a party.

Next: let's talk a little bit more about this "5" argument. As it turns out, there
are a *lot* of interesting things you can do with this argument. Like, what if
`EnclosureBuilderService` always calls this method and passes a random number?
What should we put here? Or, what if it's called multiple times with different
arguments each time? Let's jump on that!
