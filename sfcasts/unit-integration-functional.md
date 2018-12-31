# phpspec? PHPUnit? BDD? TDD? Buzzwords?

We need to talk about just a *little* bit of theory. Come back! It's important!
No, don't keep running! Um, it's *interesting* theory... and we'll do something
fun at the end - I promise.

## Functional, Integration & Unit Tests

In the world of testing, there are *three* types and we covered each of these in
our PHPUnit tutorial. The first type - unit tests - is when you're testing the
code directly - you literally call methods like `setLength()` and `getLength()`
on objects and assert that the values you get back are correct. The *key* thing
in unit testing is that, if your object depends on another object - like a database
connection, or a mailer object - you *mock* those dependencies, instead of using
the real object. We'll do exactly this later in the tutorial. Unit tests are the
"pure" tests: you're testing the input and output of a method in complete isolation.

The second type of tests are called integration tests. They look and smell a lot
like unit tests: you work directly with objects, call methods on them, and make
sure you get back what you expect - exactly like unit tests. The *key* difference
how *dependencies* are treated. Instead of, for example, "mocking" a database
connection object that the class you're testing needs, you use the *real* database
connection! And, yea, that means that you *actually* make database queries!

Integration tests are *super* useful when you have a lot of pieces working together
and want to make sure the whole *system* "integrates" correctly. Or if you're
making a complex database query and want to make sure you get back what you expect.

The *third* type of tests are functional tests. In a functional test, instead of
calling methods directly on an object, you write code that commands a browser to
literally go to a page, click on a link, fill out a form, and assert some text showed
up on the next page. Or, if you're testing an API, you would literally make API
requests to your API and assert that the JSON you got back was correct. In a
functional test, you're basically *using* your application as if you were an end
user.

So... which tests should you write? Probably... all of them! Sometimes the "scary"
or "complex" behavior you want to test lives entirely inside a single class - and
a unit test works *awesome*. Other times integration tests are perfect to check
what a function does, but with all the *real* pieces in place, and a *lot* of the
time, at least for us on SymfonyCasts, we want to make sure the user experience
is exactly what we want. We verify that with functional tests.

## PHPUnit, Behat, phpspec?

So... which tools should we use? Well, PHPUnit can be used to do all *three* types.
Behat - a awesome library we talk about in [another tutorial](https://symfonycasts.com/screencast/behat) -
can *only* be used for functional tests. And... what about phpspec? Well, it can
*only* do *unit* tests.

So... wait - if PHPUnit can be used for *any* test... and these other tools are
more limited... why the heck are we even talking about them?

Very simply: because tools like Behat and phpspec do a *better* job for the types
of tests they focus on. Well, ok, that's *totally* subjective - but let me explain
a bit more. Instead of "just writing tests and getting them to pass", both Behat
& phpspec help you focus on the *quality* of your app. Behat forces you to think
about the *external* quality of your app - by focusing you on the experience of
your users *first* and coding second. That's the *key* difference between writing
functional tests in Behat versus PHPunit.

phpspec is the exact same for unit tests. Instead of just writing tests and getting
them to pass, phpspec says makes you think about the *design*, behavior and *purpose*
of your PHP classes first. And as a nice by-product, you get unit tests.

## TDD vs BDD

Ok cool. So then... how does all of this fit in with TDD - test driven development
versus BDD - *behavior* driven development. First, both of these aim to accomplish
the same thing: creating high-quality applications. The difference is the
*language* used and the *focus*. With test-driven development, you are *literally*
supposed to write the tests first, and *then* write the code. With behavior-driven
development, the process is *technically* the same. But instead of thinking:

> Let's figure out what tests I need to write!

you think about the *behavior* that you want your app to have. phpspec is a tool
that promotes *behavior* driven development because it forces us to think about
the behavior that we want our class to have - not the test - we get that by accident.

Oh, and by the way, Behat is *another* tool that promotes BDD. The difference is
that Behat is used for functional tests. Behat is "story" BDD: you write "user stories"
that describe behavior. phpspec is "spec" BDD: you write specifications for your
classes. This stuff isn't *that* important - but now, you are *fully* ready to
use all of these words at your next party. You are going to be *so* popular.

The point is this: a tool like phpspec doesn't technically give you anything that
you can't do in PHPUnit. But it changes your focus to be the *design* of your
classes instead of just writing the tests.

Next: let's talk a little bit about the super-rewarding red-green-refactor story
and then... put a dinosaur in our terminal. You'll see.