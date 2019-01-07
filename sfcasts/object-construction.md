# Object Construction

Coming soon...

Let's keep designing our `Dinosaur` class intersect, so we have a length right now and
the next thing that we need for application is we need a description method and
that's going to return the type of dinosaur whether or not it's carnivorous or non
kind of as an Allston, the length, because we need a way to display on the front end
a whole description of the dinosaur very, very easily. So just by kind of talking
that out, we now have something that we can describe, so I'll say
`it_should_return_full_description()`. And for this first test I won't send any data on
this. We're just going to kind of look for what the default descriptions would be.
So let's say there will be a new `getDescription()` method doesn't exist yet and
it `shouldReturn()`. How about because we haven't seen any data,
`'The Unknown because non-carnivorous dinosaur is 0 meters long'`.

Perfect.

So that's the default description. If nothing is set, you guys know at this point the
flow here is we've now written the tasks. It's probably failing. We run phpspec.

```terminal
./vendor/bin/phpspec run
```

It is failing. It offers to generate that a `getDescription()` method for you.
Let's say `yes`, that's awesome. Reruns the SPEC and now it fails because the new
method returns `null` and now if you remember the cycle, the second part of the cycle is to
make the test screen with as little work as possible and that literally means we can
copy this string, go into dinosaur, find the new method, and just return that hard
coded string. Also add a return type just to make things nice. Now I know that seems
silly and I don't always do this in practice, but this is the way that I want you to
be thinking. Don't overcomplicate your code. If this is the only requirement, forget
description, then this is the only thing that we need to return and yeah, that makes
the test pass. If we need our code to be more complicated than we can describe it
with a Spec,

so let's go back to our `DinosaurSpec` class. Now obviously what this is,
`getDescription()` is mentioning kind of the type of the dinosaur that's we're gonna. This
is to be the genius of the dinosaur and whether it's carnivorous or non credit risks
right now or dinosaur class doesn't have any way to store the type of the dinosaur or
whether or not it's carnivorous or non credit risks. So these are things that we're
probably gonna need to add, but before we add them to dinosaur, let's just think
about how we want them to be set so far for the length. We've had a set length
method, but I think since the type of dinosaur end, whether it's carnivorous or non
carnivorous, are so important. Let's set it via the `__constructor()`. So first, let's
grade the example. `it_should_return_full_description_for_tyrannosaurus()`.

Now, up until now, we know that behind the scenes, phpspec is taken care of
creating the `Dinosaur` object for us so that when we called get description, there's
already a `Dinosaur` object being created. If we want, we can control how that's
created. The way we do that is by saying `$this->beConstructedWith()` and quite
literally we just passed the arguments that we want to pass to the new dinosaur, so
almost pretend like this as new dinosaur and then we say, okay, the way that I would
like to design the design, the dinosaur class, as I can pass the dinosaur type as the
first argument, tyrannosaurus, and then whether or not it's carnivorous or not as the
second argument. So we just do. We tell we described that in our example. Then let's
say `setLength(12)` done down here. We'll do `getDescription()->shouldReturn()` this time.
We'll use the language, `The Tyrannosaurus carnivorous dinosaur should be 12 meters
long`.

Perfect.

Now, thanks to this test, we obviously know that hard coding, the description is no
longer going to work, which is great. It's going to force us to actually implement
this correctly.

By the way, if you have a situation where for some reason you have multiple lines
with this be constructed with, which is something that can happen, um, once you start
to organize your code a little bit better, the last one is the one that always wins.
What happens behind the scenes is that phpspec delays instantiating your object as
long as it can, so it doesn't actually instantiate your object until you call a
method like `setLength()`. At that moment it realizes it needs to instantiate your
object and it instantiates with whatever your last beak instructed with was.

All right, let's try this. Let's run it.

```terminal-silent
./vendor/bin/phpspec run
```

And Oh, this is really interesting. It says
that the method `__construct()` was not found. It's realizing that we're saying be
constructed with and we don't have a constructor, so that actually asks us if we want
to generate that automatically, which of course we do reruns are desks and everything
explodes. Alright, so two cool things here. First of all, in dinosaur, yes, it did
actually make a constructor in bonus. It even put it in the right place above our
public, at the top of our class, after our properties. The second thing is when it
rerun all of the examples, they're almost all failing now, too few arguments to
dinosaur construct and that makes sense. We just massively changed the way that our
dinosaur class is designed and so any existing examples probably will fail. So this
is actually a good example of our test giving us good feedback. So an international
star class, let's actually implement our code here. These arguments, let's have the
first one to be the `string $genus`. That's the kind of a data center type and then a
`bool $isCarnivorous`. I'm going to press

option, enter alt, enter and go to initialize fields, which is just a nice shortcut
for creating those two properties and setting them all. Now remove the to do

as a bonus.

Now I'm also going to make these arguments optional. Why? Well, it's entirely up to
you how you want your class to work. If you look back at our dinosaur specification,
according to this example, it looks like it should be legal to create a dinosaur
object with no information and have it be an unknown non carnivorous dinosaur. So in
our case we want to make it easy to create dinosaurs, so we'll just give these
default values

and it's kind of wrist is going to default to false. Whether you didn't want to do
that or not is entirely up to you and finally done and good description because of
course our test is still going to be failing because we have 70 hardcoded. If you're
in your test now,

```terminal-silent
./vendor/bin/phpspec run
```

it's of course still going to be failing because we had the wrong
string. By the way, if you want a little bit more information because you can see it,
truncates it, he can pass Dash, dash for verbose and there Yo,

```terminal-silent
./vendor/bin/phpspec run --verbose
```

you get the full
description of what the differences. So let's now make this a little bit more
flexible or wrap it in a `sprintf()` and we'll put some wildcards there for the genus.
The non part of Ononokin avarice and then a percent d, four meters long, and we fill
those in with `$this->genus`. `$this->isCarnivorous ? '' : 'non-'` and it will either be an empty string
or the word non dash, and then `$this->length`. Actually I'm gonna. Make a little typo
here just to make this a little bit more realistic. Now I move over. Refresh.
Awesome. You could see that it still fails.

```terminal-silent
./vendor/bin/phpspec run --verbose
```

Let's move over and take off the verbose

```terminal-silent
./vendor/bin/phpspec run
```

and you see it still fails of course, but
it's not exactly obvious why because these strings look pretty similar and that's why
the verbose option is great because that's a really easy way to see exactly what's
going on up there. There's our type of right there. Go back Ria that. Oh, and a
dinosaur. Rerun the test 

```terminal-silent
./vendor/bin/phpspec run
```

and I'm still failing. Oh, because I actually have my
language wrong here. This is a problem in our SPEC class I'm getting. I've been using
phpspec for too long. Chains. That should be two is and this time there we go. 

```terminal-silent
./vendor/bin/phpspec run
```

Now it passes, so our code and our sped classes are keeping each other very tight.