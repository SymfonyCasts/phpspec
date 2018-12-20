# Installing phpspec

Yo friends! Oh, SO glad you've made it for our phpspec tutorial! You will *not*
regret it. Thing number one to know about phpspec is: it's... just... fun!

Ok, but what *is* phpspec? It's a unit testing tool... exactly like `phpunit`.
Wait... that's not totally right. If you watched our [PHPUnit tutorial](https://symfonycasts.com/screencast/phpunit),
then you know that PHPUnit is a perfectly fine tool for unit testing your code. So...
why are we even talking about phpspec?

Here's the truth: yes, phpspec *is* a tool for unit testing your code. But, that's
*not* its main job. Nope, it's a tool for helping you *design* your code in a
well-organized, meaningful and maintainable way. You probably already think about
the design and user experience of your front-end. But, have you ever thought about
the design and experience of your PHP classes?

That's phpspec's job. And yes, as a nice by-product, you *will* get unit tests. And
as a *nicer* by-product, you will also *enjoy* the process - coding with phpspec
is fun. Oh, and later - we'll talk about how phpspec & PHPUnit fit together - like
should we use *both* in the same app? Short answer: yes!

## Starting Point: Empty Project!

Ok, let's go! Just like in our PHPUnit tutorial, we're going to design & build a
dinosaur park - complete with T-Rex, stegosaurus, enclosures for our dinosaurs *and*,
with any lucky, some security systems that - thanks to our tests - won't fail as
soon as a storm rolls in or a developer leaves early for lunch.

To make sure our dinosaurs don't *once* again rule the Earth, you should *totally*
code along with me. Download the course code from this page. When you unzip it,
you'll find a `start/` directory with the same code that you see here. But...
well... what we have here is... nothing! Just an empty project with a `composer.json`
file that also... has nothing important inside. This `tutorial` directory *does*
have a few files that we'll use later - so make sure you have it.

We're starting with an empty project because phpspec is *truly* a framework-agnostic
library. But don't worry - if you're a Symfony user, we'll build a structure
that will be very familiar to you - with the same directories and namespaces as
a Symfony app.

## Installing phpspec

To get phpspec installed, open a terminal, move into the project, close Facebook,
and run:

```terminal
composer require phpspec/phpspec --dev
```

And.... ding! Just like with PHPUnit, installing phpspec means that you get a new,
shiny executable! Run:

```terminal
./vendor/bin/phpspec
```

The `phpspec` executable really only has two commands: `describe` and `run`. And
we'll talk about both of them very soon.

## Configuration autoload in composer.json

But first, we need just a *little* bit of configuration to get things working. The
first piece of configuration... has *nothing* to do with phpspec at all! Our app
has *no* PHP classes yet. But when we add some, I want to put them in the `src/`
directory and prefix each namespace with `App`. That will be exactly like a Symfony
project.

Open `composer.json`. To make sure Composer's autoloader knows where our classes
live, we need to add some config here. This is code that you *normally* get automatically
when you start, for example, a new Symfony project. But I want to show how it's done
by hand so that we can *truly* understand what's going on behind the scenes.

Add `autoload`, then `psr-4`, then say that classes starting with `App\\` will live
in the `src/` directory. To make Composer notice this change, find your terminal
and run:

```terminal
composer dump-autoload
```

Autoloading... done!

## Configuring phpspec

Next, one of my *favorite* things about phpspec is that it generates code for you!
But to do that, it *also* needs to know that our classes will live in the `src/`
directory and that each namespace will start with `App`. Unfortunately, phpspec
can't automatically get all this info from `composer.json`, but it's no problem.

Create a `phpspec.yaml` file at the root of the project - `phpspec` automatically
knows to look for this. Inside add `suites` then `default`. Like most testing tools,
you can organize your tests into multiple groups, or "suites" if you want. In this
tutorial, we'll stick to using the one, "default" suite.

Under this, add `namespace: App` - because all of our classes will start with the
`App` namespace - and `psr4_prefix: App`. Those two lines are enough to help
phpspec know *where* to generate our files.

And... team, we're ready to go! Next, let's create our first *specification*...
ooOOOOooo. That's the file where we will *describe* how a single class should behave
by writing *examples*. Woh.
