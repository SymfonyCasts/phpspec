# Matchers (Assertions))

We have an empty `Dinosaur` class. *Now* we need to start thinking about what we
need this class to do - how we want it to behave! So, hmm... let's see. We definitely
want to be able to set the length on a Dinosaur. And, unless we decide to make it
a required argument to the constructor, the length should probably be 0 if we don't
set it.

## Our First Example

So right there: I just described an example of how our `Dinosaur` class should work!
Let's translate that into a phpspec example! Create a new function, start it with
`it_` - because that's what phpspec requires... and also because that'll help us
make really descriptive method names. How about: `it_should_default_to_zero_length()`.

Inside, remember: the goal is to *pretend* like we're inside the `Dinosuar` class.
Behind the scenes, when each example is executed, `phpspec` will instantiate a
`Dinosaur` object behind the scenes and *we* can reference it via `$this`. That's
*total* magic, and we'll look at how it works a bit later.

Anyways, right now: just imagine that `$this` is is a `Dinosaur` object. To show
an example of how the length should be 0 by default, we will *literally* write
example code. I think our `Dinosaur` class will probably need a `getLength()` method
to get the length. So let's write: `$this->getLength()` as if that already existed.

And because that should equal 0 - because we haven't set it anywhere - call a matcher
function `->shouldReturn(0)`.

## Matchers!

How... weird, but cool is that! At any point in phpspec, you can say `->should`
to call one of phpspec's *many* "matcher" functions. These are equivalent to the
`assert()` functions in PHPUnit - the difference is purely style. Instead of saying
`$this->assertEquals(0, $dinosuar->getLength())` like you would in PHPUnit, you
say `$this->getLength()->shouldReturn(0)` - writing code that reads a lot more
like a *description* of the behavior we want.

Fortunately, even though phpspec is using some serious magic to make this all
work, PhpStorm has really good support for auto-completing these matcher functions.
Oh, and every matcher *always* starts with `should` or `shouldNot`.

Find your browser and go to https://phpspec.net. Click into the manual and go to
the matchers section. Check it out! phpspec has a *huge* amount of docs about all
the different matchers. Right now, we're using one called the **Identity Matcher**,
which allows you to use `shouldBe()`, `shouldBeEqualTo()` `shouldReturn()` or
`shouldEqual()` - these are all different ways to do compare values using `===`.

There's also a **Comparison Matcher** where you can say `shouldBeLike()` to compare
two values using `==`. And there are many, many, many more - we'll talk about my
favorite ones more as we go along.

## Generating the Missing Method

We *now* have one new example of how we want the `Dinosaur` class to work. Of course,
it won't *pass* - we don't even have a `getLength()` method! But, before we jump
in and start coding, let's run phpspec... just to see what happens:

```terminal
php vendor/bin/phpspec run
```

Yep... fails! The `getLength()` method is not found. Oh, but check it out! Just
like before, it *realizes* that we're describing some new behavior that doesn't
exist and asks us if we want it to do our job for us! Of course we do!

Let's go check it out! Nice! Of course, unless your version of phpspec has become
self-aware, it has *no* idea *what* to put inside the method.

And so, after phpspec generated the code, it automatically re-ran itself, but the
new example *still* fails:

> it should default to zero length, expected integer `0` but got `null`,

*This* is the phpspec flow! First, we describe some behavior with an example. Second,
`phpspec` generates as much as it can. And third, we finally fill in the logic.

## Filling in the Logic

And actually, you're *supposed* to fill in the method with as *little* code as
possible to get the test to pass - including just hardcoding a value if you can!
We'll talk more about this later.

For now, let's fill this in for real. So, we will probably need a `$length` property
and it will need to default to 0. Inside the method, return `return $this->length`.
Oh, and to be super-cool, add the `int` return type.

Our class *should* now behave like our example expects. Let's see if phpspec agrees!
Run it:

```terminal-silent
php vendor/bin/phpspec run
```

Yes! It passes!

## Describing setLength()

But... well.. we're going to need a way to *set* the length. How do we want that
to work? There's no right answer - it depends on your app. For example, you could
make it a constructor argument. Or, it might make sense in your app to have a
`setDetails()` method where you pass the length along with a few other things about
your dinosaur. Or, you might need a simple `setLength()` method.

Let's create an example showing `setLength()`: `function it_should_allow_to_set_length()`.
Inside, pretending that `$this` is a `Dinosaur` object, let's show how this should
work: call `$this->setLength()` and pass it, how about 9. After that, we should
be able to call `$this->getLength()->shouldReturn(9)`.

Done! Oh, and I want you to notice one cool thing: we get autocomplete on the
`getLength()` method! PhpStorm has *great* phpspec integration. We *don't* have
auto-complete on `setLength()`, because that method doesn't exist yet.

Ok, example done. Let's see what phpspec thinks:

```terminal-silent
php vendor/bin/phpspec run
```

Nice! It fails, asks us to regenerate the code, then fails again because our
`setLength()` method is probably just blank. Let's move over and make this work
exactly how we want it. Change the argument to `int $length`. Notice: it realized
we needed an argument... but itt didn't know what the type or name of the argument
should be. Inside, `$this->length = $length`.

Let's try it!

```terminal-silent
php vendor/bin/phpspec run
```

Yes! All green! This is test-driven-development the phpspec way. Oh, and yea, we'll
talk more about TDD, BDD and what all those buzzwords mean in the context of phpspec
a bit later.

Next, let's create our own *custom* matcher to help us keep our examples as
natural-sounding as possible.
