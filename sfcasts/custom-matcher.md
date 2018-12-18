# Custom Matcher

Coming soon...

The only downside to these inline matchers is you can't reuse them across multiple
spec files, so PHP Spec of course has a way for you to create these matches in
separate files and actually there's some really great examples out there.

For example,

I don't know how to say this person's username, but here's a php spec master
repository, which is literally just a bunch of measures that you can take inspiration
from. This is technically a php extension, which is a PHP plugin. Unfortunately, this
repository does not work with the latest version on Peachtree Spec of its time, but
it still might be a great example of, um, of matters that you can look at and use
inside of your project because right now we do need a great one more customer metric
because we have a bug report. Of course, the best thing to do when you get a bug
report is to write a test for it or in our case, to describe the correct behavior and
then make sure it works that way. People have been reporting that want a dinosaur is
a length of 15 that sometimes it shrinks. We've talked to our scientists and some
shrinking is okay, but they should definitely not shrink below a length of 12. Turns
out dinosaur sciences complicated plus get a new example of caught. It should not
shrink. We'll set the length on our dinosaur to 15. Notice I'm getting auto
completion on that. Now that that method really exists and that will say this->get
link, but we don't know the exact value because it's okay if it shrinks a little bit.
So I'm going to use a new matcha that does not exist called should be greater than

twelfth.

Now, of course, if we run this right now, it's going to fail. I pass.

Okay.

For this APP, it passes. Oh, because I have a typo. It can see the importance of
having the_on there. Now run it perfect. It fails because the metro was not found.
Now we know that we can just create an inline matcha for this, but this is sounds
like actually a pretty useful mattress. So I'm going to create a new custom class so
it doesn't matter where this goes, but in my spec directory I'm going to create a
match your directory and inside there a new php class called be greater matcher. And
the namespace for this should be spec /the directory path. So spec /manager,

I'm not gonna put any logic in here yet, but I first want to just make sure that PHP
Spec sees our new matcher. Now the way to do that is in your Petri Spec, .yaml file
inside of there you can add a mattress section. And then very simple, you just put a
list of your mattress. So spec /metro /be greater matcher. That's it. Alright. So
what word yet? But let's try it for one it again. Oh, interesting. I get custom
matcher Spec matcher be greater match. It does not exist. This is basically a class
not found error by copy. The namespace. Yeah, that looks correct. So the question is
what's the problem? Well, the problem is that in our composer.json File, we've
configured composer to be able to auto load things from the source directory, but we
haven't configured it to be able to auto things from our SPEC directory.

Now, peach respect doesn't need autoloading to exist in a in order to actually find
the SPEC files, it finds and handles all the SPEC files itself, but if you want to
put any other classes in there like a matcher, then you're going to need some auto
rules to find those just fine because it's is very simple. We'll just copy that load,
make a new one called autoload Dash Dev because we only need these auto load rules
while we're developing and will say that the SPEC namespace lives in the Spec
directory and that's it. Move back over run composer, dump dash auto load so that it
reads those rules. Now run it again. Perfect. This is a better thing. It's Caesar, be
great, your matcher, but it says that it must implement a matcher interface. Not
surprising that we need to implement an interface to make this work and actually we
can see a couple of great examples of this in your vendor directory. PHP SPEC, PHP
SPEC source, speech respect.

Yeah.

Magic directory. You can actually see all of the core matches in here, which is a
great way to grab inspiration. For example, if you look in the throw matcher. Yup.
You can see it's implementing this match or interface.

Yeah,

but another example of it's a little bit simpler is actually the identity matcher and
does that instead of implementing the matcher interface, that actually extends a
basic matcher which handles a lot of the work for you and implements matcher and it
does a lot of the low level details for you, so most of the time you want to extend
this basic metric because it makes your life a little bit easier. So let's close
those files up, close off a few other files and then we'll make our be greater metro
extend basic matcher, mostly gonna. Make the class a final. There's no reason for
that. Just kind of a a better practice these days and if you don't need a sub class
one of your classes and then I'm going to go to the code, generate menu or command
end, go to "Implement Methods" and implement all four of the methods that we need to
implement. Perfect. Now the most important one here is supports. Let's Var dump the
arguments here, name, subject and arguments. Whenever a matcher is used inside of a
specification, peachtree SPEC is going to iterate over all of the mattress and call
supports to figure out which of the matches to use.

So now if we run this as you can see it dumping out actually every single time so it
dumps out for have type return zero and down here for be greater than. That's the
name. The subject is 15 because in our SPEC class, get length is returning 15 and
then that's what's going to be passed to this matcher. And then finally for
arguments, there's an array with only one thing in there which is twelfth because
we're passing 12 here as our arguments. So you can make this really in the supports
method. All we need to do is make sure that the method name, the name is be greater
than the lot of times when you know core, you'll see these be written a little bit
more specifically. So in our case we could, for example, say that you can use be
greater than be greater or be greater than. And then if you want, you can even make
the specific types of the subject and arguments match. So we'll say and and his new
new numeric subject. So if you pass a string it won't match this and we'll make sure
that the arguments are exactly one, just one argument and that

that one argument itself is numeric. So it shouldn't now match our matcher and if it
does then it's going to call our matches function. Once Var dump this subject in the
arguments one more time. This time we'll put a dye statement so we can see it's
called move back over and run it. And yes, we've got it. With the 15 being passed as
the subject and then the arguments being that array with that 12 inside of there and
we now know there will be exactly one argument always because of our code down and
supports very simply we can return subject are 15, should be greater than arguments,
lasker brackets zero, and that's it for the matches part. Now if this fails where
they're going to call, either get failure exception or get negative failure exception
to get negative failure. Exception is if you use something like should not be greater

for these, I'm going to just paste in the failure exception. We're going to return a
new failure exception, which is the same type of thing that we were throwing from our
inline matcher, which just has a custom message expected the subject regretted than
the argument and for the negative one I'm going to copy that and it's going to be the
exact same thing except it's going to be expected this to not be great event and that
is a fully functional customer match which allows us to use very natural language
inside of our space inside of our examples. All right, so let's run that one more
time and it passes. Next we need to talk a little bit about how peach respects fits
into the entire world of testing. You need to do that before we dive further. For
example, there is functional tests, integration tests, and unit tests, and also
multiple tools like php unit and be hat the handle those. So let's dive in and figure
out exactly how this fits in.