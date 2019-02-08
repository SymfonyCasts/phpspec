# Promises (control return values) & Arguments

In our spec, we said that, when we call `buildEnclosure()`, we expect *it* to
call `growVelociraptor()` on `DinosaurFactory` and pass it the exact argument `5`.
There was no super cool or secret reason for that: it's just how we decided to
make this method work: all dinosaurs would have this same length. And when it
calls `growVelociraptor()` with an argument of 5, we said that it should return
`$dino1` the first time it's called and `$dino2` the second time.

## Calling a Stubbed Method with a Different Argument

But... what if it weren't that simple? Go into the service. Making *every* dinosaur
the same size isn't very realistic. No, let's make it more interesting - let's
make the length `5 + $i`. So 5, then 6, 7 and so on.

What will phpspec think of this? Our example *still* says that we expect this method
to *always* be called with the argument 5. Well... let's find out!

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

It fails! And check this out! It says:

> Unexpected method call on `DinosaurFactory`, `growVelociraptor(6)`. Expected
> was `growVelociraptor(5)`

The *way* this fails is the *really* important part. When you call `willReturn()`,
this is called a method *promise*. You're making a *promise* that the `growVelociraptor()`
method will return this `$dino1` value and then this `$dino2` value. As soon as you
apply even *one* promise to *one* method on a dummy object, you must apply a promise
to *every* single call.

This can be a little tricky to understand at first. When we say
`$dinosaurFactory->growVelociprator(5)->willReturn()`, we're *really* saying:

> Hey phpspec! When `growVelociraptor()` is called and passed *5* as an argument,
> you should return `$dino1` and `$dino2`. If any other value is passed, this
> promise doesn't apply.

So, when `growVelociraptor()` is called with 6 as an argument, it looks at this
promise and determines it doesn't apply. *But*, once you define even *one* promise,
you *must* define a promise... basically, you must tell phpspec what to do for
*every* method call and *every* possible argument.

In other words, the *simplest* way to fix this would be to add a promise for
*every* argument that we'll pass - like `$dinosaurFactory->growVelociraptor(6)->willReturn()`,
then 7, 8, 9 - however many you need for that example. Whenever `growVelociraptor()`
is called, prophecy goes down *all* of the promises for that method and finds the
*one* that fits best. If none are found... but at least one is specified... error!

## Argument::any()

Of course... creating a promise for *every* possible argument  is... a bit nuts.
So what's the *real* fix? Remove the specific argument 5 and replace it with a
special `Argument` class from prophecy and pass it `any()`. Try phpspec again:

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

We're back! *This* says:

> Yo phpspec! It's me again, Ryan. So, when `growVelociraptor()` is called with
> *any* argument, here's what you should return.

Thanks to this, *every* time we call `growVelociraptor()` - *regardless* of the
arguments passed to it - this promise will be matched.

## Other ways to Specify Arguments

Oh, and if we were passing `growVelociraptor()` *two* arguments, then we *would*
need to also pass two arguments here. If you don't care, just use `Argument::any()`.
Or, if you had a third argument and wanted this promise to be used no matter what
values were passed, you can use `cetera()`.

But sometimes, I want to be a *bit* more specific. For example, we don't *really*
want `growVelociraptor()` to be called with *any* argument: it should be an
integer at least! If you *really* want to make sure that's happening correctly, you
can use `Argument::type()` and pass `integer`.

This should work for us... so let's try it!

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

All green! But *now* change this to `string`. Try it again:

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

Yes! Unexpected method call on `growVelociraptor(5)`. When the integer 5 is passed,
phpspec says:

> Hey, somebody is calling `growVelociraptor()` with an argument that doesn't
> match any of the promises for this method. That's probably not expected, so
> I'm gonna go ahead and explode. Cheers!

The most flexible `Argument` is called `that()`. I won't show an example, but
`Argument::that()` allows you to pass a callback function. *It* passes your callback
the argument and then you can do whatever logic you need to determine if this is
something you're expecting or not.

Let's change this back to `type('integer')`. And *here* is where things get *truly*
interesting. We know that `growVelociraptor()` is going to be called two times.
And so, to take *super* crazy control of things, we can create two *separate*
method promises to handle each one. If you don't fully understand how this
`Argument` stuff works yet, you will next.
