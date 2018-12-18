# Install

Coming soon...

That'd people. Welcome to a super fun tutorial we're doing on PHP SPEC. So what is
PHP SPEC? It's a unit testing tool, just like PHP unit weight. That's not totally
right. If you've gone through our php unit tutorial, then you know that is a
perfectly fine tool for unit testing your code. So why PHP SPEC event? Patriot SPEC
is according to its authors, not really a testing tool. It's a tool that helps you
design your code.

It helps you build well organized, meaningful code and yes, by doing that you're
going to get tests, but that's really a byproduct. Features back is about design and
it's about making the design process and the testing process really, really fun. So
how does pht SPEC fit into PHP unit? Do you? Did you use one or the other? And what
about something like that that does functional tests? What? We're going to talk about
all that later, but each of those tools has its own place and you can use all of them
in your own project. The one thing about peace respect is that it's only used for
unit testing, so you won't see anything in this tutorial, but integration testing or
functional testing and things that we do talk about in the PHP unit tutorial. All
right, so to get started, as always, definitely

download the course code from this page and when you unzip it, you'll find a start
directory that has the code that you see here, but actually if there is nothing here
to see, we have basically an empty composed that JSON File and this tutorial
directory contained some code that we'll use later, but that's just going to be
ignored for now. So we have an entirely empty project and that's because PHP SPEC is
truly framework agnostic. Now we're going to use a structure. We're going to build
our classes and our namespaces and a structure that's familiar to Symfony, but it
really makes no difference at all. So step one of course is going to be composed,
require peachtree spec /Ph respect dash dash dev to get it installed as a dev
dependency.

Just like with PHP unit. The end result of this is that you have an executable vendor
been PHP Spec with recently actually two commands. Describe and run, both of which
we'll talk about very soon. Now to get pictures back working. You just need that tiny
bit of configuration and actually the first bit of configuration we're going to do
has nothing to do with PHP Spec in this project. We have no php classes yet, but we
are eventually going to put our PHP classes into a source directory just like a
Symfony project and every class and there is going to start with an APP namespace, so
composed that JSON, in order for composer to be able to locate those files, we need
to add a little bit of auto load code. This code that you normally get automatically
if you start, for example, a new Symfony project, but I wanted to show how it's done
by hand so that we can really truly see what's going on behind the scenes. So we're
going to say that the APP name is basically found in the source directory. Just by
doing that. Auto loading will now work on our project to make it take effect, running
composer dumped dash out load

and now composers sees those rules. Again, that's not something you normally need to
worry about because it's done for you, but this is something that you'll find in your
project. Now, one of the really cool things about the SPEC is that it's going to
generate code for us. And to do that it needs to know that our classes are going to
live in the source directory and that they are going to start with the APP namespace
so I configure out exactly which, um, the location of each class to help him with
that, we need to create a Spec .yaml file at the root of the project. And here we're
just going to say sweets default. So like most test tools are going to have multiple
suites if you want. We'll just have one in this tutorial and I hear we're gonna say
namespace app because all of our classes are going to start with the APP name
namespace. That psr for_prefix APP general. It looks a little bit weird, but those
are the two lines that are going to help it locate our classes that follow these
autoloading rules and would that we're ready. Next, let's create our first
specification. The file will use to describe what our code looks like. Oh, by the
way, what we're going to be working on, of course, we're going to be able to building
dinosaurs, enclosures and security because nothing needs security more than a
dinosaur park.