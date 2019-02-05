# Mocks & Spies - shouldBeCalledTimes()

Hey! We're experts when it comes to controlling the return value of any method
on a test double. Here, we told it that when `growVelociraptor()` is called
with any integer argument, return `$dino1` the first time and `$dino2` the second
time.

By doing this, we *also* added some *expectations* because, as soon as you control
the return value of *one* method call, then you must control the behavior of *all*
method calls. And so if a different method is called or different arguments are
passed to this method, the tests will fail.

But what this does *not* guarantee is that `growVelociraptor()` *was* actually
called... or how many times it was called. Nope, we're saying, *if* it's called,
it must be called with this argument... and here's what to return. But technically,
if it were called zero times, that would not cause this part to fail!

And that's what I want to talk about next: sometimes it *is* super important to
make sure a method *was* called... or was called exactly *three* times... or was
*not* called. For example, what if we *really* wanted to *absolutely* make sure
that `growVelociraptor()` was called exactly two times? We can do that, and it
starts the same way: `$dinosaurFactory->growVelociraptor(Argument:type('integer'))`.
Then, instead of `willReturn()`, use `shouldBeCalledTimes(2)`.

This feels familiar because it looks exactly like what we've been doing! It looks
like a matcher! It looks no different than `$this->shoudHaveType()`, for example.

Now that we're *asserting* that this method should be called twice, run phpspec:


```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

Nice! It *passes*! What does it look like to fail? Change this to 3... and try
it again:

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

Perfect: Expected exactly 3 calls that match `growVelociraptor()` with type integer,
but 2 were made.

## Re-Using the "Promise" for Stubbing & Mocking

Change this back to 2. But notice: there's some duplication here - we're repeating
the `$dinosaurFactory->growVelociraptor(Argument:type('integer'))` part when we
need to control the return value *and* when we want to assert how many times it
was called. We can totally remove that. Chain the `->shouldBeCalledTimes()` onto
the end of the first call.

Try it!

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

Nice! It's sort of a low-level detail, but when we call
`$dinosaur->growVelociraptor()`, that returns what's called a "method prophecy"
object... and we can then add "promises" to it - that's the `willReturn()` stuff -
or *predictions* - that's the `shouldBeCalledTimes()` stuff. What's interesting
is that if you call a method on a stub two times and pass it the *same* exact
`Arguments` stuff, prophecy will return you the *same* `MethodProphecy`. In other
words, if you called `willReturn()` multiple times, the second would override the
first.

If that doesn't totally make sense - forget about it - it's just some low-level
coolness I wanted to mention while we were here.

## Predicting After (Spies)

Anyways, when you want to add a "prediction"... basically, an expectation that
a method should be called an exact number of times, you can do it in *two* different
ways... and it's just a matter of style. First, you can do it like we've been doing:
call `->shouldBeCalledTimes()` and *then* actually execute the code.

*Or* you can put the assertion stuff *after* you run your code. Check this out:
remove the `->shouldBeCalledTimes()` line. Then, anywhere after we call
`buildEnclosure()`, start with `$dinosaurFactory->growVelociraptor(Argument::any())`
and then `->shouldHaveBeenCalledTimes(2)`.

This does the exact same thing... it's just a different style. Oh, and I used
`Arguments::any()` down here instead of `type()`, but not for any special reason:
I'm just showing how we can make sure that this method is called exactly 2 times,
regardless of the arguments.

Let's try this!

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

And we are green! Next, let's take a super-quick tour into the phpspec documentation
where we'll see all the special words like test doubles, dummies, mocks, and spies
used in the real world.
