# When Existing Tests Break & Exceptions in __construct()

The new example we just added *is* passing... but now some of our existing examples
are broken! For example, `it should be able to add dinosaurs` is getting the
`DinosaursAreRunningRampantException` and that makes sense. Find
`it_should_be_able_to_add_dinosaurs`. It's testing to make sure that if we add two
dinosaurs, then we should have... 2 dinosaurs.

## Existing Tests Broke... now what?

So, we made a change to our app and then an existing example started to fail. That's
the beauty of tests! Now we can take in all the information about which tests are
failing and why they're failing to determine the best way forward. For example,
we may have just accidentally introduced a bug and we want to fix that bug. Or
we may discover that the tests that are failing are no longer relevant and should
be removed. Or, most likely you're in a situation like this one: where you simply
need to update existing tests for some new change.

## Describing adding Security

In this case, the enclosure needs some security before we can add some dinosaurs.
To do that, well, we need actually need some way to add `Security` to an `Enclosure`.
And, ya know what? We should probably make it pretty easy to add security - maybe
with a new constructor arg.

Let me show you want I mean - in an example! Instead of creating a totally new
example for this, I'll need to use this new functionality in the example that's
current failing. Here's the idea: to add some basic security, say
`$this->beConstructedWith(true)`. Yep, I want there to be a constructor arg that
easily allows you to activate *some* type of security.

Let's also add this to the other example that's failing - it's around line 32. Paste!
And for the newest example we've been working on, I'll instantiate with `false`.

Ok, let's try the test:

```terminal-silent
./vendor/bin/phpspec run
``` 

Nice! It asks us to generate the `__construct` method - yes please! A whole bunch
of examples are failing - but that's fine for now. Go find `Enclosure`. Perfect!

Change the argument to `bool $withBasicSecurity` and... I don't need to, but let's
give this a default value: if you pass nothing, there is no security. Next,
`if ($withBasicSecurity)`, let's add some security! Let's call a new method we
haven't created yet: `$this->addSecurity()` with `new Security()` passing that
fence... or I guess fency, whatever that is... `true` to make it active and `$this`
because it will be attached to *this* `Enclosure.`

For the `addSecurity()` method, because we're not using this method anywhere outside
of this class, we should technically create it as private. But, I already know that
I *will* need to use it outside this class, so let's make it public:
`public function addSecurity(Security $security)` security type. Inside,
`$this->securities[] = $security`.

Phew! Okay, find your terminal and let's try this!

```terminal-silent
./vendor/bin/phpspec run
``` 

Hmm, not passing yet:

> Class `App\Entity\Security` not found.

Let's see, what did I mess up? It's not clear where that error is. To get more info, use
the `--verbose` flag:

```terminal-silent
./vendor/bin/phpspec run --verbose
``` 

And... ah! There it is: `Enclosure` line at 19. Find that and... ah! Our `spec/`
and `src/` directories look *so* much alike that I copy the `Security` class into
the wrong spot! Move that into `src/Entity` - good job tests!

Run 'em again:

```terminal-silent
./vendor/bin/phpspec run
``` 

*Now* they pass.

## Exception during Construction???

We're on a roll! Shall we add one more enhancement to `Enclosure`? It's now easy
to create an `Enclosure` with basic security. But I *also* want the ability to
pass some initial dinosaurs into the constructor. That's cool - but another programmer
tried to do this last week and... things got ugly. They *did* allow for initial
dinosaurs to be added, but they *forgot* to check *first* to see if any security
was added. Oof. Anyways, that programmer is... on holiday.

Let's not make the same mistake: create a new example function:
`it_should_fail_if_providing_initial_dinosaurs_without_security()`. Start with
`$this->beConstructedWith(false)` and then an array with one `new Dinosaur()`.

Then, we just need to tell phpspec what method will cause the exception. So...
wait! This is a bit different: the exception will be thrown during instantiation!
Not when we call some other method.

How can we tell phpspec about that? It's *almost* the same: `$this->shouldThrow()`
with `DinosaursAreRunningRampantExemption::class` - I don't care about testing
the exact message. Then, `->duringInstantiation()`.

That's it. Let's make sure things are failing!

```terminal-silent
./vendor/bin/phpspec run
```

Nice and broken: there was no exception thrown. Oh, but notice on thing: this is
the first time that we've added an example where we are passing a *second* argument
to the constructor. But, because that method already exists, phpspec is not *quite*
smart enough to automatically generate a second argument for us. Ok, then, I
*guess* we'll do it by hand: add `array $initialDinosaurs = []`.

Next, foreach over `$initialDinosaurs as $dinosaurs` and say, 
`this->addDinosaur($dinosaur)`. *That* was the mistake that *other* programmer made:
I'm using `addDinosaur()` instead of just setting the `$dinosaurs` property directly
because *this* contains the security checks.

So... that should be it! Let's try phpspec:

```terminal-silent
./vendor/bin/phpspec run
``` 

Got it. Next... it's time! It's time to talk about mocking, test doubles and all
that fun, testing magic.
