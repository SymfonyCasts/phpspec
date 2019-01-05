# Custom Inline Matcher

One of the *main* goals of a spec class is for it to communicate the behavior of
our class through readable and natural language. More important than being a test,
this class is meant to be *documentation*. If the function names or code inside
the functions aren't naturally readable - you're at risk of angering the phpspec
gods!

For example, saying `$this->getLength()->shouldReturn(9)` *does* read like a normal,
English sentence. But let's pretend for a minute that this language does *not* sound
clear - maybe we're using a matcher that *works*, but just feels unnatural. In
that case, we can invent our *own* language. Check it out: create a new example
function: `it_should_default_to_zero_length_using_custom_matcher()`.

Inside, let's show this same behavior, but in a different way - how about
`$this->getLength()->shouldReturnZero()`.

That's great language! But, as you probably noticed, PhpStorm did *not* auto-complete
that matcher function. That's because... I just made that up! There is *no* built-in
matcher that allows us to say `shouldReturnZero()`.

To prove it, run spec!

```terminal
./vendor/bin/phpspec run
```

No `returnZero` matcher found. But, if this *is* the language that is most natural,
we *can* and *should* make it work. How? By creating our *own* matcher.

## Overriding getMatchers()

At the top of your class... or really anywhere, go to the `Code -> Generate` menu -
or Command+N on a Mac - and override a method called `getMatchers()`. We don't need
to call the parent method because its empty.

This method is... kinda beautiful: just return an array where they *keys* are the
custom matchers you want. Except, the *key* is *not* `shouldReturnZero()`. Nope,
the name of the matcher is that string *without* the "should" or "shouldNot" part.
In other words, add `returnZero` set to a function with one argument called `$subject`.

## The Matcher Subject

Here's how this works: in the example, we call `getLength()`, which we know returns
an integer - hopefully zero. But thanks to the magic of phpspec, we can call
`shouldReturnZero()` on this value. When we do that, phpspec will call our function
and pass the *length* returned from `getLength()` as the `$subject`. Complete
the matcher by saying `return $subject === 0`. Our matcher function should return
`true` if the `$subject` looks valid, `false` otherwise.

So... let's try this! Go spec go!

```terminal-silent
php vendor/bin/phpspec run
```

It passes! Oh, and we can automatically *also* use `shouldNotReturnZero()`: every
matcher is able to handle both `should` and `shouldNot`.

## Better Error Message

To make sure the matcher is *really* working, in `Dinosaur`, add a bug by changing
the default length to 30. Now re-run phpspec:

```terminal-silent
php vendor/bin/phpspec run
```

Two examples fail - we're working on the second example. Look at the error:

> integer:30 expected to `returnZero()`, but it is not.

Wow. That's... kinda bad language. phpspec is *trying* its best to tell us what went
wrong in a way that makes sense... but it doesn't always work.

No problem: we can control that error. Let's refactor that code a bit: if
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

Nice! Oh, by the way, *sometimes* when you call a matcher, you may need to pass it
an argument... and sometimes we don't. If we *did* pass an argument to the matcher
function, it would be passed to our callback as the second argument. And if you pass
two arguments to the matcher, these become arguments two and three... and so on - 
you can make the matcher as complex as you need.

Because the new matcher lives right inside the spec class, this is called an
"inline" matcher. And as *nice* as it is, it has one major downside: the `returnZero`
matcher can't be re-used in any other spec classes. So next: let's create another
custom matcher that can be used in our entire app.
