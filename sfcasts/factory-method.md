# Instantiation with a static Factory Method

Ok people - the whole "dino park" idea - apparently, it's a *huge* success!
*Especially* the velociraptors. Management wants us to grow more of them... a
*lot* more. What could go wrong?

And because we're going to need to create velociraptors so often, passing that
*whole* string to the constructor and then `true` is too much work... and spelling
velociraptor is hard! So, idea time: what if we created a static factory method on
`Dinosaur` to help us create them? Like a `growVelociraptor()` method! Hey! I just
described some new behavior! Quick! To the example...mobile!

## Telling phpspec to use a Factory Method

Add a new function: `it_should_grow_a_large_velociraptor()`. Oh, but this is tricky:
we know how to control what arguments phpspec passes to the `__construct()` method
when it creates the `Dinosaur`. But... in this case, we *don't* want phpspec to
create the `Dinosaur` object on its own. Nope! We instead want phpspec to call our
new static method and *that* will instantiate and return the `Dinosaur`.

No problem: instead of `beConstructedWith()`, call
`$this->beConstructedThrough('growVelociraptor')` - that will be the name of the
new method. The second argument is the array of arguments for the method. What
arguments should the `growVelociraptor` have? Hmm, probably just one right now:
the length. So, `array(5)`. If you need a second argument, just add another item.

Ok cool! *Now* this function will work like *any* other example - except that
`$this` will be the `Dinosaur` object that's returned from `growVelociraptor`. Well,
actually, we should make sure it *is* a `Dinosaur`:
`$this->shouldBeAnInstanceOf(Dinosaur::class)`. Oh, and how about
`$this->getGenus()->shouldBeAString()`. Ok, I'm just showing you that this function
exists. In this case, we know *exactly* that
`$this->getGenus()->shouldBe('Velociraptor')`.

Wait, but why did I use `shouldBe()` here when we've been using `shouldReturn()`
until now? No reason - they're identical: use whatever feels good.

Oh, and see how PhpStorm is highlighting `getGenus()`? That's because that method
doesn't exist yet. We just "discovered" that we need this method. Cool! Let's
add one more check: `$this->getLength()->shouldBe(5)`. 

You know the drill: after writing the example, run phpspec:

```terminal-silent
./vendor/bin/phpspec run
```

Honestly, it shouldn't even be a surprise any more when phpspec generates code for
us. Choose "yes" so it generates the missing `growVelociraptor()` method. And
when it re-executes... failure! A `BadMethodCallException()`. That comes from the
new function. phpspec knows this should return a `Dinosaur` object... but it's
not sure how. But hey! It *did*, once again, put this method in *just* the right
place: below the constructor but above the public functions.

Change the argument to `int $length`, advertise that this will return an instance
of `self`, and create that with `$dinosaur = new static()` passing `Velociraptor`
and `true` for the `isCarnivorous` argument. Then, `$dinosaur->setLength($length)`,
`return $dinosaur`.

That felt good! Let's make sure the example passes:

```terminal-silent
./vendor/bin/phpspec run
```

## Allowing Requirements to Emerge

Wait... it failed! Of course! The `getGenus()` method doesn't exist! That's super
cool: instead of planning ahead and adding this method earlier, we allowed the need
for this method to "emerge" naturally. What's *especially* interesting is that, so
far, the only place we need this method is in our example! What if we don't need
this method in our actual app? Should we still create it? Yes. Well, let me say that
differently. The code in our examples are meant to be *real* examples of how you
want your class to work. If you *really* don't want a `getGenus()` method, then
should write example code that doesn't use it. If you *do* use it, you need it!

So, yes phpspec, please generate that for me. Find the new method,
`return $this->genus` and add the `string` return type. Try the tests again:

```terminal-silent
./vendor/bin/phpspec run
```

Yes! All green! Next: as *cool* as this factory method is, we need to level up
with a proper, new `DinosaurFactory` service class.
