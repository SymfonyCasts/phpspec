# Exception Message

Coming soon...

Okay,

in the exception directory that we just copied in a second ago, and there's another
exception of last call that dinosaurs are running rampant exception, this exception
we. The idea is that we have an enclosure, but we need to add security to that
enclosure. If we try to add a dinosaur to an enclosure that doesn't have security
like an electric fence or a guard tower that we need to throw this exception. We've
had too many problems with keeping people adding dinosaurs to enclosures and then
just leaving the door open so this is honest. Are in the enclosure SPEC and it's
credit new example called. It should not allow to add dinosaurs too. Unsecure
enclosures want you to temporarily ignore or forget our other existing examples
because this example is going to seemingly break the other ones and it will and those
we haven't even talked about. What security is security like a boolean true false on
enclosure or is there going to be another security object that we add to the
enclosure somehow? It doesn't matter. We're just going to say, hey, this->should
throw a new dinosaurs are running rampant exception and that's time actually going to
give this a message. Are you crazy?

And the reason I'm doing this is that you can either pass it a class name, in which
case feature SPEC. We'll just make sure it's an instance of that class and if but if
you care about the specific message being thrown, then you can actually create a new
instance of that object and pass the message. It's up to you. Anyways. Here we are
going to say during ad dinosaur new dinosaur. That's great. Any dentists aren't.
We'll do our normal velociraptor.

True.

All right. There's two things going on here. First of all, notice before we use this
during ad dinosaur and down here I'm saying during ad dinosaur, those are the exact
same thing. This one's a bit more natural because you can then pass the first
argument, common the second argument after it. Whereas up here, you need to put it
inside of an array. It's up to you. They are identical.

Yeah.

It really important thing here is we're saying that you can't just create an
enclosure and start putting dinosaurs into it. Somehow security needs to be activated
in some way. Whatever that means. So turn over here, run PGP SPEC and awesome. That
does fail because right now it is possible to add dinosaurs to enclosures without
activating security. So what? How do you want security to work in our application? So
the idea is thinking about the design, actually want each enclosure to be able to
have multiple different types of security that you can add to it. So back in the
tutorial directory, inside the entity directory, there's actually a class called
security copy that and paste that into our antsy directory. We're going to skip the
SPEC process for this and just start with this nice simple security class. You have a
name like fence or guard tower, whether it's active and then it actually takes into
the enclosure that it's attached to and then just as one method called get is active.
So inside of our enclosure, to get this example failing, we need to actually update
our enclosure to hold multiple pieces of security. And then check whether or not
there actually is some security on there.

So quite literally I'm going to take a securities property type in it. With this,
I'll add some documentation to say it's a security array. We're not reading a more
direct example for this first because there might not be any methods on enclosure to
get or see the securities. The best way to test it is actually to basically check to
see if we're allowed to create a dinosaur without any security. And of course we'll
have to go update some of our other, uh, examples earlier once we get this working to
add security so that they don't throw an exception.

Okay,

down in a dinosaur, I'm going to call another new method. So if not, this->is
security active. I don't want to throw in new dinosaurs are running ramp it exception
and I'm going to use that same string we used earlier in our test because we're
actually testing for the exact string. This is a bit of a silly example. I wouldn't
really want to test for that exact a message here, but we can do that if we want to.

Yeah,

I've only met my cursor on the method name. We can type all enter to add that method.
This will return a bull and inside we're just going to loop over the securities
securities as security. So the idea is if there was at least one security object at
attached to this enclosure and its security is active, then our enclosure is secure.
So if security->get is active, then return true and if none of them are active, we'll
return false. Okay, that should work. Let's move our. You can see that to this 41
here, that actually means it's on line 41 of that. Want to rerun it?

It works. Sort of notice line 41 is gone. It looks like the line 41 is actually
passing a front to make sure you can actually, by the way past the filename of a Spec
to run just that one spec and then you can actually do the line number, colon, 41.
Let's go look at Colin 41. There it is, colon, 41 to run, just that one
specification. There you go. You can see one that passed, but if we run all of them,
we have a couple that are failing so it should. It should be able to add dinosaurs is
actually getting. The dinosaurs are running rampant exception and that makes perfect
sense. If we go up, it should be able to have dinosaurs. It's just testing to make
sure. If we had two dinosaurs, then we should have a count two and now it's just
trying to add it to an unsecure I'm enclosure, so this is actually really cool.

We made one change and then our existing example started to fail like that's the
beauty of tests right there and now we can take in all the information about which
tests are failing and why they're failing and determine the best way forward. For
example, we may have just accidentally introduced a bug and we want to fix that bug
or we may discover that the tests that are failing are now not relevant anymore and
are outdated or more likely you're in a situation like this where you just need to
update the tests. The tests are failing, but that's just because, um, we need to add
some security first. These tests are still valid and we want them to keep passing so
some way instead of enclosure, obviously we need there to be a way to add security to
this. The way that I want to do it. I want to make an insecurity simple as possible.
So I'm an add a construct method inside of here. It's public function
underscore,_construct with a boolean with basic security and we'll default to false.
Now notice I didn't write an example for this first. Usually we write an example and
then we often it and we could have done that, but it's actually already.

It's already being tested indirectly. Like obviously

hmm.

The way that. One of the ways that I want to allow security to be added to my
enclosure is via a constructor because I want to make it very easy for you to
initialize an enclosure and immediately add security to it, so actually I just
described new behavior of my enclosure. Enclosure SPEC. We can actually make an
example for this, but instead of making an example that is called something like it
should be able to create an enclosure with basic security. We already have this
existing example. It should be able to add dinosaurs and this is one on one of the
ones that are failing. In order to get this passed. What I want to say is I should be
able to be constructed with

true.

I'm basically saying is I want to be able to pass some true flag that says it
enclosure that it should put basic security on itself. I'm also going to put this
method on the other one that's failing line 32 just now down here, and then for the
new method. I'm wondering, instantiate this with false. I don't want any security on
there. Now, if we run the test right now, it's going to ask us if we want to create
the construct method, which you do. A whole bunch of tasks are still failing, which
is fine inside the enclosure. Perfect. Let's change this argument too with basic
security. I'm going to give it a default value so you don't have to pass anything in
it defaulted to false. Then if this Arrow, if with basic security, then we're going
to add security. I'm going to do that with, I'm going to call a new method I haven't
created yet called add security and we'll say new security and inside of here will
always had a basic security fence, will make an active and we'll pass the enclosure,
which is just this now plus add security method. Right now I'm not using this
anywhere outside of this class, so this would technically be a private function, but
if I already know that I'm eventually going to need the inside of this class, then I
can make it public, so I'm going to do that and I put her at the bottom of my public
functions

at security security type. Hint, this will just be this->securities left square
bracket security. Phew, okay, let's try that. Move over. Run pieces back and ah, not
passing yet. It says class APP, entity security, not found. Let's see, what did I
mess up? It's not clear where that error is. So I'm gonna pass, Dash, dash verbose to
get a bit more information and let's say it's coming on enclosure line at 19. Ah Ha.
And you probably saw me do it. Our SPEC directories and our service directors look so
much alike that I moved it into the rights. Wrong spot. Can we go over and her actual
entity directory. Good job tests. We run those in. Now they pass. So the big
takeaways here are that we are able to test specifically with um, a message here and
by creating this new example about security, it actually exposed some flaws in our
application and expose the fact that in other tests we needed to, uh, actually
instantiate our object and force that security. So by writing these examples, we're
just kind of discovering the design we need for our classes a little by little.

Do you want other enhancement to enclose your Spec? I want to make, and that's that
it's already really easy to, uh, create a spec enclosure with basic security. But I
also want the ability to pass dinosaurs into the constructor, but what I really want
to do is make sure that if we pass dinosaurs to the constructor that doesn't skip our
check for security. So let's create a new function in here called it should fail it,
providing initial dinosaurs without security. We'll say this->be constructed with say
false, but then we'll pass in an array with a new dinosaur. Now the interesting thing
about this is that we actually want the exception. The exception is actually going to
happen during instantiation, not during one of these methods being called like during
ad dinosaur. So this time we're going to start pretty simple, very similar with
should throw this time, I'll just do the dinosaurs are running rampant exemption
::class. We don't care about the message and as you can see here, it's suggested is
we can say during instantiation. And that's it. Now if you run this apps, it will
fail. Of course says that there was no exception thrown, but notice one thing it
doesn't do is this is the first time that we're using deconstructed move with a
second argument. Since the construct meant that already exists, it doesn't offer to
generate a second argument automatically when you need to do that by hand. So say
array initial data source

= arrive. What does the loop over initial dinosaurs as dinosaurs and say, this->add
dinosaur dinosaur, and because ad dinosaur has all the security checks, we should be
good. The bug we're catching here is it would've been very easy for me just to say
this->dinosaurs = initial dinosaurs. In that way there would not be a security check.
Let's move over. Run the test again. Got It.