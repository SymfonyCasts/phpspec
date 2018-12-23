# Custom Inline Matcher

One of the *main* goals of a specification class is for it to communicate the
behavior of our class through as readable and natural language as possible. Before
functioning as a test, it's meant to be *documentation*.

To make it as *effective* as possible, both the names of the methods should be easy
to read as well as the code. For example, saying `$this->getLength()->shouldReturn(9)`
reads like a normal sentence.

But let's pretend for a minute that this language does *not* sound clear to us. In
that case, we can invent our *own* language. Let me show you: create a new example
function: `it_should_default_to_zero_length_using_custom_matcher()`.

Inside, let's show this same behavior, but in a different way - how about
`$this->getLength()->shouldReturnZero()`.

That's great language! But, as you probably noticed, PhpStorm did *not* auto-complete
this. That's because... I just made that language up! There is *no* built-in matcher
that allows us to say `shouldReturnZero()`.

Try it:

```terminal
./vendor/bin/phpspec run
```

Yep! No `returnZero` matcher found. But, if *this* is the language that is most natural
to us, we *can* make this work - just create our own matcher.

## Overriding getMatchers()

The simplest way to create a custom matcher is to add it right into your spec class.
At the top of your class... or really anywhere, go to the `Code -> Generate` menu -
or Command+N on a Mac - and override a method called `getMatchers()`. We don't need
to call the parent method because its empty.

This method is kinda beautiful: just return an array where they *keys* are the custom
matchers you want. Except, the *key* is *not* `shouldReturnZero()`. Nope, the name
of your matcher is that string *without* the "should" or "shouldNot" part. In other
words, add `returnZero` set to a function with one argument called `$subject`.

## The Matcher Subject

Here's how this works: in the example, we call `getLength()`, which we know returns
an integer - hopefully zero. But thanks to the magic of phpspec, we can call
`shouldReturnZero()` on this value. When we do that, phpspec will call our function
and pass the *length* returned from `getLength()` as the `$subject`. Complete
the matcher by saying `return $subject === 0`. Our matcher function should return
`true` if the `$subject` looks valid, `false` otherwise.

So... let's try this!

```terminal-silent
php vendor/bin/phpspec run
```

Yes! It passes. Oh, and we can automatically *also* say `shouldNotReturnZero()` if
we want - every matcher is able to handle both `should` and `shouldNot`.

## Better Error Message

To make sure the matcher is *really* working, in `Dinosaur`, add a bug by changing
the default length to 30. Now re-run phpspec:

```terminal-silent
php vendor/bin/phpspec run
```

Two examples fail - the one we're working on is the second one. Look at the error:

> integer:30 expected to `returnZero()`, but it is not.

Wow. That's... kinda bad language on that error. phpspec is *trying* its best to
tell us what went wrong in a way that makes sense... but it doesn't always work.

No problem - we can control that error. Let's refactor that code a bit: if
`$subject !== 0`, then, instead of returning false, throw a new
`FailureException()` with a better message:

> Returned value should be zero got "%s"

and pass `$subject` for the wildcard.

Then, at the bottom `return true` to signal that everything is fine. Try the
tests again:

```terminal-silent
php vendor/bin/phpspec run
```

Oh, *even* with my typo on the word "got", the error is *much* better. Let's go
fix that bug - change 30 back to zero - and re-run phpspec:

```terminal-silent
php vendor/bin/phpspec run
```

Nice! Oh, by the way, *sometimes* when you call a matcher, you pass it an argument...
and sometimes we don't. If we *did* pass an argument to the matcher function, it
would passed to our callback as the second argument. And if you pass two arguments
to the matcher, these become arguments two and three... and so on - you can make
the matcher as complex as you need.

As nice as creating an "inline" matcher like this is - it has one major downside:
our `returnZero` matcher can't be re-used in any other spec classes. Next: let's
create another custom matcher but make it able to be used in our entire app.
