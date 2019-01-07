# Matchers, Examples & Generation

We have an empty `Dinosaur` class. As *proud* of that empty class as I am, I think
we need to start thinking about what we need this class to actually *do* - how we
want it to behave! This *totally* depends on your app - and what you need to use
each class for. But... hmm... let's see. I definitely want to be able to set the
length on a Dinosaur - because maybe we need to render that somewhere. Oh, and if
the length is *not* set, it should probably default to be 0.

## Our First Example

Wait. Right there. Did you notice? I just described an *example* of how our `Dinosaur`
class should work! All *we* need to do is translate that into a phpspec example!
Create a new function, start it with `it_` - because that's what phpspec requires...
and also because that helps us create descriptive & readable method names. How about:
`it_should_default_to_zero_length()`.

Inside, remember: the goal is to *pretend* like we're inside the `Dinosuar` class.
When each example is executed, `phpspec` will instantiate a `Dinosaur` object behind
the scenes and we can reference it via `$this`. That's *total* and absolute magic...
and we'll get to find out *exactly* how it works a bit later.

Anyways, right now: just imagine that `$this` is a `Dinosaur` object. To show
an example of how the length should be 0 by default, we will *literally* write
example code. For our app, I want to be able to call a `getLength()` method
to get the length. Cool! Write: `$this->getLength()` as *if* that method already
existed.

And because we want our Dinosaur's length to default to 0, call a matcher function
to assert that: `->shouldReturn(0)`.

## Matchers!

How... weird, but *cool* is that?! At any point in phpspec, you can say `->should`
to call one of phpspec's *many* "matcher" functions. These are equivalent to the
`assert()` functions in PHPUnit - the difference is purely style. Instead of saying
`$this->assertEquals(0, $dinosuar->getLength())` like you would in PHPUnit - *boring* -
you say `$this->getLength()->shouldReturn(0)`. The whole line *reads* like a clear
English sentence!

And fortunately, even though phpspec is using some legit sourcery to make this all
work, PhpStorm has great support for auto-completing these matcher functions.
Oh, and, by the way, every matcher *always* starts with `should` or `shouldNot`.
That's just a rule - and we'll learn why later.

Find your browser and go to https://phpspec.net. Click into the manual and go to
the matchers section. Nice! phpspec has a *huge* number of matchers... and someone
even thought to document them! Amazing! Right now, we're using one called the
**Identity Matcher**, which allows you to use `shouldBe()`, `shouldBeEqualTo()`
`shouldReturn()` or `shouldEqual()`. These are all different ways to compare values
using `===`.

There's also a **Comparison Matcher** where you can say `shouldBeLike()` to compare
values using `==`. And there are many, many, many more to geek out over. We'll learn
the most useful ones along the way.

## Generating the Missing Method

We *now* have one new example of how we want the `Dinosaur` class to work. Will
this example already pass? Of course not! We don't even have a `getLength()` method
yet! But, run phpspec anyways - and prepared to be... amazed:

```terminal
./vendor/bin/phpspec run
```

Yes! I love failure! The `getLength()` method is not found. Oh, but check it out! Just
like before, it *realizes* that we're describing some behavior that doesn't
exist and asks us if we want it to do our job for us! Of course we do!

Let's go check it out! Not bad! It generates the method but, unless your version
of phpspec has become self-aware - in which case... let me know what version you're
using - it has *no* idea what to put *inside* the method.

And so, after phpspec generated the code, it automatically re-ran itself, but the
new example *still* fails:

> it should default to zero length, expected integer `0` but got `null`,

*This* is the phpspec flow! One: describe behavior with an example. Two: `phpspec`
generates as much as it can. Three: we fill in the logic. Four: profit!

## Filling in the Logic

And... actually, the rules of TDD say that we should fill in the method with as
*little* code as possible to get the test to pass - including just hardcoding a value
if you can! But... more on that craziness later.

Right now, let's fill this in for real. So, hmm... because we know each `Dinosaur`
can have a different length, we will probably need a `$length` property. And, ah
yes, it needs to default to 0 - that's something we decided during the "spec" or
"description" process. Inside the method, `return $this->length`.
Oh, and to be super-cool, add the `int` return type. Viva return types!

Our class *should* now behave like our example expects. Let's see if phpspec agrees!
Run it:

```terminal-silent
./vendor/bin/phpspec run
```

Woohoo! It passes!

## Describing setLength()

But... nobody want's to visit a dinosaur park full of dinosaurs with zero length.
We need a way to *set* the length. How do we want to do that? There's no right answer:
it depends on your app. For example, we could make it a constructor argument. Or,
it might make sense in your app to have, for example, some `updateSpecs()` method
where you pass the length along with a few other things about your dinosaur. Or,
you might need a simple `setLength()` method. The *cool* thing is that phpspec forces
you to *think* about this - it forces you to ask: How will this class be used? Do
I really need a setLength() method? Or will the user set a bunch of details all
at once, and so a more descriptive `updateSpecs()` method is more clear?

Again... there's no right or wrong answer - sorry! For our app, let's create an
example showing `setLength()`: `function it_should_allow_to_set_length()`.
Inside, pretending that `$this` is a `Dinosaur` object, let's show how this should
work: call `$this->setLength()` and pass it, how about 9. After that, we should
be able to call `$this->getLength()->shouldReturn(9)`.

Done! Oh, and I want you to notice one cool thing: we now get autocomplete on the
`getLength()` method! PhpStorm has *great* phpspec integration and knows that we're
allowed to use `$this` like a `Dinosaur` object. We *don't* have auto-completion
for `setLength()`, because that method doesn't exist yet.

Let's see what phpspec thinks about our new example:

```terminal-silent
./vendor/bin/phpspec run
```

Awesome! It hates it! It fails, asks us if it can generate some code, then fails
again because that generated `setLength()` method is just blank. Go find the new
method. Hey! It even noticed that this method should have one argument. Change it
to `int $length`. Inside, `$this->length = $length`.

Try it again!

```terminal-silent
./vendor/bin/phpspec run
```

Yes! All green! This is test-driven-development the phpspec way. Oh, and yea, we'll
talk more about TDD, BDD and what all those buzzwords mean in the context of phpspec
a bit later.

Next, instead of relying on the built-in matchers - like `shouldReturn()` - let's
create our own *custom* matcher. Why? Because a custom matcher can help us write
examples with *perfectly* natural language.
