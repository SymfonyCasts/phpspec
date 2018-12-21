# Unit Integration Functional

Coming soon...

We need to talk about just a little bit of theory and then I promise at the end we're
going to do something fun.

We need to talk about how phpspec fits into testing your application in
general. First of all, one of the things I like to remind people is that you're
always testing. It's just a matter of manual versus automatic and in the world of
automatic testing, there are three types, and this is something that we also talk
about inner PHPunit tutorial. The first type is unit tests and that's when you're
testing the code itself. phpspec like you're calling literally calling methods like
`setLength()`, `getLength()`, and you're asserting the values. The key thing in unit
tests is that you were, if your object has dependencies, like it depends on a
database connection. Those dependencies are mocked. This is something that we're
going to see later in this tutorial, so unit tests are the pure tests. The second
type of tests are called integration tests. They look a lot like unit tests.

You were actually working with objects and calling methods on them. The key
difference is that your dependencies, like your database connection art not mocked,
if you call a method that a makes a query to the database, you actually make a query
to the database. In integration tests are very useful when you have a lot of pieces
working together or you're making a complex query and so mocking independencies
doesn't make sense. The third type of tests are functional tests and this is where
you were literally writing code that commands a browser to go to a page and click a
link and fill out a form and assert something on the next page. Or if you're testing
an API, you're literally writing code that makes API requests to your application and
asserts the output, so you're basically using your application as an end user. Now,
PHPunit can do all of the tests. They can do unit tests, integration tests, and
functional tests.

Now too

now behat, which is another awesome library that we talk about in a different
tutorial. It can only do functional tests in phpspec can only do unit tests, so you
might be wondering why don't we just use PHPunit for everything since it's clearly a
very flexible tool and the answer is that

tools like behat in phpspec, they do a much better job for their specific parts
because behat in phpspec, help you focus not on just just writing tests and
getting them to pass, but about focusing on quality, so behat a tool that helps you
focus on what you say, external quality. Basically making sure that the user
experience, the experience every users is correct. When they click on links, they get
the expected results and it makes you think about the experience for your users first
and tests secondarily. That's the key difference between writing functional tests in
behat versus PHPunit. Were you just more focused on the tests themselves? phpspec
is the exact same way for unit tests. Instead of just like writing tests and getting
them to pass PHP back and makes you think about the design of your classes first and
then as a product you get unit tests in the background. So along the same lines,
another thing you're going to hear a lot about is TDD Test Driven Development versus
BDD Behavior Driven Development. Both of these are trying to accomplish the same
thing, which is that you have a high quality application that's covered with tests.
However, the difference is the language and the focus. With test driven development,
you are literally supposed to write the tests first, then write the code. With
behavior driven development, the process is going to be the same,

but instead of just thinking about the tests, you were going to think about how you
want your application but designed. So phpspec is actually an example of behavior
driven development because we're thinking about the behavior of our app of our class,
not the test, but how they should actually behave. And from that we get our tests. So
in the BDD world, you'll hear even two types, which is story BDD, which is actually
what behat gives you and Spec BDD, which is what you see in phpspec, so I'm telling
you all this because it can be a little bit confusing with all these different moving
pieces, but the end result is this tool like phpspec doesn't technically give
you anything that you can't do in phpunit, but it changes your focus on the design
of your classes instead of just writing the tasks, which can be not only a better
experience as you read in the task, but I can give you better design.

One of the other things that you're going to hear about, and we'll actually see it in
this tutorial, is the red green refactor cycle. This is something that is sort of
famous to test driven development and that is that you first write a failing test
before you do anything else and make sure that that test is failing. That's the red
part of the cycle. Then second, you're supposed to write just enough code to get that
test pass. That's the green part of the cycle and the key thing here is you're
supposed to write just enough code to get your test to pass instead of focusing on
complex solutions which you don't actually need yet, so right the test, get it
failing, read right, just enough code to get it to pass. That's the green, and then
once your code is green, then you're free to refactor. The great thing about this
cycle is it gives you permission on the second step to write bad code and have
duplication. Point is just to get your test passing and then once they're passing,
you can refactor confidently knowing that you're not going to break anything. Okay,
but ultimately guys, these are just recommendations. There's a lot of kind of
philosophy and best practices being thrown around. At the end of the day,

you need to do whatever's best for you and just writing any tests in your application
is going to make your application more robust and better, and yes, you can use tdd or
bdd and you can write your tests and then write your code, but honestly, sometimes I
did the opposite. Sometimes I'll write the code first and then I'll write the tests.
Do whatever works best for you. In this tutorial, we're going to walk through kind of
the best way to do it, but ultimately just be pragmatic and do what works for you.
All right. As promised before I move on, we're gonna do one fun thing which is
actually looking at the different format which is formatting the output of peace,
respect a little differently so we know we can run it with saying run. 

```terminal-silent
php vendor/bin/phpspec run
```

Awesome. You can also pass a format option which has a number of different values, 
but one of the best ones is pretty cool. 

```terminal-silent
php vendor/bin/phpspec run --format=pretty
```

Since these check marks are super hipster, let's make
peace, respect. Use them always by going to our `phpspec.yaml` and say
`formatter.name: pretty`. As soon as we do that, 

```terminal-silent
php vendor/bin/phpspec run
```

we always get that pretty output,
which is nice, but since this is a dinosaur tutorial, what I really need

is a dinosaur telling me that my tests are passing. So Beatrice, Zach has a totally
silly repository called `nyan-formatters`, which we are going to install a copy of the
name of the library we're on 

```terminal
composer require phpspec/nyan-formatters:dev-master --dev
```

It doesn't actually have a
proper release yet that's compatible with the latest version of phpspec, which
is fine. It's just a nice little format or or waiting for that. We'll go over and
copy this extensions code. So I mentioned earlier, extensions are the plugin system.
In Php unit, they can give you matchers, they can give you custom formatters and the
way that you activate them is in your `phpspec.yaml` file we had. This
`extensions:` key and then the class name for the extension and that's enough to it.
Flip back over. Okay, perfect. This finished installing and now this gives us a new
formatter called Nyan, a couple of new farmers, but we use one called `nyan.dino`
com. Susie do that, do the run command again in 

```terminal-silent
php vendor/bin/phpspec run
```

there. Is there a dinosaur and is
there a test? Get a little longer. We'll enjoy it more because he's actually
animated. Alright, so a little theory, a little silliness. Next, let's get back to
work and talk about the very kind of magical object your class which lets us treat
this like the dinosaur object and how we can start to control how that behaves a bit
more.