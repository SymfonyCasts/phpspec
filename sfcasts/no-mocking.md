# No Mocking

Coming soon...

So for all of our examples have not really needed to involve other objects. What I
mean is, for example, in `DinosaurSpec`, when we call set length, we're just passing
at a scaler argument of closest we've gotten. There's never been a situation where we
actually do passengers or the object that we're describing depends on another object.
That's something that we are going to start to talk more about, but first and our
`DinosaurFactory`, we have this create this `growVelociraptor`. Eventually we're
going to add other methods to grow other things and just to make sure I don't forget
I'm going to create a new. `it_grows_a_triceratops()` method, but I'm not actually ready
to describe this or implement it yet, so I'm just going to leave that method. There.
Is this kind of a cool thing because if I run this now, 

```terminal-silent
php vendor/bin/phpspec run
```

it shows it as a pending
example school thing. You would actually write your examples as little to do's and
not actually worried about implementing them and then come back to them later. One
other thing you can do, which is a little bit less common applications, but something
you'll see in libraries is you can skip tests if you're missing some sort of a
dependency.

For example, if I create a. `it_grows_a_small_velociraptor()`. Well, let's pretend like
we need an outside library that contains a class called `Nanny` in order to create baby
velociraptors so that class doesn't exist and it became through a `new SkippingException`
 and say Someone needs to look over dyno puppies. So if you don't have this
outside library available, that actually gives you this exception, this `Nanny` class,
then we'll actually skip and if we do have it then we'll do our normal. 
`$this->growVelociraptor(1)` and say something like it `->shouldBeAnInstance()` of 
`Dinosaur::class`.

Since this is a just a made up class, we're not going to have that want to go over
and run it.

```terminal-silent
php vendor/bin/phpspec run
```
 
 You can see that as this time it has a one that skipped also. Alright, so
let's. Now that we have dinosaurs, we need somewhere to keep them. We need an
enclosure because of course we all know that if we just slept, the dinosaurs were
unfree bad things happen. So let's describe it a new. So we'll do 

```terminal
php vendor/bin/phpspec describe App/Entity/Enclosure
```

The idea is that we put dinosaurs inside the enclosure and to start, I'll actually start
with an example before. Generally the class, we need to make sure that the enclosure
is empty by default. So we'll say something like `it_should_have_no_dinosaurs_by_default()`.

And the idea is that probably this enclosure will need to get dinosaurs methods. So
will say `$this->getDinosaurs()->shoudHaveCount(0)` Awesome. Good start. Now I can run back over.

And run phpspec run

```terminal
php vendor/bin/phpspec run
```

`yes` to generate that class? Yes. To generate. To `getDinosaurs()`
method inside of it, it's never jumped straight into not only having that
class, but we have our initial method here.

Okay.

Alright. So to get started, we're probably gonna need a `$dinosaur` property. Well I
have some documentation that this will be in `array` of `Dinosaur` objects out here. Will
return an `array`, but really we're just going to `return $this->dinosaurs`. Now I could
have just read literally hardcoded return an empty array because that's the minimum I
need to do to get this test to pass. But as we get better with PHPstorm phpspec,
we're gonna not do such silly shortcuts and actually start coding things a little bit
more correctly now under our tests.

Now, when you run the test, boy flubbed that up.

```terminal-silent
php vendor/bin/phpspec run
```

This time it passes just the one pending example still.

Alright, so let's think about the enclosure. We're going to need to be able to add
dinosaurs to it. So let's describe with an example of how we want that to work. So
I'll say `function it_should_be_able_to_add_dinosaurs()`. I'm going to decide that. The
way I want to do that is actually via an addder method. So I'm going to say something
like `$this->addDinosaur()` impasse it a `Dinosaur` object. But wait, this is the first
time that we're calling a method on our object and what we need to pass it is
actually another object. Okay? So what's the big deal? Well, the big deal is,
remember in unit testing, all of our classes are supposed to be tested in isolation.
So if you have a class that depends on a database connection, instead of passing that
the real database connection object, you're supposed to pass it a mock object so that
it doesn't actually make database queries.

So the question here is, should we pass as a mock dinosaur object? And if so, how?
The answer is no there. When you think about whenever you need, instead of just
passed `new Dinosaur()`, whenever you need to pass an object to the object of your
testing, you need to decide whether or not to mock it based on how complex the object
is that you're passing in. Fasting a simple `Dinosaur` object or any simple model
object, that object is just a simple container of data. So it's really just simpler
and it has no real downside. So just passing in the real object. Now this re database
connection or something that sent emails or made API requests or anything else that
actually did something, then I would mock it and we'll talk about how we mock things
in phpspec back a bit later. So let's copy this line so we can add two dinosaurs and
then we can say `$this->getDinosaurs()->shouldHaveCount(2)`. All right, so move over.
Run.
 
```terminal-silent
php vendor/bin/phpspec run
```
 
That of course fails. We don't have an ad dinosaur method, so we'll generate it.
Now we can flip back and go to the part of our where we actually make this pass. So
let's make this a `Dinosaur` type hint `$dinosaur` argument. And then the code in here is
simple. Just add that to the dinosaurs `array`. Did we mess anything up? 

```terminal-silent
php vendor/bin/phpspec run
```

Definitely not
because our tests pass. All right. Next let's talk about how we can test exceptions,
including exceptions that might occur in your constructor.