# Stubs

Coming soon...

Our new `EnclosureBuilderService` is a building the security systems and adding them
to the `Enclosure`, but it's completely ignoring this `$numberOfDinosaurs`. It's not
creating any dinosaurs yet, and obviously we already have a class that is really good
at creating dinosaurs. It is our `DinosaurFactory`, so thinking about the design of
enclosure bill, the service, it will need the `DinosaurFactory` in order to add the
three dinosaurs into the enclosure. That means that

`EnclosureBuilderService` is going to need a `__constructor()` so that we can use
`DependencyInjection` to pass the `DinosaurFactory` into the `EnclosureBuilderService`.
This is just the common pattern `EnclosureBuilderServices` they service stuff it
needs access to another service like that `DinosaurFactory`. We use `DependencyInjection`, 
so that's the design that we're going to need for this class. And of
course that's something that we can describe inside of our specifications. So right
now we haven't said anything about how `EnclosureBuilderService` is instantiated, so
it's being instantiated with no arguments. Now I want to use `$this->beConstructedWith()`
and pass it a `DinosaurFactory` object. So this is the situation where you have
the object protesting has a dependency on another object, and the question is, should
we just instantiate it manually or should we mock it and in this case we should
market. The reason is that as a rule of thumb, if the object that you're working, the
object in question is a service object like the `DinosaurFactory` or doctrine
`EntityManager` or some sort of `Email` object. Those are the types of objects that you need to
mock because they usually do things they're difficult to instantiate if you're
working with a simple model object like in `DinosaurFactorySpec` when we needed

or actually `EnclosureSpec` when we were working with a simple class. If the object
you're working with this really simple, simple model object, then it's just simple
enough just to instantiate it anyways. In this case, we are going to mock it. So to
do that, we already know how we're going to add a `DinosaurFactory` argument to our
method. Thanks. That feature SPEC will automatically create a

what's called a dummy object and object that looks like a `DinosaurFactory` but isn't
actually a `DinosaurFactory`. Then we can pass this to `beConstructedWith()`. Cool.
Let's not do anything else yet. We've just described that now our `DinosaurFactory`
should be instantiated or `EnclosureBuilderService`. You'd be instantiated with
`DinosaurFactory`, so let's run phpspec. 

```terminal-silent
php vendor/bin/phpspec run
```

It sees that the `__constructor()` is not found, asks if you want to generate it. 
We of course do and now perfect. We have a `__constructor()`, so let's fill the end data 
sort of factory. That is our factory, but actually I'm not even going to do anything 
with it yet

to be technical. In order to get a test to pass, we just needed to have a `__constructor()`
that takes that argument. So when we run our tests now, 

```terminal-silent
php vendor/bin/phpspec run
```

Yep. It passes. Well it
doesn't. There is one failure, but you can notice this is online 13. This is our. It
is initialized double. It's failing because we don't have the deconstructed with. I'm
going to actually ignore that for now and instead, let's just focus on running this
one test online 18, so to do that I'll run back, run, but then will point this at our
`EnclosureBuilderSpec` line 18. 

```terminal
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:18
```

Cool. That passes. All right, so what do we
actually want to test here? What do we actually want you to describe in our example?
What I want to describe is that if we passed two for the number of dinosaurs that we
actually get an enclosure with two dinosaurs right now. If you `var_dump()`, let's 
`var_dump($enclosure->getDinosaurs())` right now and see what happens. Of course, 
this returns as a wrapper object a `Subject`, but if you look inside the actual wrapped 
object isn't empty `array`. That makes sense. We're not sending anything on.

I'm not setting any dinosaurs on the enclosure inside of our service, but here's the
really interesting thing. Even if we actually added the code now to use the `DinosaurFactory` 
to create a few dinosaurs and then add them to our `Enclosure`, the test would
still fail and that's because when you create a dummy object like `DinosaurFactory`,
that's not the real `DinosaurFactory`, and by default all of its methods return `null` so
if we wrote code in here to use the `DinosaurFactory` to create dinosaurs, it wouldn't
actually create dinosaurs. It would return `null`, and either the test would pass or more
likely are coded blow up because it's not expecting that. So these dummy objects,
they do nothing by default, but there are actually two things that you can do with a
dummy object. One, you can add behavior and that's what we're going to do in a
second. That's where we actually tell it exactly what values should be returned from
what from specific methods. The second thing you can do is add expectations. That's
where you can actually say that a certain method on `DinosaurFactory` should be called a
certain number of times. That's something we're going to do later. So what we want to
do now is basically say, hey, when the `growVelociraptor()` method is called, it should
return a `Dinosaur` object. So check this out.

That's great. A `$dino1` variable set through `new Dinosaur()` that's credit, new
stegosaurus.

That's a which is a veggie source, `$dino1`. And let's `setLength()` too. How about
`6`? Now, here's the key part. We want our `DinosaurFactory` dummy object to
return this `Dinosaur`. When somebody calls `growVelociraptor()`, I know it's confusing
because this is not actually a velociraptor, but this is proving my point. We can
completely control how it behaves. We can do this by saying 
`$dinosaurFactory->growVelociraptor()`. So we actually pretend like the
`$dinosaurFactory` a real object and just like normal with respect, we then need to
pass it the correct arguments. So I'm going to say that whenever we use the 
`EnclosureBuildersService`, it's always going to grow a velociraptor of length five. That's
the. That's how I want the class to work. Then here's the key part. We can say 
`willReturn()` to control what value it's going to return and here I'm going to pass `$dyno1`
. 
So now we've given behavior to our stuff and in addition to we'll return is what
you use most of the time. There's also a another will method where you can pass in a
callback and that's where you can do something custom.

Um,

if this is called multiple times, we'll talk a little bit more about that later. So
now if we run this test, 

```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:18
```

it actually doesn't work. That's because we are now online
at 19 

```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

it still passes because we haven't added any assertions. But now look at this.
Check this out.

Oh nevermind.

But of course our subject is still an because we're not actually coding anything up
yet. So let's do that. And `EnclosureBuilderService`. Let's, I'll hit Alt + Enter on
`$dinosaurFactory` to create and set that property. Then we'll call a new method
called `addDinosaurs()`. Pass it the `$numberOfDinosaurs`, not copy our ad security
systems method. I'll add dinosaurs.

You know what, let's not do that.

Actually, I'll go up, I'll put my cursor on `addDinosaur()`, hit Alt + Enter to add that
method. Let me copy the inside of `addSecuritySystems()`, paste that this time we use a
`$numberOfDinosaurs` and very simply we can say `$enclosure->addDinosaur()` and two
that we'll use our `$this->dinosaurFactory` and will say `growVelociraptor()`. And remember
in the example we expected this to be called always with a length of `5`. Perfect.
Let's not move over. Run the test again,
 
```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
``` 
 
it still passes, but the key thing is check
this out in our wrapped object. It is. Now I'm going to re with two dinosaurs in it
and they're actually the exact same dinosaur, so each time that don the `growVelociraptor()`
 methodist called

are

dummy object, now returns that same dyno object each time, and this is really cool
because we can add a great assertion down here. We can say 
`$enclosure->getDinosaurs()[0]`, get the first index and say `shouldBe()`. We know that 
this should exactly be the exact same object as `$dino1` and it's a little strange, 
but we can actually check that. The second item, and there is also that exact same 
thing because the dinosaur factories always returning that same object, so now move over, 
run and it

```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

passes, and so this is the first great superpower of these dummy objects. By adding
behavior to them, we can actually help our tests run and even help us have really
great assertions. We now know that the exact objects that are returned from our 
`DinosaurFactory`, our attitude, the `Enclosure`. Now to make this a little bit more
realistic, let's copy `$dino1` make it `$dino2` to make this a Baby Stegosaurus with length two,
and what I want to do is I want to say that the first time that `growVelociraptor()` is
called, I want to return `$dino1`. The second time it's called, I want to return
`$dino2`, so a little more realistic. The way you can do that is just passing a
second argument to `willReturn()`.

That's it.

Now, down here, the second object is going to be `$dino2` to move our. Run that 

```terminal-silent
php vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:19
```

and
it passes. All right. Next, let's talk a little bit more about this. A five here. As
it turns out, there's a lot of very interesting things you can do with this argument
if it's maybe a dynamic value or if you call this multiple times, so we'll talk about
that next.