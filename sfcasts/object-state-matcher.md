# The ObjectStateMatcher

We're missing the `isCarnivorous()` method on `Dinosaur`. It will be a *really*
simple method, but because it will let me show you a very special match - the
`ObjectStateMatcher` - we're going to write a couple of examples for it.

Find `DinosaurSpec` and add the first new example: `it_should_be_herbivore_by_default()`.
This example is meant to show that if we create a new `Dinosaur()` without passing
the `isCarnivorous` argument, it should default to an herbivore. Pay careful attention
to the *language* I'm about to use. Behind the scenes, because we haven't controlled
the constructor arguments, we know that phpspec will create a `Dinosaur()` without
*any* constructor arguments. So I'm going to say `$this->shouldNotBeCarnivorous()`.

[[[ code('985aaf2dde') ]]]

That is *not* a built-in matcher... right? I mean, that's *super* specific language,
and PhpStorm definitely did *not* autocomplete that for me. Well... surprise! That
*is* a real matcher! Say hello to the `ObjectStateMatcher`! It's dynamic: whenever
you say `shouldBeSOMETHING` or  `shouldNotBeSOMETHING()`, the `ObjectStateMatcher`
is activated. It parses out that "SOMETHING" part - for us the word `Carnivorous` -
looks for a method called `isCarnivorous()`, and then checks that it equals true
or, in our case, false, because we're using should *not*.

Let's write one more example before we see this. How about:
`it_should_allow_to_check_if_dinosaur_is_carnivorous()`. Inside, use
`$this->beConstructedWith()`. Remember, the `Dinosaur` class's constructor allows
us to control the `$isCarnivorous` value via the *second* argument. So, we'll
pass `'Velociraptor'` and `true`. Then we can say `$this->shouldBeCarnivorous()`.
That's the same thing as above, but without the "not".

[[[ code('6379910855') ]]]

Let's check it out!

```terminal-silent
./vendor/bin/phpspec run
```

Woh! The error from our two new examples is:

> method [array:2] not found

Um... cool... so what the heck does that mean? It's not a great error. But, the
question at the bottom tells us what is *really* going on:

> Do you want me to create Dinosaur::isCarnivorous() for you?

This is really cool! When we say `shouldBeCarnivorous()`, the `ObjectStateMatcher`
says:

> Hey! You're describing that your object "should be carnivorous". To figure that
> out, your class probably needs an `isCarnivorous()` method! So, let's create that
> thing!

Choose yes to generate it. phpspec re-runs and *does* fail - something about the
`ObjectStateMatcher` expecting a boolean, but null given. That's because our new
method is empty! Go find it, then return `$this->isCarnivorous` and add the `bool`
return type.

[[[ code('09ee54a1fe') ]]]

Find your terminal and run phpspec!

```terminal-silent
./vendor/bin/phpspec run
```

Sweet! Everything passes! Which includes both new examples inside `DinosaurSpec`
*and* the original example in `EnclosureSpec` because `Enclosure` can now use
the new `isCarnivorous()` method.

## ObjectStateMatcher with "shouldHave"

Now that our tests are green, we get to think about any refactoring we might want
to do. Here's one piece I don't love: this logic for comparing whether or not the
diet of two Dinosaurs is the same - it's just not super clear.

So, it might be nice to have a method on the `Dinosaur` class called
`hasSameDietAs()`: we pass it a `Dinosaur` and it returns a boolean.

So... cool! Let's add an example for this:
`it_should_allow_to_check_if_two_dinosaurs_have_same_diet`. And, check out the
language `$this->shouldHaveSameDietAs(new Dinosaur())`.

[[[ code('f8672b9b0c') ]]]

Two important things here. First, the `$this` object will be a `Dinosaur` object
that's created with no constructor args - so it will be a veggiesaurus. And so,
it should have the same diet as a `new Dinosaur()`, which will *also* be non-carnivorous.

Second, see this language - `shouldHaveSameDietAs()`? That language will *also*
be handled by the `ObjectStateMatcher`. Yep, when you say `shouldBeSomething`,
it looks for an `isSomething()` method. And if you say `shouldHaveSomething()`,
it looks for a `hasSomething()` method.

One of the problems *I* originally had with the `ObjectStateMatcher` was that I was
thinking about it backwards. I was thinking:

> Hey! I want to have a method called `isCarnivorous()`.

Then, I would try to figure out the correct matcher method to use - like
`shouldBeCarnivorous()` - so that it would look for this method. But really, we
need to think about it the other direction: I shouldn't care what the method name
will be called in `Dinosaur`. Nope, I can ignore that and focus on using natural
language in my example: `$this->shouldBeCarnivorous()` and down here
`$this->shouldHaveSameDietAs()`. Use natural language, and *then*... don't even
think about the method name! Just run phpspec - it'll tell you:

```terminal-silent
./vendor/bin/phpspec run
```

There it is! `hasSameDietAs()`. Generate that, then go find it. This method will
return a `bool`, the argument will be a `Dinosaur` object and we can
`return $dinosaur->isCarnivorous() === $this->isCarnivorous()`.

[[[ code('2058c47d89') ]]]

Let's try it!

```terminal-silent
./vendor/bin/phpspec run
```

We are green! Let's take that as a sign that it's safe to do a bit of refactoring
inside `Enclosure`. Remove all this complicated stuff and, at the end, just say:
`|| $dinosaur->hasSameDietAs($this->dinosaurs[0])`.

[[[ code('effdc24cd7') ]]]

Run phpspec one more time:

```terminal-silent
./vendor/bin/phpspec run
```

Got it! Next, let's talk a bit more about testing exceptions and finally add
some Security to our dino park.
