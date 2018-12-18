# Arguments

Coming soon...

In our specification, we said that when we call,

okay,

bill enclosure, we expect the Grove, Alaska Rafter be calling a dinosaur factory with
the exact argument five. That's just how we decided that we want our dancer factory
to work and one is called with five we'd sat and we're going to return one the first
time in to the second time that it's called. So what if we had a different situation?
Let's breathe. Let's go into our service. Let's pretend that we wanted to make this a
bit more dynamic. It's going to be five plus five, so five, then six and seven and
eight. So what's going to happen here? Because we've said that we want grow. We're
using five still in our specification.

Okay,

whoever.

Yeah,

it'll run our SPEC. It fails. Check this out. It says that unexpected method call on
dinosaur factory, golden grove, alastor after six. Expected was borough veloster
after five, so it actually causes a failure. This is a really important thing. It's
when you call, we'll return. This is called a promise. You're actually making a
promise that the grove velociraptor method will return.

Wow.

This dido one value and then this data or to value. As soon as you apply one promise
to one method on a, on a dummy object, you must apply promises to every single call.
So in other words, if we call grow velociraptor with anything other than an argument
of five, it's actually going to fail. So how do we fix this? Well, the answer is
there's tons of different ways to fix this depending on your situation. The easiest
one is to use a special argument class from prophecy and pass it any if you move or
run out and run it. It works. This says when growth velociraptor is called with any
argument, then returned at one and then returned banner to and so now every single
time we called girl velociraptor, it matches this statement. So there are a number of
other things you can do. Any is the easiest. If you really don't care, then you can
use any. By the way, if you had a second argument to grow velociraptor, you would
just pass, for example, another argument like this, or

you could even do if you had many arguments, you could say Cetera, that would match
second, third, fourth, all the rest of the arguments anyways. If you want to be
little bit more specific, we can use one called type, so for example, we can say type
integer, so now any, anytime that grove last record is called and the argument is an
Integer, it will match this statement and it will return these values.

So if we run that, no surprise, that works as well, but if we change this to string
and run it as we get unexpected method, call five. We expect that a string. So when
you pass it with five here, it doesn't match any of our method calls and this becomes
an unexpected call. It says, Hey, somebody is calling grove velociraptor a method
call with an argument that you didn't expect. The most flexible one of these is
called that. I won't show an example, but you actually pass us a call back and then
you can do whatever custom check you need to do to make sure that the actual argument
passed to you is something that you expected.

Yeah,

so let's change this back to type integer and here's where things get really
interesting. We know that grow velociraptor is going to be called two times, and so
we can actually set up two separate promises for this. Check this out. I'm going to
copy the beginning of this below here. I'm going to call grove last rep again within
number five and say we'll return and pass it dyno. Tune up here. I'm just gonna. Pass
them diner one. Now let's think about what this means. What I'm saying is when Grove
Alaska Raptor is called with exactly the number five argument returned dynamo too
appear. I'm saying if grove after is called with any integer argument, I want to
return dyno one. You might be wondering, okay, so when we actually called grow
velociraptor with the number five, is it going to return diner? One is they're going
to return down to does the order matter, like how does this work? Well, let's find
out if we run it, it fails. Expected dinosaur but got dinosaur that's not very
helpful. So let's run it with Dash V. Ah,

now you can see that online. Thirty eight. So on the first dinosaur we're checking it
expect we expected it to be our big stegosaurus, but it was actually our babies
stegosaurus. So this is really cool. Whenever we call grow velociraptor, it looks at,
at all of these different method expectations and finds the most specific one. So for
the case of five at see's this five here at cs, that five is also an integer, but
because this is more specific than just saying any integer, it matches this second
promise and it returns dyno too. So the first time we go through the loop here, five
is the argument and we returned to the second time. Six has past 60 is not the same
as five, but it does match the second promise. So returns dyno one. In other words,
donald to is now the first item in diner. One is now the second item, so run that
again. I'll take the Dash v off and this time it passes. It's a little bit hard to
wrap your mind around to prove it. We can actually reorder these two promises and
it's going to work exactly the same. The order doesn't matter. Is that every single
time and method is called. It's going to try to find one of these method prophecies.
It's going to find the correct one to find and then return that value.

All right, so let's change this back to one. We don't really need to be this
specific, so I'm going to change this back through just one in integer return diner
one the first time or returning data to the second time and we'll update our asserts
back to the original value down here. Perfect. So arguments are a great way for you
to very specifically control what values or return based on the input and also to
make sure that your methods are being called with the exact right arguments. All
right, next let's start talking about not adding behavior, but about adding
expectations to our dummy objects. For our test doubles.