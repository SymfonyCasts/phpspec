# Dummies

Our new `EnclosureBuilderService` *is* building the security systems and adding
them to the `Enclosure`, but it's *not* creating any dinosaurs yet. That's a boring
dinosaur park! Fortunately, that should be easy! Heck, we *already* have a class
that's really great at doing exactly that! The `DinosaurFactory`.

## To Mock or Not?

So, hmm, thinking about the design of `EnclosureBuilderService`, we now know that
it will need the `DinosaurFactory` in order to create dinosaurs. And *that* means
`EnclosureBuilderService` will need a constructor function so that we can use
dependency injection to pass `DinosaurFactory` into it. Ignore phpspec for a second:
*this* is pure object-oriented coding: if a service like `EnclosureBuilderService`
needs access to another service like `DinosaurFactory`, we will *pass* that service
to it, usually via the constructor.

*That* is the design we'll use for `EnclosureBuilderService`. And of course, that's
something that we can describe in our spec class! So far, we haven't said anything
about how `EnclosureBuilderService` is instantiated, so it's being created with no
arguments. Cool! Now use: `$this->beConstructedWith()` and pass it a `DinosaurFactory`
object. But... how should we create the `DinosaurFactory`? Should we create it manually
or mock it?

## DinosaurFactory Dummy

In this case, mock it. As a rule of thumb, *if* the object you're working with is
a *service* object - an object that does *work*, but doesn't hold much data, like
`DinosaurFactory`, Doctrine's `EntityManager` or a class that sends emails, mock
it. That's because these are usually difficult to instantiate and often have side
effects, like talking to the database or sending real emails. Oof, sending emails
when you run your tests is *no* fun. We want our unit tests to be isolated from
all "real" systems likes that.

But if you're working with a simple model object, it's ok to create it directly.
For example, in `DinosaurFactorySpec`... I mean in `EnclosureSpec`, because `Dinosaur`
is so simple, we just created it ourselves!

*Anyways*, we need to mock `DinosaurFactory` and we already know how: add a
`DinosaurFactory $dinosaurFactory` argument to the method. Thanks to that, prophecy
will create a "dummy" object: one of those many words to describe that this will
be an object that looks and smells like `DinosaurFactory`... but isn't *actually*
a `DinosaurFactory`. Pass *this* to `beConstructedWith()`.

Cool! Let's not do *anything* else yet, just run phpspec and see what it thinks:

```terminal-silent
./vendor/bin/phpspec run
```

Woohoo! It sees that the constructor is not found and asks if we want to generate
it. Of course we do! Go check it out! Change the argument to
`DinosaurFactory $dinosaurFactory` and then... do nothing... yet.

Because... to be all "technical" about it, all we *actually* need to do to get the
test to pass is have an `__construct()` method that takes one `DinosaurFactory`
argument. Try the tests now:

```terminal-silent
./vendor/bin/phpspec run
```

Yep, green! Well, there is *one* failure, it's from line 13. This is the
`it_is_initializable()` example, which is angry because it's *not* passing the
required first argument. Ignore that for now and focus on running just *this*
example, which is on line 18. Re-run spec with:

```terminal
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:18
```

Yep! This example *does* pass.

## Dummy Objects Return Nothing!

Ok: *now* we need to enhance our example to describe the expected behavior for
creating Dinosaurs. Basically, because we're passing "2" as the second argument,
we would expect our `DinosaurFactory` to be called 2 times and for the final
`Enclosure` to have 2 Dinosaurs. But... we haven't coded that yet.
`var_dump($enclosure->getDinosaurs())`. This will be an empty array, right? Try it:

```terminal-silent
./vendor/bin/phpspec run spec/Service/EnclosureBuilderServiceSpec.php:18
```

Ah, we were *mostly* right: it's an instance of the all-important `Subject` object.
But if you look inside, the subject property *is* an empty array. Cool! Things
are working like we expect... so far.

But here's where things get weird... or cool... or something: *even* if we added
the code to `EnclosureBuilderService` to use `DinosaurFactory`  to create the 2
Dinosaurs and add them to the `Enclosure`, the test would still fail! What!????

Why? Because, when you create a "dummy" object like `DinosaurFactory` it's not the
*real* `DinosaurFactory`. And, by default, *all* of its methods return `null` and
do nothing. It's a real... dummy. Right?! So if we *did* write code here to use
`DinosaurFactory` to create the dinosaurs... it wouldn't! It would return `null`
and either the test would fail or, more likely, some code would blow up because
it's expecting a `Dinosaur` object, not null.

Yep, if you *simply* tell prophecy to create a test double, it's referred to as
a "dummy" and... it does nothing. But, there *are* two things that we *can* do
to make it more awesome. Let's talk about the first one next: controlling the
return value when a method is called.
