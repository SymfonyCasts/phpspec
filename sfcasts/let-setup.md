# Let Setup

Coming soon...

Alright, so with this example, executing really well,

```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

let's go back and run all of the examples in the specifications. 

```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php
```

Vasquez boom, surprise. The first one is initialized, was failing to few arguments to the
constructor zero past expected one. That makes sense because we have this 
`beConstructedWith()` inside this example, but we don't have it here. Of course we could
just duplicate it and add the same argument up here, but it does kind of make me
think. Would it be nice if we could have a, a method that was called before each of
our examples, a method that can do some sort of setup and of course the answer is
that this is totally possible by creating a function called `let()`. `let()` will be called
once before each example, so `let()` than `it_is_initializable()` will then `let()` again before
our second example. Inside. That would be the exact same thing as our methods,
meaning if we need a double, we can edit `$dinosaurFactory` argument. This allows us
to move the this `beConstructedWith()` up to our `let()` so that it's run before each
of these and the important thing here is that let will be called first. It will
create a testable called `$dinosaurFactory`

and then down in our example, we need to make sure that we get that exact same
`DinosaurFactory` because that's what we're going to add our behavior to. Way that's
done is by the name of the argument. So the fact that this argument is called
`$dinosaurFactory` here and this one's called `$dinosaurFactory` down there, it means that
those will be the same object if we needed multiple audits, our factories, we get to
have to `$dinosaurFactory2`, and `$dinosaurFactory2` down here and it would match up
by name. Point is this is enough 

```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

to get our test to pass. So let's do one last thing with our `EnclosureBuilderService`. 
One of the things I want my `EnclosureBuilderService` to do is save the enclosure builder 
to the database after it finishes building it. Now, obviously we don't have a database 
in this application, but we're going to write our example as if we have one. So if you 
look in the `tutorial/` directory in the `Service/` directory, there is an 
`EntityManagerInterface`. Copy that and put that into our `Service/` directory. 
Now if you are a Symfony user that uses Doctrine and this is going to look familiar, 
I do not recommend that you actually put an `EntityManagerInterface` into your application 
like this. We're putting. We're using this as an example to pretend that like doctrine 
is inside of our application. It has the exact same `persist()` and `flush()` methods on it. 
That doctrines `EntityManagerInterface` has.

We're doing this big so that now instead of our example, what I want to do is I want
to make sure that `persist()` and `flush()` are called on our `EnclosureBuilder`. I want to
make sure that we don't forget to save this to the database inside of building
closure, so this means that our `EnclosureBuilderService` is going to have another
dependency. It's going to have an `EntityManagerInterface` dependency and that's
going to be passed as these second argument

and then way down here I'm going to. We need to assert that `persist()` and `flush()` had been
called on it, so we'll get that same test double here by saying 
`EntityManagerInterface $entityManager` using these same argument name is above and down here. 
It doesn't matter. I can either do it as a mock up here or I can do it as a spy in the
bottom. I'll do it as a five. I'll say `$entityManager->persist()` in. This is going to
be past our enclosure objects, so what we can do here is say `Argument::type()` and this
is going to be an `Enclosure` type. We'll just make sure that it's actually past the
right argument and then we'll say `shouldHaveBeenCalled()`. Then I'll do the same
thing down here with `flush()` flush, doesn't take any arguments and we'll just make sure
that it's been called and that's it. This time we're not con, not giving it any
behavior. This is purely something that we're using as a spy so that we can assert
some expectation on it, so if we go over and run the test out, 

```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php
```

perfect, it fails. It says that no calls have been made that match `persist()` with 
that type of argument, but expected at least one. So let's go now into our 
`EnclosureBuilderService.php`.

Well, at our `$entityManager` service argument, I'll hit Alt + Enter to to create that
property and set it, and then down here on the bottom, 
`$this->entityManager->persist($enclosure)`. `$this->entityManager->flush()`. Alright, 
let's try that. Move over, run it 

```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php
```

and it passes and let's run all of our specs from the top 

```terminal-silent
php vendor/bin/phpspec run
```

and it works. Guys, that's it. phpspec is not. There's not more super complex 
stuff to tell you. That's it. phpspec is really on the service, a very simple tool 
for allowing you to write examples where you actually treat your object like the 
actual object. What'd you have to get used to is kind of the magic behind the scenes, 
but once you embrace the magic and use the, cogeneration is an amazing tool for 
creating great unit tests, but primarily for helping a design really nice classes.

Okay.

Now the one word of warning I always like to give people is that just because you
have a wonderful testing tool like phpspec doesn't mean you need to test every
single thing. Uh, like in `DinosaurSpec`, we're doing a lot of testing on our getters
and setters, so you can do that. That's up to you. But in my project I typically unit
test classes and methods that have some real complexity and actually scare me. So
using phpspec to test and design those classes in addition to other tools like
a behat and phpspec PHPunit for integration tests, it gives you a great suite of
tools to use for testing your application. I guys get out there, right some really
fun phpspec specifications and examples and we'll talk to you next time. Bye.