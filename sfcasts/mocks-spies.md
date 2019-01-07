# Mocks Spies

Coming soon...

So far, we've added a behavior to our testable. We have told it exactly how to behave
when `growVelociraptor` is called with any argument in any integer argument. We've
also added a little bit of expectation also because as soon as you start adding
behavior, as soon as you control the return value of one method call, then you must
control the behavior of all method calls and if there's a different method or a
different argument that's passed to one of your methods, then it's actually going to
fail. So this is the main reason. Main thing that you do with test devil's as you add
this behavior, but the behavior has also been a built in expectation that indeed we
are called with the correct arguments, but there's another way that you can directly
add expectations. So sometimes you want to add behavior to your test doubles, but
sometimes you want to add expectations. What I mean by that is if it's important
enough to us, we might want to test that. `growVelociraptor()` is called exactly two
times. It might be very critical for us to do this. Maybe we don't care, but we could
do that. We have to do it is we started the same way we said 
`$dinosaurFactory->growVelociraptor(Argument:type('integer'))`

and this feels very, very similar to how we work with phpspec in general. We
call should like, `shouldBeCalledTimes(2)`. Yeah. This is very, very familiar
because we're used to with phpspec using objects and calling. It should methods on
them. Now I wouldn't say should be called two times. That becomes an expectation. We
can run our task 

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

and it passes. What does it look like to fail? I'll change it to three and 

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

it fails expected exactly 3 calls matching the integer. There was two,
but that had an integer a. But that was it. So we'll change this back to 2. Now,
one of the interesting things is that you notice there's some duplication here. Um,
and actually we can totally remove that. What we're really doing is where we can
actually change this onto the end if we want to. Now we're doing this, we're both
adding behavior and we're adding x an expectation that it should be called two times
to run that. 

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

That works just fine. So when you add an expectation to your

dummy object, you can do it in two different ways. So you can, um, add it before the
code. So here we're actually saying that it should be called two times and then we
actually execute the code. That should call that two times. We can also do this after
the test if you want to. And it's entirely up to you. It's just a matter of style. So
I'm going to remove this and down here at the bottom. So anywhere after we actually
call `buildEnclosure()`, I'm going to say `$dinosaurFactory->growVelociraptor(Argument::any())`
 because I'm going to say I want
grove alas rafter read to be called with any arguments. I don't care. The next day
`shouldHaveBeenCalledTimes(2)`. This does the exact same thing, just with slightly
different language. And in the, we do an afterwards, sometimes it feels better than
people because um, it's where the rest of our asserts go. It's not fair on this. 

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

It passes, that's it. We can add a behavior to our arguments to our test doubles or we
can add expectations and we can do that either before the test or we can do that
after the test. And now that we've seen all the things you can do with a testable, we
need to talk about some language so you can actually understand the phpspec
documentation. Google for php prophecy. Because remember this whole test double
system in phpspec is actually a system under the hood called Prophecy.

And in their documentation, they actually talk about four different types of objects,
dummy objects, stub objects, mock objects in spite objects in. Honestly, for me, it
was a bit confusing at first. So first they talk about dummies. What I want you to
know about these four different words is that they're all describing our test doubles
the things that we just did. They're describing the different things you can do to
it. So a dummy object is something that you get if you add a type hint to your
argument, but then do nothing with it. So if we never added any behavior and we never
added any assertions, then it's actually known as a dummy object. Now, in that inside
the documentation, you'll see things called like `$prophecy->reveal()`. That's a
detail we don't need to worry about because we're working with phpspec. It
takes care of that for us. So dummy object is just an object that does nothing. Now
as soon as you start controlling it's returned values of even one of its methods,
then it suddenly is known as a stub. You can see you're a stub is an object double.
So that's another reason it. All of these things are called

hmm,

object doubles, Geez. And you're saying when to put in a specific environment and
behaves in a specific way. It's a fancy way of saying as soon as we add one of these
`willReturn()` things, that it becomes a stop. And actually most of the documentation is
talking about the stops because it talks about lots of different ways for you to
control exactly how they behave and you winning the argument, wild carding that we
saw earlier, like `Argument::any()`, so on and so forth and `Argument::cetera()`. Now, if you
go on here and keep going, the next thing I hear about mocks, and that is when you
call these `shouldBeCalled()`. So if you actually want to add an expectation and you
add the expectation before using `shouldBeCalledTimes()`, `shouldBeCalled()`, that's
known as a mock. So before we were using a muck. And then finally down here you're
going to see the word spy. Spy is the exact same thing as a mock, except it's when
you do the ad, the expectation after the code. So you end up with this, a lot of big
language here, you end up with the whole system. All these things are called test
doubles. A testable with no behaviors called a dummy.

If you change, if you start controlling its behavior with `willReturn()`, it becomes a
stub. If you add an expectation to it before the code, it's called a mock, and
finally if you had an expectation after it, it's called a spy. I find these terms fun
but entirely confusing and I don't actually think about these terms when I'm using my
code. I just think about the ability of adding behavior and adding expectations, but
when you're looking at their documentation, if you kind of are familiar with what
these words mean, then you'll understand them and these are not words that phpspec
spec invented. These are words that are just words in general that are used inside
the testing world, so they're kind of nice to know. Anyways, next, let's talk about a
helper method that we can use inside of our specifications class to run some code
before every single example. In our SPEC class.