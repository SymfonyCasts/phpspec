# Registering & Autoloading a Custom Matcher

Inline matchers are easy! I love that! But you can't reuse them across multiple spec
files - that's a bummer. Fortunately, phpspec is awesome and so - of course - it *does*
have a way to create a matcher that can be used anywhere. And... what's
even *better* is that there are a *lot* of great examples to learn from.

And here's one: go to https://github.com/karriereat/phpspec-matchers - I... probably
butchered that username - sorry! Anyways, this library is cool: it's just a big
collection of custom matchers! Well, technically it's a phpspec *extension*, which
means it's a "plugin" for phpspec.

Unfortunately, this library does *not* work with the latest version of phpspec at
this time. But... who cares!? It is *still* an awesome source of inspiration for
writing your own custom matchers. Each of these classes represents one matcher.

## Describing a Potential Bug

Here's our next goal: our scientists are starting to grow dinosaurs for the park,
but have reported a possible bug in the `Dinosaur` class! No problem! When you
have a bug, the *best* thing to do is write a test for it: to describe the *correct*
behavior so we can make sure our class has that.

In this case, someone reported that, when a dinosaur is created with a length of
15, sometimes... it shrinks! We've talked to our scientists and they say that *some*
shrinking is ok, but a dinosaur should definitely not shrink below a length of 12.
Wow, it turns out that growing a dinosaur is complex!

Let's translate this expected behavior into a new example:
`function it_should_not_shrink()`. Set the length of the dinosaur to `15` - and 
notice that we *do* get auto-completion now that the `setLength()` method exists.

Then say, `$this->getlength()`... but... hmm. In this pretend example, the dinosaur
is allowed to shrink *some* but not below 12. To reflect that, let's say:
`->shouldBeGreaterThan(12)`

As you probably saw, that is *not* a real matcher. So, the tests should fail. Try
them:

```terminal-silent
./vendor/bin/phpspec run
```

They... pass? Hmm... ah! A typo! And this *proves* that each example *must* start
with `it_` or `its_`. Try phpspec again:

```terminal-silent
./vendor/bin/phpspec run
```

*There* is the failure we expected.

## Creating our Matcher Class

We know that we *could* create an inline matcher. But... I kinda want to be
able to re-use this in other spec classes. To do that, we can create a matcher class.
In the `spec/` directory, create a `Matcher` directory and then a new class:
`BeGreaterMatcher`... though this class could live anywhere. The namespace should
be `spec` then the directory path. So `spec\Matcher`.

But, let's keep this class empty for now: I just want to make sure that phpspec
can *see* our new matcher. How? Via its config! Open `phpspec.yml`, add a `matchers:`
section and then, very simply, list your matcher: `- spec\Matcher\BeGreaterMatcher`.

That's it! It won't *fully* work yet of course... but let's see what happens. Run
phpspec: 

```terminal-silent
php vendor/bin/phpspec run
```

Interesting:

> Custom matcher `spec\Matcher\BeGreaterMatcher` does not exist.

This is basically a "class not found" error. Copy the namespace. Yeah... that looks
correct... I don't see any typos. So... what's the problem? Autoloading!

## Autoloading the phpspec Directory

Open the `composer.json` file. We configured composer to be able to autoload things
from the `src/` directory, but we haven't configured it to be able to autoload
things from the `spec/` directory. phpspec does *not* need any autoloading
to be setup to find the spec files - it handles all of that itself. But if you want
to put any *other*, non-spec, classes in this directory - like a matcher - then we
*do* need to set up autoloading.

No problem: copy the `autoload` section, paste and change it to `autoload-dev`.
Tell composer to expect the `spec\\` namespace to live in the `spec/` directory.

To make Composer rebuild its autoloader, run:

```terminal
composer dump-autoload
```

Cool! Try phpspec again:

```terminal-silent
php vendor/bin/phpspec run
```

*Much* better! It *does* see it, and now we get:

> Custom matcher spec\Matcher\BeGreaterMatcher must implement... some Matcher interface.

Apparently all matcher classes need to implement this interface. That makes sense!
Let's do that next - and finish this!
