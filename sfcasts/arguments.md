# Promises (controller return values) & Arguments

In our specification, we said that when we call `buildEnclosure()`, we expect that
code to call `growVelociraptor()` on `DinosaurFactory` and pass it the the exact
argument `5`. There was no super cool or secret reason for that: it's just how we
decided we wanted this method to work - all dinosaurs would have this same length.
And when it calls `growVelociraptor()` with an argument of 5, we decided it should
return `$dino1` the first time it's called and `$dino2` the second time.

## Calling a Stubbed Method with a Different Argument

But what if it weren't that simple? Go into the service. Making *every* dinosaur
the same size isn't very realistic. No, let's make it more interesting - let's
make the length `5 + $i`. So 5, then 6, 7 and so on.

What will phpspec think of this? Our example still says that we expect this method
to always be called with the argument 5. Well... let's find out!

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

It fails and check this out! It says:

> Unexpected method call on `DinosaurFactory`, `growVelociraptor(6)`. Expected
> was `growVelociraptor(5)`

The *way* this fails is really important. When you call `willReturn()`, this is
called a *promise*. You're making a *promise* that the `growVelociraptor()` method
will return this `$dino1` value and then this `$dino2` value. As soon as you apply
*one* promise to *one* method on a dummy object, you must apply a promise to *every*
single call.

Let me say this a different way, it can be a bit tricky to understand at first.
When we say `$dinosaur->growVelociprator(5)->willReturn()`, we're saying:

> Hey phpspec! When `growVelociraptor()` is called and pass 5 as an argument,
> you should return `$dino1` and `$dino2`. If any other value is passed, this
> promise doesn't apply.

So, when `growVelociraptor()` is called with 6 as an argument, it looks at this
promise and determines it doesn't apply. *But*, once you define even *one* promise,
you *must* define a promise... basically, you must tell phpspec what to do for
*every* method call and *every* possible argument.

In other words, the *simplest* way to fix this is would be to add a promise for
*every* possible argument - like `$dinosaur->growVelociraptor(6)->willReturn()`,
then 7, 8, 9, etc. Whenever `growVelociraptor()` is called, prophecy goes down
*all* of the promises for that method and finds the *one* that fits best. If none
are found... but at least one is specified... error!

## Argument::any()

Of course... creating a promise for *every* possible arguments is... a bit nuts.
So what's the *real* fix? Remove the specific argument 5 and replace it with a
special `Argument` class from prophecy and pass it `any()`. Ok, try phpspec again:

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

We're back! *This* says:

> Yo phpspec! It's me again, Ryan. So, when `growVelociraptor()` is called with
> *any* argument, then here's what you should return.

Thanks to this, *every* time we call `growVelociraptor()`, this promise will be
matched. So, there are *two* purposes of the argument value you pass here. First,
it can help you return different values if the method is called multiple times
with different arguments - we'll see an example soon. And second, it can be used
to *assert* that your method is being called *only* with arguments that you expect.
For example, when we were using 5, an error was thrown when suddenly the method
was called with the argument 6.

## Other ways to Specify Arguments

Anyways, back to this arguments stuff! If we were passing `growVelociraptor()`
*two* arguments, then we *would* need to also pass something here. If you don't
care just use `Arguments::any()`. Or, if you had a third argument and wanted this
promise to be used no matter what values are passed, you can use `cetera()`.

But sometimes, you want to be a bit more specific. For example, we don't *really*
want `growVelociraptor()` to be called with *any* argument - it should be an
integer! If you *really* want to make sure that's happening correctly, you can
use `Arguments::type()` and pass it `integer`.

This should work for us... - so let's try it!

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

All green! But *now* change this to `string`. Try it again:

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

Yes! Unexpected method call on `growVelociraptor(5)`. When the integer 5 is passed,
it doesn't match *any* of the promises for this method call. It says:

> Hey, somebody is calling `growVelociraptor()` with an argument that doesn't
> match any of the promises for this method. That's probably not expected, so
> I'm gonna blow up.

The most flexible argument is called `that()`. I won't show an example, but
`Arguments::that()` allows you to pass a custom callback. *It* passes your callback
the argument and you can do whatever logic you want to determine if this is something
you're expecting or not.

Let's change this back to `type('integer')`. And *here* is where things get *truly*
interesting. We know that `growVelociraptor()` is going to be called two times.
And so we can set up *two* separate promises for this to take *full* control over
what's going on. Let's do that next.
