# Arguments

Coming soon...

In our specification, we said that when we call,

okay,

`buildEnclosure()`, we expect the `growVelociratptor()` be calling a `DinosaurFactory` with
the exact argument `5`. That's just how we decided that we want our `DinosaurFactory`
to work and one is called with `5` we'd sat and we're going to return `$dino1` the first
time in `$dino2` the second time that it's called. So what if we had a different situation?
Let's breathe. Let's go into our service. Let's pretend that we wanted to make this a
bit more dynamic. It's going to be `5 + $i`, so five, then six and seven and
eight. So what's going to happen here? Because we've said that we want grow. We're
using five still in our specification.

Okay,

whoever.

Yeah,

it'll run our SPEC. 

```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

It fails. Check this out. It says that unexpected method call on
`DinosaurFactory`, golden `growVelociraptor(6)`. Expected was `growVelociraptor(5)`
so it actually causes a failure. This is a really important thing. It's
when you call, `willReturn()`. This is called a promise. You're actually making a
promise that the `growVelociraptor()` method will return.

Wow.

This `$dino1` value and then this `$dino2` value. As soon as you apply one promise
to one method on a, on a dummy object, you must apply promises to every single call.
So in other words, if we call `growVelociraptor()` with anything other than an argument
of five, it's actually going to fail. So how do we fix this? Well, the answer is
there's tons of different ways to fix this depending on your situation. The easiest
one is to use a special `Argument` class from prophecy and pass it `any()` if you move or
run out and run it. 

```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

It works. This says when `growVelociraptor()` is called with any
argument, then returned at one and then returned banner to and so now every single
time we called `growVelociraptor()`, it matches this statement. So there are a number of
other things you can do. Any is the easiest. If you really don't care, then you can
use any. By the way, if you had a second argument to `growVelociraptor()`, you would
just pass, for example, another argument like this, or

you could even do if you had many arguments, you could say `cetera()`, that would match
second, third, fourth, all the rest of the arguments anyways. If you want to be
little bit more specific, we can use one called `type()`, so for example, we can say 
`type('integer')`, so now any, anytime that `growVelociraptor()` is called and the argument is an
Integer, it will match this statement and it will return these values.

So if we run that, 

```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

no surprise, that works as well, but if we change this to `string`
and run it as 

```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

we get unexpected method, call five. We expect that a string. So when
you pass it with five here, it doesn't match any of our method calls and this becomes
an unexpected call. It says, Hey, somebody is calling `growVelociraptor()` a method
call with an argument that you didn't expect. The most flexible one of these is
called `that()`. I won't show an example, but you actually pass us a `callback` and then
you can do whatever custom check you need to do to make sure that the actual argument
passed to you is something that you expected.

Yeah,

so let's change this back to `type('integer')` and here's where things get really
interesting. We know that `growVelociraptor()` is going to be called two times, and so
we can actually set up two separate promises for this. Check this out. I'm going to
copy the beginning of this below here. I'm going to call `growVeloviraptor()` again within
number five and say we'll return and pass it `$dino2`. Tune up here. I'm just gonna. Pass
them `$dino1`. Now let's think about what this means. What I'm saying is when 
`growVelociraptor()` is called with exactly the number `5` argument returned `$dino2`
appear. I'm saying if grove after is called with any `integer` argument, I want to
return `$dino1`. You might be wondering, okay, so when we actually called 
`growVelociraptor()` with the number 5, is it going to return `$dino1` is they're going
to return `$dino2` does the order matter, like how does this work? Well, let's find
out if we run it, 

```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

it fails. Expected `Dinosaur` but got `Dinosaur` that's not very
helpful. So let's run it with `-v`. Ah,

```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19 -v
```

now you can see that online. Thirty eight. So on the first dinosaur we're checking it
expect we expected it to be our big stegosaurus, but it was actually our babies
stegosaurus. So this is really cool. Whenever we call `growVelociraptor()`, it looks at,
at all of these different method expectations and finds the most specific one. So for
the case of five at see's this five here at cs, that five is also an integer, but
because this is more specific than just saying `any('integer')`, it matches this second
promise and it returns `$dino2`. So the first time we go through the loop here, five
is the argument and we returned to the second time. Six has past 60 is not the same
as five, but it does match the second promise. So returns `$dino1`. In other words,
`$dino2` is now the first item in `$dino1` is now the second item, so run that
again. I'll take the `-v` off 

```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

and this time it passes. It's a little bit hard to
wrap your mind around to prove it. We can actually reorder these two promises and
it's going to work exactly the same. 

```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

The order doesn't matter. Is that every single
time and method is called. It's going to try to find one of these method prophecies.
It's going to find the correct one to find and then return that value.

All right, so let's change this back to one. We don't really need to be this
specific, so I'm going to change this back through just one in integer return `$dino1`
the first time or returning `$dino2` the second time and we'll update our asserts
back to the original value down here. 

```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

Perfect. So arguments are a great way for you
to very specifically control what values or return based on the input and also to
make sure that your methods are being called with the exact right arguments. All
right, next let's start talking about not adding behavior, but about adding
expectations to our dummy objects. For our test doubles.