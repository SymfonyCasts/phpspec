# Advanced Argument Matching

The `growVelociraptor()` method is called two times. And thanks to the two arguments
to `willReturn()`, `$dino1` will be returned first, then `$dino2`. But we can control
this *much* more than we are now.

Check it out: copy the beginning of the promise and paste it below. Replace the
argument with 5. Then say `-willReturn($dino2)`. For the first promise, remove `$dino2`:
this will now return `$dino1` *every* time its matched.

So... what the heck is going to happen now? Down here, I'm saying that when
`growVelociraptor()` is called with exactly the number `5` argument, return `$dino2`.
But up here I'm saying: if `growVelociraptor()` is called with *any* `integer`
argument, return `$dino1`. So... when `growVelociraptor()` is called with the
number 5, what's going to be returned? `$dino1` or `$dino2`? Does the order of
these matter? Or something else?

I don't know! Let's find out. Try phpspec:

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

It fails: expected `Dinosaur` but got `Dinosaur`. Wow... umm... that's not very
helpful. Re-run it with `-v`:

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19 -v
```

Ah! Now we can see that, on line 38, so when we're checking the first dinosaur,
we expect it to be our big Stegosaurus, but it was actually our `Baby Stegosaurus`.

## Arguments Matching is by "Most Specific"

This is really cool! Each time we call `growVelociraptor()`, it looks *all* of these
promises, or method expectations, and finds the most *specific* one. When the argument
is 5, it matches *both* promises: it *is* 5, but it's also an inteer. But because
the second is more specific, *that* promise is used and it returns `$dino2`.

So, the *first* time we go through the loop, 5 is the argument and we return `$dino2`.
The second time, the argument is 6 and *only* matches the first promise. So,
`$dino1` is returned.

This means that `$dino2` is now the first item and `$dino1` is the second. How
*cool* is that! That's full, beautiful control. Let's take off the `-v` option
and run the tests:

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

Got it! To prove how this works, we can even re-order the two promises. Yep, this
will work exactly the same:

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

So, whenever a method is called on a stub, prophecy will look at all the promises
for that method and find the best one. And if *none* are found... but at least one
exists, error!

Ok, let's change this back to just one promise - we don't really need to be this
specific. Delete the more specific call and make it return `$dino1` and then `$dino2`
just like before. Also update the asserts to go back to the original way. Double-check
that phpspec is happy:

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

Woohoo! Arguments are a *great* way for you to very specifically control what values
are returned based on the *input*. *And* to make sure your methods are being called
with the arguments you expect.

Next: instead of controlling the return value of methods, let's talk about adding
*expectations* to our test doubles - like making sure that a method was called
an *exact* number of times. Yep, it's mocks and spies time!
