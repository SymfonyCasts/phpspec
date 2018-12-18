# Stubs

Coming soon...

Our new enclosure builders service is a building the security systems and adding them
to the enclosure, but it's completely ignoring this number of dinosaurs. It's not
creating any dinosaurs yet, and obviously we already have a class that is really good
at creating dinosaurs. It is our dinosaur factory, so thinking about the design of
enclosure bill, the service, it will need the dinosaur factory in order to add the
three dinosaurs into the enclosure. That means that

enclose your builder service is going to need a constructor so that we can use
dependency injection to pass the dinosaur factory into the enclosure builder service.
This is just the common pattern enclosure builder services they service stuff it
needs access to another service like that is our factory. We use dependency
injection, so that's the design that we're going to need for this class. And of
course that's something that we can describe inside of our specifications. So right
now we haven't said anything about how enclosure builder service is instantiated, so
it's being instantiated with no arguments. Now I want to use this->be constructed
with and pass it a dinosaur factory object. So this is the situation where you have
the object protesting has a dependency on another object, and the question is, should
we just instantiate it manually or should we mock it and in this case we should
market. The reason is that as a rule of thumb, if the object that you're working, the
object in question is a service object like the dinosaur factory or doctrines entity
manager or some sort of email object. Those are the types of objects that you need to
mock because they usually do things they're difficult to instantiate if you're
working with a simple model object like in dinosaur factory Spec when we needed

or actually enclosures back when we were working with a simple class. If the object
you're working with this really simple, simple model object, then it's just simple
enough just to instantiate it anyways. In this case, we are going to mock it. So to
do that, we already know how we're going to add a dinosaur factory argument to our
method. Thanks. That feature SPEC will automatically create a

what's called a dummy object and object that looks like a dinosaur factory but isn't
actually a dinosaur factory. Then we can pass this to be constructed with. Cool.
Let's not do anything else yet. We've just described that now our dinosaur factories
should be instantiated or enclosure builders service. You'd be instantiated with
desert factory, so let's run peachtree SPEC. It sees that the constructor is not
found, asks if you want to generate it. We of course do and now perfect. We have a
constructor, so let's fill the end data sort of factory. That is our factory, but
actually I'm not even going to do anything with it yet

to be technical. In order to get a test to pass, we just needed to have a constructor
that takes that argument. So when we run our tests now, Yep. It passes. Well it
doesn't. There is one failure, but you can notice this is online 13. This is our. It
is initialized double. It's failing because we don't have the deconstructed with. I'm
going to actually ignore that for now and instead, let's just focus on running this
one test online 18, so to do that I'll run back, run, but then will point this at our
enclosure. Brothers back line 18. Cool. That passes. All right, so what do we
actually want to test here? What do we actually want you to describe in our example?
What I want to describe is that if we passed two for the number of dinosaurs that we
actually get an enclosure with two dinosaurs right now. If you var dump, let's Varnum
enclosure, get dinosaurs right now and see what happens. Of course, this returns as a
rapper object a subject, but if you look inside the actual wrapped object isn't empty
array. That makes sense. We're not sending anything on.

I'm not setting any dinosaurs on the enclosure inside of our service, but here's the
really interesting thing. Even if we actually added the code now to use the dinosaur
factory to create a few dinosaurs and then add them to our enclosure, the test would
still fail and that's because when you create a dummy object like dinosaur factory,
that's not the real dinosaur factory, and by default all of its methods return not so
if we wrote code in here to use the data factory to create dinosaurs, it wouldn't
actually create dinosaurs. It would return no, and either the test would pass or more
likely are coded blow up because it's not expecting that. So these dummy objects,
they do nothing by default, but there are actually two things that you can do with a
dummy object. One, you can add behavior and that's what we're going to do in a
second. That's where we actually tell it exactly what values should be returned from
what from specific methods. The second thing you can do is add expectations. That's
where you can actually say that a certain method on dancer factory should be called a
certain number of times. That's something we're going to do later. So what we want to
do now is basically say, hey, when the Roe velociraptor method is called, it should
return a dinosaur object. So check this out.

That's great. A diner, one variable set through new dinosaur that's credit, new
stegosaurus.

That's a which is a veggie source, Donna one. And let's set its length too. How about
six? Now, here's the key part. We want our dentist, our factory dummy object to
return this dinosaur. When somebody calls Grove Velociraptor, I know it's confusing
because this is not actually a velociraptor, but this is proving my point. We can
completely control how it behaves. We can do this by saying dyno one->grow
velociraptor had a factory aero grow velociraptor. So we actually pretend like the
dinosaur factories a real object and just like normal with respect, we then need to
pass it the correct arguments. So I'm going to say that whenever we use the enclosure
builders service, it's always going to grow a velociraptor of length five. That's
the. That's how I want the class to work. Then here's the key part. We can say we'll
return to control what value it's going to return and here I'm going to pass dyno
one. So now we've given behavior to our stuff and in addition to we'll return is what
you use most of the time. There's also a another will method where you can pass in a
callback and that's where you can do something custom.

Um,

if this is called multiple times, we'll talk a little bit more about that later. So
now if we run this test, it actually doesn't work. That's because we are now online
at 19 it still passes because we haven't added any assertions. But now look at this.
Check this out.

Oh nevermind.

But of course our subject is still an because we're not actually coding anything up
yet. So let's do that. And of course you have other service. Let's, I'll hit enter on
dinosaur, our factory to create and set that property. Then we'll call a new method
called add dinosaurs. Pass it the number of dinosaurs, not copy our ad security
systems method. I'll add dinosaurs.

You know what, let's not do that.

Actually, I'll go up, I'll put my cursor on ad dinosaur, hit alt enter to add that
method. Let me copy the inside of ad security systems, paste that this time we use a
number of dinosaurs and very simply we can say enclosure era add dinosaur and two
that we'll use our dinosaur factory and will say glow pro blass raptor. And remember
in the example we expected this to be called always with a length of five. Perfect.
Let's not move over. Run the test again, it still passes, but the key thing is check
this out in our wrapped object. It is. Now I'm going to re with two dinosaurs in it
and they're actually the exact same dinosaur, so each time that don the grove
velociraptor methodist called

are

dummy object, now returns that same dyno object each time, and this is really cool
because we can add a great assertion down here. We can say enclosure Arrow, get
dinosaurs, get the first index and say should be. We know that this should exactly be
the exact same object as diner one and it's a little strange, but we can actually
check that. The second item, and there is also that exact same thing because the
dinosaur factories always returning that same object, so now move over, run and it
passes, and so this is the first great superpower of these dummy objects. By adding
behavior to them, we can actually help our tests run and even help us have really
great assertions. We now know that the exact objects that are returned from our data
so factory, our attitude, the enclosure. Now to make this a little bit more
realistic, let's copy make a dynamo to make this a baby stegosaurus with length two,
and what I want to do is I want to say that the first time that grow velociraptor is
called, I want to return [inaudible]. The second time it's called, I want to return
diner too, so a little more realistic. The way you can do that is just passing a
second argument to will return.

That's it.

Now, down here, the second object is going to be dyno too to move our. Run that and
it passes. All right. Next, let's talk a little bit more about this. A five here. As
it turns out, there's a lot of very interesting things you can do with this argument
if it's maybe a dynamic value or if you call this multiple times, so we'll talk about
that next.