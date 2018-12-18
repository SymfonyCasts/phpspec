# Object Matcher

Coming soon...

Sometimes your knee, your code and needs to throw exceptions. In fact, sometimes it's
super important that the right exception gets thrown into the right time. I have a
great example in the tutorial directory should have a tutorial directory. If you
download the source code and there is an exception directory, copy that into our
source directory. It says two exception classes, and the first one that we're going
to look at is called the very important, not a buffet exception. This is a very
important exception that we need to throw if we tried to mix carnivorous and non
carnivorous dinosaurs into the same enclosure. This is such an important thing that
we need to make sure there is a test for this exception being thrown. So this is
going to live in our enclosures Faq. This is a new example of how it should work. So
let's say function. It should not allow to add carnivorous dinosaurs to non
carnivorous.

Okay?

Enclosure along name, but that's actually okay. That's describing it really well what
we're testing for.

Okay.

Basically the idea is we're going to add one dinosaur that's a veggie dinosaur and
then add a another dinosaur that's a carnivorous dinosaur, and when we call add
dinosaur the second time, that's when the exception should be thrown. So we can start
just by saying this dinosaur dinosaur. We'll make this a veggie eater bypassing false
as the second argument,

and here's the key.

Before we call head dinosaur, again, we need to tell peach respect to expect that
there should be an exception. So we're again, we're going to describe with an example
how the store, so the language is really nice with this. This should throw, hey, not
a buffet exception ::class exception during, and then you can tell it exactly what
method to call. So we're going to call a dinosaur and then pass it an array of the
arguments. We're on a pass, which is going to be one new dinosaur object with
velociraptor passing true for the carnivorous argument,

and that's it.

So let's try this. Go over run piece SPEC and perfect. We can take steps to me
because no exception was thrown perfect. Now it's time for us to get to work, so in
ad dinosaur we need to determine whether or not we're allowed to add this dinosaur.
I'm going to call a new function on this. If not, this->can add dinosaur and we're
going to create that method in a second and throw new, not a buffet exception. I'll
go back up to this candidate dinosaur. I'm going to hit alt enter to add method and
we're gonna. Make this a private method. The bottom, and I'm just creating this as a
private method just for Nice Code Organization. It's nice to have a method called can
add dinosaur. I'm not making it public because I at least so far, have no need for it
to be public. There's nowhere in my application that's actually using this. That also
means that we won't write an example directly for it because you can only write
examples for public functions. I'll add a return type here. Then we'll say return. If
the count of dinosaur, this era dinosaurs is equal to zero, then we can have the
desert because it's empty, or if this->dinosaurs left square bracket zero. If the
first dinosaur is carnivorous,

the first dinosaur, then I'll call them ethanol. It's called is carnivorous and
method does not exist yet on the dinosaur object, and actually that's really the
problem here is that current members information is not really made publicly
available anywhere inside of here except for the description, so we're actually going
to need to enhance our dinosaur class as well to get this to work. So I'm saying it
would be nice in my on my dinosaur if I could call his carnivorous, honest, and then
if that value = dinosaur era is kind of reverse than they are compatible in this
dinosaur. It can be added to the this enclosure

so we can run this now, but we know it's not going to pass because we're calling an
undefined method called the undefined method dinosaur. Colon colon is carnivorous, so
let's back up a second. We couldn't go directly into our dinosaur class and just
implement that. It's a super easy method. I'm just for this one boolean property and
actually that's probably what I would do in real life. So far. We've been testing a
lot of our getters and setters. You can test your getters and setters, but at some
point methods are so simple that they don't necessarily need to be tested, but for
purposes of this tutorial testing, this property actually is interesting because it
uses a new matcher, so let's kind of do this the proper way. That's going to our
specification class first, and let's actually describe this. So first, let's say it
should be herbivore by default. Basically, meaning that if we don't, if we just
create a new dinosaur object, it should be an herbivore and watch the language I want
to use here. I'm just going to say it's already created the dinosaur objects in the
background with no arguments, so I'm just going to say this->should not be
carnivorous

and it's obviously not a built in matcher and you can see that and no, we're not
going to create a custom matcher. This actually will match it. A very dynamic Costa
magic called the object's state matcher. When you say should be carnivorous or should
it not be carnivorous, what it's going to do is it's going to look for in his
carnivorous method, onside of her, on top of her object, and check whether it's true
or false. Let's write one more example before we see this. We can say it should allow
to check if dinosaur is kind of risks here. We'll say this->be constructed with.
Remember our dinosaur class we construct it was with the second argument is is
generous. We'll pass it velociraptor. True. Then we can say this->should be
carnivorous, so it's the same thing. I'm here just without being not. Not really.
Cool thing is what happens when we run this gas. It actually says, look, he says,
call to undefined method is carnivorous. That's coming from. It should be able to add
dinosaurs.

Why not run? Run?

As you can see, it actually fails. You can say it should be herbivore, but a fault
and it should allow you to check up dinosaurs. Carnivorous says method array to not
found. Let's rerun that with verbose.

No, that's not going to help. We're not gonna. Do that,

that's not a very clear error message, but what it's actually doing is looking for
the is kind of risk method and dinosaur. You're gonna actually see this below because
it's saying, Hey, do you want me to create this for you? Yes, I do. Awesome. And then
it reruns and of course those do fail. But if you look at your dinosaur class, we now
have an is carnivorous argument. A method which means that we can get to work by
returning to this->is carnivorous and I'll add the total return type on there.

All right, so let's go back Ron, and now everything passes which includes both our
diners to new dinosaur specifications that you use, this new manager and also our
enclosure spec because our enclosure is now properly using these methods and throwing
the exception. So now we have our test passing. Now we can think about refactoring
this. Um, instead of comparing the is carnivorous to these two things, it might be
nice to be able to go have a method on our dinosaur class call has same diet as or we
could pass it a dinosaur object. And basically check very easily if two dinosaurs
have compatible diets. So no problem. Let's describe this in our, but the new new
example, we'll say it should allow to check if two dinosaurs have same diet here.
We're going to use that should language. Again, we're going to say, how about should
have same

diet

as a new dinosaur? Not that's a little bit confusing at first, but if you remember
when you say this, that means it's going to create a new dinosaur in the background
with no arguments. So that's going to be a veggie source. So he passed that. Another
veggie source that's going to have the same diet. Now what are the issues I have with
this matches the object's state matcher is that in the beginning I kept thinking,
Hey, I want to have a method called is carnivorous. Okay, what should the. What
method do I need to calm here to match up with his kind of risks? And actually I want
you to think about it the other way. I want you to think about when about it. This
way, when you're writing your example, I want you to use as natural language as
possible, so I want you to think, I don't care what the method is going to be called
on my dinosaur, but I want to be able to say, should be carnivorous and down here
should have same diet as use the natural language inside of your Spec. Then when you
run your test, PHP Spec is going to tell you what method name you should have inside
of your class that will match up with that language. It's time, it's has same diet as
so yes, degenerate that. Then over here we'll just fill in the logic so this will
return a fool.

The argument will be a data store object and we can return this arrow. You return
dinosaur era is carnivorous = = = dinosaur. This->is carnivorous and now when you run
it, excellent it passes, and now that we're green, we can do a little bit of
refactoring inside of our enclosure and making use this method instead. So I'll get
rid of all this complicated stuff in the end and we can simply say, or dinosaur->has
same diet as this arrow. Dinosaurs left square bracket zero. We're going the test one
more time and we've got it. Awesome example of several different classes working
together in Austin, writing the specs piece by piece to get a really nice design.