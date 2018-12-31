# The ObjectBehavior Magic

The *hardest* part of phpspec for me was how *weird* these spec classes look. They're...
total and complete magic! You're supposed to pretend that the `$this` variable is
a `Dinosaur` object... even though we're not in that class. And also... I guess
that means that phpspec somehow instantiates a new `Dinosaur` object before it
runs each example? Then, *just* when you get used to the weirdness of treating
`$this` like a `Dinosaur` object and calling real methods on it... we suddenly
call a matcher method - like `shouldReturn(0)`.

## Digging into ObjectBehavior

Let's take a few minutes to demystify all this craziness, because it really helped
me get comfortable with phpspec. All of this magic is made possible by the base
`ObjectBehavior` class. Hold Command or Ctrl and click to open that.

Ah, ok: see that `protected $object` property? *That* is *actually* the underlying
`Dinosayr` object that we're testing. Well, that's not 100% true - but imagine
it is for a second. So, at some point, phpspec instantiates a `Dinosaur` object
and stores it on that property.

Pretty much *all* of the magic of this class is thanks to the `__call()` method.
If you're not familiar with this method, that's great! This is a magic PHP method
that you should probably *not* - but it's perfect for phpspec. If you call a
non-existent method on an object, but that class has an `__call()` method, instead
of throwing an error, PHP will execute `__call()` and pass it the method name and
arguments you were trying to use.

And what does `ObjectBehavior` do in this method? It basically takes the method
arguments and calls it one `$this->object`! *This* is why, when we say
`$this->getLength()`, it works! The `getLength()` method does not exist on
`ObjectBehavior`. But thanks to the `__call()` method, it *proxies* that call
over to our actual `Dinosaur` object. `ObjectBehavior` also has a few other methods,
like `__get()` and `__set()` to proxy setting properties and other stuff - if
you need that.

## The Wrapped Object

Let's actually see what some of this looks like in the wild. Close that class and,
in any of the examples, let's `var_dump($this)`. Ok, go run those tests!

```terminal-silent
php vendor/bin/phpspec run
```

Interesting... As expected, `$this` is really an instance of `DinosaurSpec`. But
check out the `$object` property. Yep... I lied! It is *not* an instance of
`Dinosaur`! Nope, it's some `Subject` object from phpspec. But inside of it
is something called a `WrapperObject` and inside if *it*, yep! There is the
`Dinosaur` object.

So, it's a bit more complex than we thought at first, but phpspec *did* create
a `Dinosaur` object and set it on that `object` property... but wrapped inside a
few other objects to help the magic.

For the most part, we pretend like we're interacting directly with a `Dinosaur`
object. But, if you *did* need to get the *actual*, underlying `Dinosaur` object,
that's possible! Try `$this->getWrappedObject()`, then run the test again:

```terminal-silent
php vendor/bin/phpspec run
```

Cool! *That* gives us the *real* Dinosaur object. And it's length is *really*
15, because when we call `$this->setLength(15)`, that eventually is called on the
real, underlying object.

Most of the time, you won't need to call `getWrappedObject()`, though there are
a few edge-case exceptions. Like, imagine if our `Dinosaur` class had a method
on it that started with `should`, like `shouldHandle()`. Well... that won't work.
*We* know that phpspec thinks that when we call anything starting with `should`
or `shouldNot`, this is not a method on the object, but a *matcher*. Check it out:

```terminal-silent
php vendor/bin/phpspec run
```

There it is: "no handle matcher found". For this edge-case, you can use
`$this->callOnWrappedObject()` with `shouldHandle` and an array of arguments you
want. Try it now:

```terminal-silent
php vendor/bin/phpspec run
```

Nice! It fails... but with the *correct* failure: it sees that there is no
`shouldHandle()` method and asks us to generate it. Choose no - we're just playing
around.

Next: there's one more piece of magic we haven't talked about: when we call
`$this->getLength()`, that should return 15. So, how are we able to call a method
on that?