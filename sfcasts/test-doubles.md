# Test Doubles

Coming soon...

It's finally time to talk about one of the most critical parts of unit testing and
that is mocking. If you look back at our `DinosaurSpec`, we have already had one
situation where we actually needed and we called a method. We actually passed it,
another object, so in this case, in order to test `Dinosaur`, we actually are dependent
on another object and happens to be a dinosaur, but the point is that this, the has
same diet as method on dinosaur has another object.

We saw this also in the `EnclosureSpec` when we were adding the dinosaurs. We actually
passed it new `Dinosaur` to them, so we discussed earlier. When you have a dependency
like this, when you have, for example, your `Enclosure`, you have a method in your
closure that requires another object. You have two options. First, you can just pass
the real object and that's what we've been doing so far, but just amazing. A new
`Dinosaur` object and that's a really good idea when the object you're passing is super
simple, just a small object that holds some data. It's just really simple. The past,
the real object. It's very easy to control that object and it doesn't do anything. It
doesn't make database queries or anything like that this, but sometimes the object
you're trying to build is very big. Maybe it has lots of other dependencies or maybe
it actually talks to the database and in those cases we do want to. We don't want to
use the real object. We want to mock them. We want to create a test double. So to see
an example of this, we're actually going to do the same. We're going to make a new
example that test the same thing, but does it with a test double. So I'm gonna create
a function called

`it_should_allow_to_check_if_two_dinosaurs_have_same_diet_using_stub()`. And I want to
talk about what that means in a second. All right, so check this out. Instead of us
creating a new `Dinosaur` object we're going to do is we're actually going to add a
type hint to this method with the `Dinosaur` type event and then I'm just going to 
`var_dump()` that so we can see what that looks like. Alright, so let's move over. Run our
tests 

```terminal-silent
php vendor/bin/phpspec run
``` 

and ah, interesting, sort of an object called a `Collaborator`, but what I really
want you to see inside it is this thing called a `$prophecy` and an `ObjectProphecy`, PHP
SPEC PGB specs, um, test double system actually uses a, another library called
prophecy. It's made by the same people, but it's technically an independent library.
And you can actually use prophet Prophecy inside of PHPunit if you want, for
example, which is kind of cool, but the point is it passes us a very special object
is not the real `Dinosaur` object. It's just an object that looks and smells like a
`Dinosaur` object in their, in and always do to get. This was just used a type event.

There are a number of things we can do in this `Dinosaur` object in this is really the
power of testimonials. We can, for example, control the return value of one of its
methods. Or we could check to see if one of its methods was called. We have 100
percent control over this object. So in this case, what we want to do is we basically
want to make sure in order to test the `hasSameDietAs()` we want to make sure that 
this mock object, when we call it, `isCarnivorous()` that that returns `false`. So we 
can literally say  `$dinosaur->isCarnivorous()->willReturn(false)` snows. This 
feels a bit like how we've been working with phpspec so far. Like normally we say 
things like `getGenus()->shouldBe...` when this case we're saying is kind of risk will return. 
We're not asserting a value, we're actually training it, we're teaching it how it 
should behave. Now we can say `$this->shouldHaveSameDietAs()` and of course this will 
be an object that was instantiated with no constructor arguments, so it will be a not 
the kind of risks and we could say it should have the same value as `$dinosaur`

and now want to move over and run that. 

```terminal-silent
php vendor/bin/phpspec run
``` 

That actually passes. This system is called.
These objects are called it test doubles, but you'll hear them called by a number of
other different names as well, like `stubs`, `spies`, and `mocks`, and those all are subtle
different words to describe the different types of things you can do with these. For
example, when you want to control the return value of an object, then that's known as
a Stub, so technically here, dinosaurs, a stub later. We're going to do things like
assert that a certain method was called, like for example, we could say, I want to
assert that the `isCarnivorous()` method was called exactly one time when we do that, it
becomes a spy or a mock. So all these terms stub spine mock are all different ways to
describe the same idea of getting a fake object from phpspec and then either
training it to have some sort of behavior or asserting that certain methods were
called on it. We'll see more of that later. Right now it's give us a more realistic
example. I want to actually start adding another feature to our application. Then we
can see all of this spies mock stuff, uh, in, in practice. So because we're creating
lots of dinosaurs and we're creating lots of enclosures, I want to create a new
helper service class called the enclosure builder service. So since this is going to
be a new class,

let's run phpspec describe and we'll say APP. How about service /enclosure
builder service 

```terminal
php vendor/bin/phpspec describe App/Service/EnclosureBuilderService
``` 

of course that creates the new spec class and thanks to that new
inspect clap so we can immediately ron, vendor php, been peaches back, run 

```terminal
php vendor/bin/phpspec run
``` 

and it will generate that class for us. Now you have the new SPEC and we have the new
service instead of the SPEC. The idea is that we're going to be able to tell the
enclosure builder service how many dinosaurs we want, how much security we want, and
it will create the entire enclosure for us. So that's kind of new function called 
`it_builds_enclosure_with_dinosaurs()` and will say something like `$enclosure =`. Well
how about a new method? We'll call it `buildEnclosure()`. We'll do is we'll pass that
the number of security systems we want, one and the number of dinosaurs you want and
the enclosure to. We'll just do some basic checks down here, like 
`shouldBeAnInstance()` of does she give us an instance of `Enclosure::class`,

and then we want to check to make sure that enclosure has active security. So we'll
say `$enclosure->isSecurityActive()` and actually this does not work yet because if you
look inside the enclosure, we do have an insecurity active but it's `private`, so we're
going to have to fix that in a second. Anyways, we'll call it 
`isSecurityActive()->shouldReturn(true)`. Simple enough. We're not inserting anything 
about the dinosaurs yet, but um, but that's a good test now and enclosure to get this 
to work. As I mentioned, we'll need to make this `public`, which is fine. It means 
that we have discovered that finally we actually need this method from outside of this 
class and because it's public, I'm going to move it up a little bit just so my public 
methods are on top. Perfect. All right, let's move over. Run that. 

```terminal-silent
php vendor/bin/phpspec run
``` 

Of course it fails. Let's
generate the new build enclosure method. It runs again and that fails because it's
empty.

Okay.

So that's the red part of the cycle, and now we can go onto our new `EnclosureBuilderService`.
Perfect and fill in this new method. So let's make two arguments here. I'm
actually going to use multiple lines for this. This method will turn an `Enclosure`.
First method will be an `int $numberOfSecuritySystems = 1` will
default that to one second will be `$numberOfDinosaurs = 3`, will default that to three
inside of the same `$enclosure = new Enclosure()`. `$his->addSecuritySystems()`, that's
gonna be a new method, will creighton a second pass of the number of security systems
and also the `$enclosure` we creating. And at the bottom we'll just return the `$enclosure`
for that `addSecuritySystems()` method. I'm just going to paste that on the bottom.
I'll read type the Y on `Security` and hit tab to get the auto complete to get the use
statement on top for this. So this just takes in the `$numberOfSecuritySystems`,
nothing special here. Does a `for` loop, goes over at the number of times, creates a
randoms name, set security to `true` and then adds that `Security` to the `Enclosure`. So
we're not adding any dinosaurs yet, which is fine because we're not actually
asserting anything about that yet. We don't actually have any of coded that about
that in our example. But if run it now 

```terminal-silent
php vendor/bin/phpspec run
``` 

it works

and this wasn't anything new, but now we have an awesome problem because in 
`EnclosureBuilderService`, we need to create some dinosaurs, but we're not going to create them
by hand. No, we have this beautiful `DinosaurFactory` that's able to create dinosaurs.
So we're going to use this instead, but that means that EnclosureBuilderService is
going to need the `DinosaurFactory` as a dependency. And that means in an example
class, we are going to need to somehow pass a mock version of that `DinosaurFactory` in. 

Let's do that next.