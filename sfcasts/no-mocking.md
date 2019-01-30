# Object Dependencies: To Mock, or Not?

Until now, our examples haven't really needed to involve *other* objects. For example,
in `DinosaurSpec`, when we call `setLength()`, we pass a *scalar* argument. We haven't
had a situation yet where the object that we're describing *depends* on another
object. That's something that we need to talk a lot more about.

## Pending & Skipped Examples

But first, in `DinosaurFactory`, we have this `growVelociraptor()` method. Eventually
we're going to add other methods to grow other things. And just to make sure I
don't forget to do that, let's create a new `it_grows_a_triceratops()` example. But
I'm *not* actually ready to describe this or implement it yet... I don't know....
maybe there's a big storm coming and I need to get off the island on the last boat
or something. So, just leave it blank and run phpspec:

[[[ code('f994b3b1ad') ]]]

```terminal-silent
./vendor/bin/phpspec run
```

Cool! It shows up as a "todo" pending example! Once we come back after the storm,
we won't forget!

One other thing you can do, which is a bit less common in apps, but still neat,
is to skip tests if you're missing some sort of dependency. For example, create 
`it_grows_a_small_velociraptor()`.

Let's pretend like we need an outside library that contains a class called `Nanny`
in order to create baby velociraptors. If that class doesn't exist, we can throw
a `new SkippingException` that says:

> Someone needs to look over dino puppies

[[[ code('0c259bdcb2') ]]]

So, no `Nanny` class? Skip the example. If we *do* have it, it will run like
normal: `$this->growVelociraptor(1)` and, how about,
`->shouldBeAnInstanceOf(Dinosaur::class)`.

[[[ code('87e9a47bec') ]]]

Since that's just a made-up class, when we run phpspec:

```terminal-silent
./vendor/bin/phpspec run
```

Yep! That one got skipped.

## Describing the Enclosure

Ok: now that we have so many Dinosaurs, we should *probably* start thinking about,
ya know, keeping them enclosed in some way: right now they're just wandering around
the island and causing all kinds of trouble. I think we need a new `Enclosure` class
that we can put the dinosaurs inside of. Oh, oh, oh! That means... it's time to
*describe* a new class! Woo!

```terminal
./vendor/bin/phpspec describe App/Entity/Enclosure
```

The idea is that, as we create & persist dinosaurs to the database, we will also
create & persist Enclosures and put Dinosaur objects inside of them. Before even
running this spec class, let's add our first *real* example to make sure that each
Enclosure is empty by default - it would be a bit surprising if a new Enclosure
automatically had a dinosaur hiding inside: `it_should_have_no_dinosaurs_by_default()`.

And, because we will probably need a way to ask what dinosaurs are inside, let's
say: `$this->getDinosaurs()->shoudHaveCount(0)`.

[[[ code('136b27f8bb') ]]]

Ok, good start! Head back over to your terminal and run things:

```terminal
./vendor/bin/phpspec run
```

Enter `yes` to generate that class, and yes to generate the `getDinosaurs()`
method inside of it.

Thanks to that, not *only* do we have the new `Enclosure` class, but it already
has its first method!

[[[ code('f55b61981c') ]]]

## Basic Enclosure Implementation

To get started, we probably need a `$dinosaurs` property, which will hold an array
of `Dinosaur` objects. Add an array return type to the method and return
`$this->dinosaurs`. Oh, and let's initialize the property to an empty array - that's
exactly the behavior we're describing.

[[[ code('6ddd4f2266') ]]]

We *could* have just returned a hardcoded empty array... because that *is* the minimum
code we need to get the test to pass. But as you get more comfortable with phpspec,
it's ok to start skipping that step - as long as you stay focused on the behavior
you need and don't allow yourself to get too fancy.

Let's make sure things are passing:

```terminal-silent
./vendor/bin/phpspec run
```

Perfect! Just the one, pending example.

## Adding Dinosaurs to the Enclosure

Let's think a bit more about the `Enclosure`. We will definitely need a way to
to add dinosaurs to it. Let's describe that! 
`function it_should_be_able_to_add_dinosaurs()`. And because we'll most likely be
adding Dinosaurs one-by-one as they're born, I think an `addDinosaur()` method will
be quite perfect: `$this->addDinosaur()` and pass that a `Dinosaur` object.

[[[ code('051fdc02b2') ]]]

## Mock the Dinosaur Object?

But wait! This is the *first* time that we're calling a method on our object and
what we need to pass to that method is... another object! Ok... so what's the big
deal? Remember, in unit tests, each class is supposed to be tested in complete
isolation. If you have a class that depends on a database connection, instead of
passing the *real* database connection object, you're supposed to pass it a *mock*
object so that it doesn't make *real* database queries and also so we can fake and
control the return value of its methods.

So... question time: should we mock the `Dinosaur` object? And if so, how do we
do that?

The answer is... probably no: we should *not* mock it. Whenever you need to pass
an object to the object you're testing, you need to decide whether or not to mock
it. And the correct answer depends on how *difficult* it is to instantiate the object
and control its behavior. For example, the `Dinosaur` object is a simple model
object, and it doesn't really *do* anything - it just holds data. It's easy to
instantiate and, if we want its `getLength()` method to return 7 to help us test
something, yea, that's super easy! Just set its length to 7!

The point is: the `Dinosaur` object is *so* simple, that mocking will work, but it
will make your life harder! That's why I prefer to pass in the real object.

If this were a database connection object, something that sent emails or any other
class that did some real work, I *would* mock it, and we'll talk about how to
mock things in phpspec soon.

Let's copy this line so we can add two dinosaurs. And then say
`$this->getDinosaurs()->shouldHaveCount(2)`.

[[[ code('1b9a74b034') ]]]

Ok, let's try it!
 
```terminal-silent
./vendor/bin/phpspec run
```

Woo! Sweet phpspec failure - let it generate the new method. Then, flip back and
find that new method. Change the argument to `Dinosaur $dinosaur`. And inside
the method, `$this->dinosaurs[] = $dinosaur`.

[[[ code('e0ac7571bc') ]]]

Did we mess anything up? Find out:

```terminal-silent
./vendor/bin/phpspec run
```

Definitely not... because our tests are green!

Next, let's talk about how we can test *exceptions*, including exceptions that
might happen when your object is being constructed. Oh, and we'll use a cool
`ObjectMatcher` that lets you test methods that return a boolean in a really
smooth way.
