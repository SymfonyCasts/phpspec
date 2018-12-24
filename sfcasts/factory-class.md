# Factory Class

Coming soon...

So thinking about the design of our `Dinosaur` class, we just have a new requirement
coming down, what were the dinosaur park is super successful and we need to grow more
velociraptors and apparently it's a lot of work to every time to instantiate the
`Dinosaur` object and pass the string in velociraptor and true for is kind of risks. So
I think it's time that we create a factory method static method on this class that's
able to create velociraptors. So actually I just described a new behavior that I want
our class to have, which is that I want there to be a static method called 
`growVelociraptor()`. Now we haven't talked about how to do that yet because so far we've
talked about how you can tell phpspec is in charge of instantiate our objects
and we've learned how to tell it, what arguments to pass to the `__constructor()`, but we
haven't learned yet to tell it how to call a different method in order to instantiate
our object. Let me show you an example. Great new example called 
`it_should_grow_a_large_velociraptor()`.

Okay?

We want to do here is we want this to be a `Dinosaur` object, but we want it to
actually use a new static factory method on our `Dinosaur` class. Instead of phpspec
instantiating it directly do that. We can say `$this->beConstructedThrough('growVelociraptor)`.
That will be the new name of our method and
we're going to pass it at the `array` of arguments with as it does one argument called
`5`. If you had a second argument, you would pass it here like an right, but just
one argument called `5` now because we've done this, this was should be a dentist or
object, but a dentist or object that was created through this new method that we
haven't graded yet. So now we can test them behavior on it. Like we could say, 
`$this->shouldBeAnInstanceOf()` that would be a good thing to check and make sure you back a
`Dinosaur::class` and then we can do whatever their other checks we need. Like I can say
`$this->getGenus()` we can say `->shouldBeAString()`. If you wanted to just do some basic
checks like that or we can say `$this->getGenus()->shouldBe()` and will actually use the
string `Velociraptor`.

Those amazing. `shouldBe()` here I've been using `shouldReturn()`. Those are identical.
They're both the identity match or you can use whichever one you want. Notice also
that `getGenius()` was not auto completing for me and that's because that method doesn't
exist yet. Just see how that looks in a second. Let's also just check that the length
`shouldBe(5)`. That's the. This is going to be the length that we pass in here.
Perfect. So you guys know the drill after writing example, will you run? It's 

```terminal-silent
php vendor/bin/phpspec run
```

of course it fails and of course phpspec is smart enough to say, Hey, it looks like
you need a new `growVelociraptor()` method, so let's say `yes` to creating that and then
it runs it again and it fails with a `BadMethodCallException()` and that's because in
our `Dinosaur` class it doesn't know how to fill this in, so it just fills it in with
me, Cynthia to do notice. Cool thing is that once again, put this method in the
correct place. Static factory methods are usually things you want on top of your
class, below your constructor, so that's pretty sweet, so let's just fill this in.
Say `int $length`, this is going to return an instance of `self`, and here we can say
`$dinosaur = new static()`. Create an instance of herself passing `Velociraptor`,

and then `true` for the is carnivorous argument, almost a `$dinosaur->setLength()`, passing
the `$length`, and finally `return $dinosaur` just like that. We have designed and
created a new method so our tests should run, move over, run it again, 

```terminal-silent
php vendor/bin/phpspec run
```

and they
don't. This is actually awesome. You realize is that we're trying to use a `getGenus()`
method and that doesn't exist. Now, this is interesting because the only place that
we've needed our `getGenus()` method so far is actually in order to in our inside of our
test. This might not even be a method that we need in our actual application. It's up
to you, but I'm going to say that `getGenus()` is a method that I want, so let's generate
that and then fill that in with the information we need. So `return $this->genus` and
I'll also add the `string` return. Type on there

are run it, 

```terminal-silent
php vendor/bin/phpspec run
```

it passes what's up with this factory idea, but make it even a little bit
more complicated. So yes, yes. Today having this new `growVelociraptor()` static method
was great, but we need so many dinosaurs that we need a proper factory class. We need
to create a new dinosaur factory. So far we've been doing lots of cool things.
We've only actually graded one specification and one class. Now we're going to need a
new class called `DinosaurFactory`. So whenever you need a new class that you want to
test with phpspec, first command we're going to run is that described command. This
is where you pass it. The name of the class that we want to create some 
`App/Factory/DinosaurFactory`. 

```terminal
php vendor/bin/phpspec describe App/Factory/DinosaurFactory
```

That namespace can be anything, but I'm saying I want you to
describe that new class class doesn't exist yet, but that's okay. This created our
`DinosaurFactorySpec`

that's

and it's of there. As you might remember, the only thing it says is that this. I've
done this for factories should be an instance of itself, but the class doesn't
actually exist yet, so let's create it by running run 

```terminal-silent
php vendor/bin/phpspec run
```

will generate that for us. And now our specifications pass. So we're going to go through, 
we're going to basically move the `growVelociraptor()` static method into our 
`DinosaurFactory` and we're going to use that red-green refactor cycle to do that. 
So the first thing inside of the specification, let's describe the new method. So we'll say 
`function it_grows_a_large_velociraptor()` and this time we'll say 
`$dinosaur = $this->growVelociraptor(5)`.

We'll pass it 5. So we'll pass the link to it. Now notice this is a little bit
different than what we've been doing. Incentive or dinosaur spec and a `DinosaurSpec`.
We always call them methods, but we don't ever need to assign them to a value that is
her factory is going to be a little bit different because the value, it's not because
it's not actually going to modify anything internally. It's going to return a
different object and this is actually the object that we're going to, um, call are
matchers on to make sure that it's behavior is correct. This is the first time that
we're really testing one class, but we're going to do the assertions actually through
another class that it returns. Let's go ahead and `var_dump()` that `$dinosaur` objects so
we can see kind of how that works. And then we'll run the method. 

```terminal-silent
php vendor/bin/phpspec run
```

It of course asks
us if we want to generate that new `growVelociraptor()` method. We'll see. Yes. And then
you can see the dumped code here. If I scroll all the way up is an instance of that
`Subject` object and the actual subject right now, the actual value is `null`, because if
you look at the new

method inside of `growVelociraptor()`, those generated. It's not returning anything. So
this is very similar to what we saw on our `DinosaurSpec` earlier, which is when we
call like this air get link, this actually returns the length but wrapped inside that
subject object and that allows us to call the assertions on it. Inside 
`DinosaurFactorySpec`, it's the same thing. `growVelociraptor` is ultimately going to return a
`Dinosaur` object, but it wraps it in this subject object and that allows us to call
methods on it or to call assertions on it. So I'm gonna go to my `DinosaurSpec` and
actually steal my four lines of code inside of here. Faces over here and I'll just
change all of the `$this` to `$dinosaur`. Now retape the R and dinosaur and hit tab. So we
can auto complete the use statement on top so we can call it should be an instance of
or if we want we can actually just call it methods on it. `->getGenus()->shouldBeString()`
and that should work just fine. So I've talked about a lot of stuff, but so far all
we've done here for this `DinosaurFactory` is written. The example sure have generated
the method, but the method is empty right now. So this is the red part of the cycle.
We've written an example. 

```terminal-silent
php vendor/bin/phpspec run
```

It is failing. So the next thing we need to do is make this
test pass with as little work as possible. We need to focus on getting into past
without getting fancy.

So I'll actually cheat. I'll go to my dinosaur class. I'm going to keep this 
`growVelociraptor()` method here just as an example, but we won't use it anymore. Then inside
my `DinosaurFactory`, I'll paste that, changed the `new static` to `new Dinosaur`

and then

to make our code a little cleaner, I'll say `int length` and this is going to return a
`Dinosaur`.

Perfect.

```terminal-silent
php vendor/bin/phpspec run
```

And we run that green, red, red part of the cycles done. Green part of the cycle is
done. Then the last thing we can do is if we need to, is actually reflected this. I
try to make this as simple as possible, but we know that we're ultimately going to
need other methods onside on this `DinosaurFactory` class, like grow, um,
tyrannosaurus or something like that. So I'm going actually refactored part of this
into a new `private` function here called `createDinosaur()`. This will take in these
`string $genus`. The `boolean $isCarnivorous` and the `int $length` and we're going to do
inside of here is just do that work a little bit past the, uh, do all the work of
creating that dinosaur object down here. And then above we can just 
`return $this->createDinosaur()`, passing `Velociraptor`, `true`, and then the length 
which is the variable `$length`. So we could have done this initially, but we want to get a test
passing as quickly as possible. Now we can get fancy and re factor in. Some of you
might know what's going to happen here. You might be able to spot the problem. One,
we run it. 

```terminal-silent
php vendor/bin/phpspec run
```

Our refactoring was not innocent. We actually broke things. It says Return
value of `DinosaurFactory::growVelociraptor()` must be an instance of `Dinosaur`. `null`
returned.

Can you spot the issue? PHPstorm can saying, hey, you're trying to return a value
from `createDinosaur()`, but `createDinosaur()` doesn't actually return anything. So that's
great. `return $dinosaur` and add a return. Type on that so we don't make that mistake
again and now it passes, so red-green refactor. There's a reason for that and my
favorite part of the reason is because during the green phase, it really focuses you
on just accomplishing the behavior you need inside of your object without getting
overly fancy. Sometimes we do that as developers. We do too much a fancy flexibility
kind of stuff too early. Save that for later when you actually need it.