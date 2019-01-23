# The Magic of the Subject

We *now* know that the `ObjectBehavior` class forwards all method calls to the
underlying `Dinosaur` object thanks to some magic methods. But, there is still one
more big piece of magic. When we call `$this->getLength()`, phpspec will ultimately
call `getLength()` on the `Dinosaur` object and *that* will return the integer 15.
So then... what absolute madness is allowing us to call a method on that?!
Let's find out!

This time `var_dump($this->getLength())`. 

[[[ code('067c4ad1af') ]]]

Will this be the integer 15? An object? An emoji? Let's find out!

```terminal-silent
./vendor/bin/phpspec run
```

Ah! It's an instance of a `Subject` object. Stop! We *know* that object! That
is the *exact* same class type that is stored on the `$object` property of our
base `ObjectBehavior` class! Just like before, `Subject` is a wrapper object that
gives us some magic. Let's find out how it works: type Shift+Shift and look for the
`Subject.php` file.

Woh! See all these `@method` things on top? This tells PhpStorm that we can call
any of these methods on this object and they will work. We need this because, if
you look, these methods don't actually exist in this class! They work by magic -
we'll see that in a minute.

This class works a lot like `ObjectBehavior`. Scroll down until you find the
all-important `__call()` method. When we call `getLength()`, it gives us a `Subject`
object. And *then* when we call `shouldBeGreaterThan()`, it's handled by `__call()`.
The logic here is awesome: if the method name starts with `should`, it calls
`$this->callExpectation()` - which finds and executes the correct "matcher". So,
why do all matchers need to begin with `should`? Because of this line right here.

Next, if the method name starts with `beConstructedThrough` or `beConstructedWith`,
it calls some code that allows us to *control* how the `Dinosaur` object is
instantiated. We'll use this really soon.

And *ultimately*, if it is *not* one of those special cases, it executes code
that *forwards* the call onto the underlying object and returns that value. Well,
it returns the value wrapped in, yet another, `Subject` class. This is *exactly*
what happens when we call `$this->getLength()`: this last line calls `getLength()`
on the `Dinosaur` object and then wraps it in a `Subject` object. Thanks to that,
we can *then* call `shouldBeGreaterThan` to call our matcher.

So, yes, it *is* all magic - super impressive magic! But it's magic that's done
via a couple of wrapper object and the `__call()` method.

Let's remove our debug code, and make sure the tests are still passing:

```terminal-silent
./vendor/bin/phpspec run
```

Cool! Now, back to testing! Next: let's learn how to "describe" a special part of
our object's behavior: how it's instantiated.
