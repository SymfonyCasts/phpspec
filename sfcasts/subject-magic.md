# The Magic of the Subject

So we *now* understand that the `ObjectBehavior` class forwards all method
calls to the underlying `Dinosaur` object thanks to some magic methods. But, there's
another big piece of magic. When know that when we call `$this->getLength()`, phpspec
will ultimately call `getLength()` on the `Dinosaur` object and *that* will return
the integer 15. But then... how the heck are we allowed to chain this method off
of it? Let's find out!

This time `var_dump($this->getLength())`. Will this be the integer 15? Something
else? Let's find out!

```terminal-silent
php vendor/bin/phpspec run
```

Cool! It's an instance of a `Subject` object. Stop! We *know* that object! That
is the *exact* same class type that is stored on the `$object` property of our
base `ObjectBehavior` class! Just like then, it's a wrapper object that gives us
some magic. Let's see how this works: type Shift+Shift and look for the
`Subject.php` file.

Woh! See all these `@method` things on top? This tells PhpStorm that we can call
any of these methods on this object and they will work. We need this because, if
you look, these methods don't actually exist! They work by magic - we'll see that.

Ultimately, this class works a lot like `ObjectBehavior`. Scroll down until you
find the all-important `__call()` method. When we call `getLength()`, it gives
us a `Subject` object. And *then* when we call `shouldBeGreaterThan()`, it's
handled by `__call()`. The logic here is awesome: if the method name starts with
`should()`, it calls `$this->callExpectation()` - which finds and executes the
correct "matcher". So, why do all matchers need to begin with `should`? Because
of this line right here.

Next, if the method name starts with `beConstructedThrough` or `beConstructedWith`,
it calls some code that allows us to *control* how the `Dinosaur` object is
instantiated. We'll see that really soon.

And *ultimately*, if it is *not* one of those special cases, it executes some code
that forwards the call into the underlying value and returns its value. Well, it
returns the value wrapped in a `Subject` class. This is *exactly* what happens
when we call `$this->getLength()`: this last line calls `getLength()` on the
`Dinosaur` object and then wraps it in a `Subject` object. Thanks to that, we
can *then* call `shouldBeGreaterThan` to call our matcher.

So, yes, it *is* all magic, but it's magic that's done via a couple of wrapper
object and the `__call()` method, which forwards method calls.

Let's remove our debug code, and make sure the tests are still passing:

```terminal-silent
php vendor/bin/phpspec run
```

Cool! Now, back to testing! Next: let's learn how to "describe" a special part of
our object's behavior: how it's instantiated.
