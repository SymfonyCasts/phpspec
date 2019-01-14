# Coding up the Custom Matcher

According to this friendly error, a custom matcher has one important rule: it must
implement this `Matcher` interface. Cool! To see what these classes normally look
like, let's cheat and dig into some of the core matchers themselves!

## Peeking at the Core Matchers

Open `vendor/phpspec/phpspec/src/PhpSpec` and look in the `Matcher/` directory. Say
hello to *all* the core matchers. Check out `ThrowMatcher` - a matcher we'll use
later to help us test exceptions. Yep! It implements that interface. Let's also
look at one we're already using a lot: `IdentityMatcher`.

Oh - instead of implementing the `Matcher` interface directly, this extends a
`BasicMatcher` class, which implements that interface, but handles a lot of the
low-level work. Most of the time, you'll probably want to extend this class - it just
makes life easier.

Let's go! I'll close a few other files. Then, make our `BeGreaterMatcher`
extend `BasicMatcher`. I'm also going to mark the class as `final`. There's no reason
for that - it's just a general nice practice to mark a class as final unless you intend
for it to be sub-classed. Though, marking a class as final can cause issues if you
need to mock it. Either way - this is not important to get this all working.

[[[ code('2f7f9063a1') ]]]

Next, go to the `Code -> Generate` menu or Command+N on a Mac, select
"Implement Methods" and implement all *four* methods that we need.

[[[ code('bfa2f43bcf') ]]]

## Implementing supports()

The first important method is `supports()`. Let's `var_dump()` the arguments to see
what we're working with: `$name`, `$subject` and `$arguments`. Whenever *any* matcher
is used inside of a spec class, phpspec loops over *all* of the matcher classes and
calls `supports()` to figure out *which* one to use.

[[[ code('e9622fe71e') ]]]

Let's see what happens! Run phpspec:

```terminal-silent
./vendor/bin/phpspec run
```

Yep! It's dumping out *every* time any matcher is used - once for `haveType`, `returnZero`
and down here for `beGreaterThan`. That's the `$name` argument. The `$subject` is
`15` because, in our spec class, `getLength()` returns 15 and we're calling
the matcher on that value. Finally, `$arguments` is an `array` with just one entry:
12 - because we're passing 12 as the *one* argument to the `shouldBeGreaterThan()`
matcher.

The `supports()` method *really* only needs to check to make sure that the `$name`
is equal to `beGreaterThan`: that's enough to tell phpspec that *we* handle that.
But, a lot of times, these are written to be a bit more flexible. For example, you
could use `in_array()` to check that `$name` is one of `beGreater` or `beGreaterThan`.
Then, if you want, you can even make sure the *types* of the subject and arguments
are what we expect. We'll say that this matcher should only be used if
`is_numeric($subject)` and if `count($arguments)` is exactly one *and* if *that*
argument is also numeric *and* if it's Halloween after midnight. Kidding.

[[[ code('af8db0f12f') ]]]

## Implementing Matches

So, *when* `supports()` returns `true`, phpspec will *then* call the
`match()` function on top. Our job *here* is to return `true` if everything looks
good, or false otherwise - just like the inline matcher. Let's `var_dump` the
`$subject` and `$arguments` one more time with a `die` statement - to make sure it's
called like we expect.

[[[ code('18ad58f973') ]]]

Move over and try phpspec again:

```terminal-silent
./vendor/bin/phpspec run
```

Yes! We *are* called with 15 as the `$subject` and the same `$arguments` array with
12 inside. Because we know there will always be exactly *one* argument, we can finish
this method `return $subject > $arguments[0]`.

[[[ code('f9c2d30847') ]]]

## Implementing the Failure Exception Methods

Done! If the matcher returns false, phpspec will either call `getFailureException()`
or `getNegativeFailureException()` - the difference is if we're using
`shouldBeGreaterThan()` or `shouldNotBeGreaterThan()`. Our job there is to return
that same `FailureException` - I'll paste one in with a good message. This is the
same type of object that we're throwing from our inline matcher.

[[[ code('41bc80514a') ]]]

For the other method, copy this, paste, and just tweak the language a little bit.

[[[ code('021c2ea141') ]]]

We *now* have a fully-functional custom matcher that allows us to use this new, natural,
language inside of *any* spec file. Well... assuming it works - try it out:

```terminal-silent
./vendor/bin/phpspec run
```

All green! Next: it's time to talk about how phpspec fits into the entire world
of testing. For example, there are functional tests, integration tests, and unit
tests... and multiple tools like PHPUnit and Behat. Let's dive into this big mess
of tools and buzzwords.
