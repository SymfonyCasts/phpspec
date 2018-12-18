# Specification

Coming soon...

So if Petri Spec is all about helping you design your classes, like thinking about
how do I want this class to look and behave, how does it do that? Well, the idea is
instead of just jumping into your code and creating methods and creating properties,
you should step back first and actually describe how you want, how you want your
class to behave. We do that by creating a class called a specification, which is a
fancy word to say. We're going to have one class that actually where we describe how
we want each class in our project to work

and we can generate that specification class or running vendor been dis a PHP SPEC.
Describe for someone to pass passes with a dash h so you can see the options.
Basically we're going to pass. Describe them. We're going to pass it the name of the
class that we want to describe. Notice here that um, because back slashes are escape
characters we use forward slashes in the name of space just to avoid any problems or
you can quote it down here. Alright. So in our project, the first thing we need for
our dinosaur park is we need a dinosaur class, so I'm going to run vin vendor, been
peace, respect to scribe, and I'm going to say app /city /dinosaur. The namespace of
this is not important. I'm mimicking something you would see if you're using doctrine
inside of Symfony, but that's not important at all. Awesome. And this one new file
dinosaur SPEC. So let's go check that out. So as you can see, peaches back creates a
SPEC directory and it which basically will eventually match the directory structure
of our source directory. And is there. We've done sort of SPEC.

Yeah.

Which has the same namespaces are our future dinosaur class because because we
haven't even created this class yet except for a SPEC namespace. No. First Time you
look at one of these SPEC classes, they look very strange and we're going to spend a
lot of time talking about how they're set up. Remember, the point of this class is
for us to describe the behavior of how we want our dinosaur class to work and we're
going to do that through things called examples, and what that literally means is
every single function inside of here that starts with_or it's underscore, is going to
be seen by phds back as an example, and a place where we show examples of how we want
our dinosaur to work and it's already generated. This one example for us now what's
truly strange but amazing about these classes is the base class object behavior
because object allows us, gives us some magic honestly, and it allows us inside of
our example functions to treat the this variable as if it was a dinosaur object.
You're going to see this in a little bit. We're literally going to call methods on
this that exist in our dinosaur class.

We're literally going to write example code as if we were inside of the dinosaur
class itself. You can see there's one example here. Also uses something called eight
matcher. We're going to talk about these two as well. This is actually an assertion,
so we're saying here is our dinosaur object because that's what we need to pretend
this is should have a type of dinosaur ::class. So should I. What type of APP /entity
/dinosaur course that class doesn't even exist yet,

but it will soon. So this is just a very simple smoke test. Now, what other weird
thing about these uh, example functions as they break coding standards a bit. You
notice there's no public in front of this and instead of using camel case, it uses
this, the_of course, and then everything, everything after that uses underscores. And
whole reason of that is just readability. We want these methods to read like a to be
very easy to read so you can very quickly read the functions and figure out how your
class is supposed to work. So this is a very, very simple specification which says
nothing more than a dinosaur object should be a dinosaur object.

So we've already seen. So peach respect only has two commands. We've already seen.
One of them described, the other one is run once again past this eight dash h option
just so you can see that there are a number of options you can pass to it, but we're
not going to talk about them right now. We're going to run run and what this is going
to do is it's going to go look at all of our spec files, which is only just one. Go
through all the example of codes and make sure that the objects behind them actually
behave. How we're describing them might think that's crazy because we don't even have
a dinosaur class yet. There is nothing in our source directory, so let's see what
happens. At first it does fails as class APP entity dinosaur or does not exist.
That's expected, but check this out. It's like, do you want me to create it for you?
This is what makes peachtree Spec so fun. If it sees that you've described some
behavior that's missing, like the whole class is missing, it can create it for you,
so let's choose. Yes, it created that class

in source and there it is. That's the only, we haven't described it to behavior on it
yet, we've just described it. We need that class and now you can see that our specs
pass. We run the run again. It passes. All right, so next let's dive into the Spec
last and actually start creating some more meaningful examples of how our classes
work and see how the cycle works to get those to build that code with Peachtree Spec.