# Describing the Factory Service

Ok *first*, we've learned a *lot* about how phpspec so far. But... we've still
only described *one* class - and a pretty simple one! It's time to dig deeper
and add some more complexity to our app.

Here's the deal: that new `growVelociraptor()` factory method has made our life
a *lot* easier because, in our pretend app, we constantly need to create new
velociraptors. But now, we also need to be able to create a few other popular
dinosaurs - like T-rexes and Stegosaurus! We *could* keep adding more methods
to `Dinosaur`. But to keep things organized, I'd rather put all the logic into
a new class - how about `DinosaurFactory`.

## Describing a new Class

Hey! We need a new class! Well, to say it better, it's time for us to *describe*
a new class: `./vendor/bin/phpspec describe` and, for the name, how about
`App/Factory/DinosaurFactory`.

```terminal-silent
./vendor/bin/phpspec describe App/Factory/DinosaurFactory
```

That creates one file: the new `DinosaurFactorySpec`. Let's go check it out!
Just like last time, we get one *super* basic example for free - asserting that
`$this` should be an instance of `DinosaurFactory`. That's... kinda silly... but
it's enough to force some code generation! Go run phpspec:

```terminal
./vendor/bin/phpspec run
```

Why, yes! I would *love* for you to generate that class for us. *Now*, the spec
passes.

## growVelociraptor() Example

Our *first* goal is to move the `growVelociraptor()` method into `DinosaurFactory`,
but I want to follow the red, green, refactor cycle. So first, describe that
functionality with a new example: `function it_grows_a_large_velociraptor()`.
Then, call the method: `$dinosaur = $this->growVelociraptor(5)`.

Once we've coded everything up, we know that `$dinosaur` *should* be a `Dinosaur`
object. But we *also* know that phpspec adds a lot of magic. Check this out:
`var_dump($dinosaur)`. Now, run phpspec:

```terminal-silent
./vendor/bin/phpspec run
```

First, it notices that the `growVelociraptor()` method is missing. Hit enter to
generate that. Yea - scroll up to check out that generated code. Cool! The
`$dinosaur` variable is actually a `Subject` object! Right now, the underlying
value is `null` because that new method doesn't return.

But more importantly, do you remember when we saw the `Subject` object earlier?
It was in `DinosaurSpec` - when we call `$this->getLength()`, that returns the
length, but wrapped *inside* of a `Subject` object. Why do we care? Because *that*
was the magic layer that allowed us to call `shouldReturn()`.

Inside  `DinosaurFactorySpec`, it's the same thing! `growVelociraptor` will eventually
return a `Dinosaur` object, but phpspec wraps that inside a `Subject` object. Thanks
to that, we can call real method on the `Dinosaur` *or* matcher methods. In other
words, the `$dinosaur` in this class works pretty much exactly like the `$this`
variable in `DinosaurSpec`. In fact, let's steal four lines of code from here.
Paste these into the new example and change all of the `$this` to `$dinosaur`.
Re-type the "r" in `Dinosaur` and hit tab so PhpStorm adds this `use` statement.

Ok! The `growVelociraptor()` method is still empty, but let's see what phpspec
thinks!

```terminal-silent
./vendor/bin/phpspec run
```

And the tests are red! Step 2: make this work with as little work as possible...
or at least without over-engineering it. We can cheat: copy the code from the
old `growVelociraptor()` method. I'll keep this method here just an as example.
Back in `DinosaurFactory`, paste, changed the `new static` to `new Dinosaur`, change
the argument to `int length` and give this a `Dinosaur` return type.

Try it out:

```terminal-silent
./vendor/bin/phpspec run
```

Green! So *now* we get to step 3: refactor. *This* is our chance to remove duplication
or improve things. For example, if I absolutely know that we add other methods
to this class - like `growTyrannosaurus()` - it might make sense to refactor some
logic into a new `private` function here called `createDinosaur()`. Give this 3
arguments: `string $genus`, `bool $isCarnivorous` and `int $length`. Copy the first
two lines above and make each part dynamic.

Finally, the first method can be simplified to:
`return $this->createDinosaur()`, passing `Velociraptor`, `true`, and then `$length`.
We *could* have wrote the code this way initially. But now we can refactor confidently
because our tests will *prove* we didn't mess anything up:

```terminal-silent
./vendor/bin/phpspec run
```

Oh. Except... I messed something up:

> Return value of `DinosaurFactory::growVelociraptor()` must be an instance of
> `Dinosaur`, `null` returned.

Duh! I forgot my `return` statement! And I should have added a return type too.
Try it again:

```terminal-silent
./vendor/bin/phpspec run
```

*Now* we know it works. To be honest, I love the red, green, refactor cycle, but
I also don't always do it. Heck, I don't even unit test all my code - only the
parts that are complex enough to scare me. But I *do* take one important lesson
from it into everything I do: focus on accomplishing the behavior you need and
nothing more. Keep things simple *until* they can't be. And when you get there,
write a test first, *then* get crazy.

Next: we'll describe a new class that *depends* on another class. Is it finally
time to talk about mocking in phpspec? Well... not so fast...
