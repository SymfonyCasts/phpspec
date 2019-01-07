# Coding up the Custom Matcher

Apparently, a custom matcher has just one rule: it must implement this `Matcher`
interface. Cool! To see what these classes normally look like, we can cheat by
looking at the core matchers themselves!

## Peeking at the Core Matchers

Open `vendor/phpspec/phpspec/src/PhpSpec` and look in the `Matcher/` directory. Say
hello to *all* the core matchers. Check out `ThrowMatcher` - a matcher we'll use
later to help us test exceptions. Yep! It implements that interface. Let's also
look at one we're already using a lot: `IdentityMatcher`.

Oh - instead of implementing the `Matcher` interface directly, this extends a
`BasicMatcher` class, which implements that interface, but handles a lot of the
low-level work. Most of the time, you'll probably want to extend this class - it just
makes life easier.

Let's get to work! I'll close a few other files. Then, make our `BeGreaterMatcher`
extend `BasicMatcher`. I'm also going to mark the class as `final`. There's no reason
for this - it's just a general best-practice these days to mark a class as final
unless you intend for it to be sub-classed. Though, marking a class as final can
cause issues if you need to mock it. Either way - that's no important to get this
all working.

Next, go to the `Code -> Generate` menu or Command+N on a Mac, go to
"Implement Methods" and implement all *four* methods that we need. Perfect!

## Implementing supports()

The most important method is `supports()`. Let's `var_dump()` the arguments to see
what we're working with: `$name`, `$subject` and `$arguments`. Whenever a matcher
is used inside of a specification, phpspec loops over *all* of the matchers and
calls `supports()` to figure out *which* of the matchers to use.

Let's see what happens! Run phpspec:

```terminal-silent
./vendor/bin/phpspec run
```

Yep! It's dumping out *every* time a matcher is used - once for `haveType`, `returnZero`
and down here for `beGreaterThan`. That's the `$name` argument. The `$subject` is
`15` because, in our spec class, `getLength()` is returning 15 - so *that* is what's
passed to the matcher. Finally, `$arguments` is an `array` with just one entry:
12 - because we're passing 12 as the *one* argument to the `shouldBeGreaterThan()`
matcher.

Our `supports()` method *really* only needs to check to make sure that the `$name`
is equal to `beGreaterThan`, so phpspec knows that *we* handle that case. But, a lot
of times, these are written to be a bit more flexible. For example, you could use
`in_array()` to check that `$name` is one of `beGreater` or `beGreaterThan`. Then,
if you want, you can even make sure the *types* of the subject and arguments match.
We'll say that this matcher should only be used if `is_numeric($subject)` and if
the `count($arguments)` is exactly one *and* if *that* argument is also numeric.

## Implementing Matches

Awesome! So, *when* `supports()` returns `true`, phpspec will *then* call the
`match()` function on top. Our job *here* is to return `true` of everything looks
good, or false otherwise - just like our inline matcher. Let's `var_dump` the
`$subject` and `$arguments` one more time with a `die` statement - to make sure it's
called like we expect.

Move over and try phpspec again:

```terminal-silent
./vendor/bin/phpspec run
```

Yes! We *are* called with 15 as the `$subject` and the same `$arguments` array with
12 inside. Because we know there will always be exactly *one* argument, we can finish
this method `return $subject > $arguments[0]`.

## Implementing the Failure Exception Methods

Done! If the matcher returns false, phpspec will either call `getFailureException()`
or `getNegativeFailureException()` - the difference is if we're using
`shouldBeGreaterThan()` or `shouldNotBeGreaterThan()`. Our job there is to return
that same `FailureException` - I'll paste one in with a good message. This is the
same type of object that we're throwing from our inline matcher.

For the other method, copy this, paste, and just tweak the language a little bit.

We *now* have a fully-functional custom matcher that allows to use this new, natural,
language inside of *any* of our spec files. Well, that *should* be true - if everything
works! Let's try it:

```terminal-silent
./vendor/bin/phpspec run
```

It passes! Next: it's time to talk about how phpspec fits into the entire world
of testing. For example, there are functional tests, integration tests, and unit
tests... and also multiple tools like PHPUnit and Behat. Let's put this all into
perspective.
