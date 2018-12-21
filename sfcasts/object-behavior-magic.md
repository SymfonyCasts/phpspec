# Object Behavior Magic

Coming soon...

What's the weirdest things for me when I started using phpspec was just the way that
these spec classes look. Basically, there's super magic. You have this, this variable
which you're supposed to think of as the `Dinosaur` object, which means that before
each example peach back actually instantiates a `Dinosaur` object for us, but then you
can either call a match or on it or you can actually start calling her real methods
on it. So I'm gonna. Take a second in demystify that. Let's actually just open up the
code that makes us possible because for me, it makes everything a lot more clear.
This is all made possible by this base `ObjectBehavior` class. I'm going to hold
command or control and click to open that. All right, so the key thing here is that
you can see this `protected $object` that is actually more or less our underlying object
that we're testing. So in our case, this is the `Dinosaur` object,

okay?

And if you look at this `ObjectBehavior` class,

it has a really important thing. Here is this `__call()` method. You can see
that this is the magic method and PHP that if you call a method that doesn't exist on
this class, then `__call()` is used and what does it do? It basically takes
that method and the arguments in calls it on `$this->object`. This is why when we say
`$this->getLength()`, `getLength()` does not exist on `ObjectBehavior`, but thanks to
the `__call()`. It does proxy it over to our actual `Dinosaur` object has also as
and also as magic set and magic get methods. All right, so let's dive in a little bit
further and see this in real life. So I'm going to close that. And in any of your
test, let's actually `var_dump($this)`. I'll go over run our tests and. 

```terminal-silent
php vendor/bin/phpspec run
```

Perfect. Let's
check this out. Okay, awesome. As expected, this is really an instance of dinosaur
spec and here's that object property and actually I lied a little bit because object
property is not an instance of `Dinosaur`. You can see this as not a dinosaur object is
actually several layers of wrapping. This is inside. Somebody called a subject from
phpspec. Inside of it is something called a wrapped object and inside of it

is actually our `Dinosaur` object, so there is an instance of our dentists or object in
there somewhere, phpspec. It did create it and it just wraps it in a couple of
objects to give us that fence behavior. If you need to get the underlying object,
which is not too common, but just to show it, you can say `$this->getWrappedObject()` and
there is our actual dentists or object and you can see that this link is really 15
because when we call set link, that eventually is called on the underlying object.

Now, most of the time when you won't need to `getWrappedObject()`, you're just going to
call them methods directly on this and we know behind the scenes that will get passed
to our `Dinosaur` object. There are a couple of exceptions to that. For example, we had
a method on our `Dinosaur` object called `shouldHandle()` and we wanted to pass it and
argument `2`. Well, of course we know that peace, respect thinks that anything
that starts with the word should is actually a matcher. So when we run this, 

```terminal-silent
php vendor/bin/phpspec run
```

it actually says matcher not found for handle. Well, that's not actually a matcher.
That's actually a method we want to call them there. So for these edge cases, there
are ways to get around it. You can say, you can say, `$this->callOnWrappedObject()`
`shouldHandle` and then pass it the `array` of arguments that you want. Now when you run
it, 

```terminal-silent
php vendor/bin/phpspec run
```

of course that's going to fail because there's no shit handle method. It even
asks if you want to generate it will say `no`, you can see how that works. Another
thing is that not only is this magic, but this `getLength()` is magic, right? Because we
know that we really call it the get lengthened on dinosaur that returns 15, but we
can actually chain methods off of it. So that's `var_dump($this->getLength())`.run that. 

```terminal-silent
php vendor/bin/phpspec run
```

This is actually an instance of a `Subject` object
which is a lot like, which is actually the same object that was on. It's actually the
same type of object that is set on the `$object` property of our `ObjectBehavior` and
again, it's just another rappers that we can call magic on it. So let's go down here.
I'm actually going to type shift, shift and look for a class called Subject file
called `Subject.php`. Above this, it has a bunch of documentation for methods that you
can call on it. You can see all the should methods.

Ultimately, this is similar to the `ObjectBehavior` because if you scroll down far
enough, you're eventually going to find an `__call()` method. So when we call
this aero kit length and then we call another method on it. That's actually going to
go into the `__call()` and it's very simple. If it starts with should it calls
a method that treats this as an expectation, so finds a match or for it. If it starts
with `beConstructedThrough` or be constructed, we're going to see that in a bit.
That's ways for you to control how an object has constructed. It does something else
and ultimately if it's not one of those special cases, it actually caused some code
down here, which this might not be entirely clear, but this extra says, okay, try to
call the method on whatever the value is. So in this case it's just the value 15, but
if get linked return an object, we could actually call another method on that object.

So this is the way that we're able to pretend like this is actually the `Dinosaur`
object and this gate length is actually the number of 15, but behind the scenes still
be able to call our matches on it and get the behavior that we want. So it is magic,
but it's magic that's just done with a couple of rappers and the `__call()`
method to make everything work really nicely. All right, let's remove our debug code,
making sure our tests are still passing. 

```terminal-silent
php vendor/bin/phpspec run
```

Awesome. Alright, let's move on and actually get back to some testing.