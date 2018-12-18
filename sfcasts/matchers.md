# Matchers

Coming soon...

Okay,

let we have her empty dinosaur class. We need to start thinking about how we want it to behave. So let's see. A dinosaur definitely needs a length and thinking about our object. If we're not going to make length, they required constructor argument. Then if we don't set the length, it should probably be zero until we set it. So right there I just described an example of how this our dinosaur class work. So quite literally that's what we're going to put as a function. So we're going to say function. Start with it, underscore it, because that's what Pete's respect requires and it also helps it read like a nice sentence was they. It should default to two zero length.

Okay,

and one side of here, as I mentioned this is we went to think of this as a dinosaur object before each example is executed. Behind the scenes, peachtree SPEC will instantiate a dinosaur object and then we can reference it by calling this. Nope. Want to talk more later about how this magic works and how we can control the instantiation, but right now I just want you to think of this is a dentist or object. What we're going to do is just call them, call it real methods on it, so eventually on our dinosaur class I think we should have a good length method, so we just call this Arrow, get length as if that exists and then because I think that should equal to zero because we haven't set it anywhere else. We'll use a matcher should return zero. And you noticed these matches here. We've had two things called the matchers that start with the word should matches in peachtree spec are basically the assert functions in php unit php unit have things like assert equals assert greater than in peach respect. You have the same thing. They just start with the word should. Unfortunately, PHP storm has really good support for all of these match your functions and they always start with either should or should not. So I'll put this one back too.
# Matchers

Coming soon...

Okay,

let we have her empty dinosaur class. We need to start thinking about how we want it
to behave. So let's see. A dinosaur definitely needs a length and thinking about our
object. If we're not going to make length, they required constructor argument. Then
if we don't set the length, it should probably be zero until we set it. So right
there I just described an example of how this our dinosaur class work. So quite
literally that's what we're going to put as a function. So we're going to say
function. Start with it,_it, because that's what Pete's respect requires and it also
helps it read like a nice sentence was they. It should default to two zero length.

Okay,

and one side of here, as I mentioned this is we went to think of this as a dinosaur
object before each example is executed. Behind the scenes, peachtree SPEC will
instantiate a dinosaur object and then we can reference it by calling this. Nope.
Want to talk more later about how this magic works and how we can control the
instantiation, but right now I just want you to think of this is a dentist or object.
What we're going to do is just call them, call it real methods on it, so eventually
on our dinosaur class I think we should have a good length method, so we just call
this Arrow, get length as if that exists and then because I think that should equal
to zero because we haven't set it anywhere else. We'll use a matcher should return
zero. And you noticed these matches here. We've had two things called the matchers
that start with the word should matches in peachtree spec are basically the assert
functions in php unit php unit have things like assert = assert greater than in peach
respect. You have the same thing. They just start with the word should.
Unfortunately, PHP storm has really good support for all of these match your
functions and they always start with either should or should not. So I'll put this
one back too.

Should return zero and that is a fully functional example.

Then Fun your browser and go to [inaudible] dot net. You can click into the manual
and go to the mattress section and I just want you to be aware that there is really
big documentation and all the different matchers, so we're using something right now
called the identity matcher, which actually you can say should be, should be equal
to, should return or should equal and all of these are different ways just to do a
comparison operator using three equals, which means they are equal in value and type.
There's also a comparison matcha where you can say should be like and that does two =
and there's many, many, many more and we'll talk about a lot of the most important
ones a little bit later.

Alright, so now that we have a new example, obviously this is not going to pass. We
do not have a good length method on our dinosaur class, but the cycle you're going to
do is you're always going to describe it with an example and then go over here and
we're going to run. It's not surprisingly, this fails because it says the get link
method is not found, but check it out, just like before it realizes that we're
describing some new behavior that doesn't exist in our demonstrate class, so asks us
if we want to generate it. So let's say yes and I'll move over so we can look at our
data server class and it did generate it. Of course it has no idea what logic to put
inside so it just puts it to do. And then when peach respect tries to rerun our SPEC
here, it says it should default to zero length. Expected Integer, zero Bugatti. No,
because of course our new generation method is not returning anything. So this is
great. So our job is to describe it. Peaches cycle generate as much as I can and now
we just need to fill in the logic. So probably will want a length property. It's
going to default to zero. We'll return this->length and also because we're using PHP
seven, we'll add a integer return type.

Now if we go over and rerun peaches back, it passes. So let's go a bit further. If
we're going to have a length, we're going to need a way to set it. Now we could
decide that we want to have the length as a constructor argument inside of dinosaur,
and that's something we're going to talk about later. How to test with construct
arguments, but right now I'm going to say that I want a set link method, so very
simply we're just going to describe that function. It should allow to set length,
again, think of this object as the dentists are object. How would you set the length
on the dinosaur object? Well, I would say this->set length probably. We'll set it to
nine.

Yeah,

and then I should be able to say this->get length->should return. Not just like that.
You guys know the drill now, now that we've run the example. Oh, and one thing I want
to highlight here

is that you actually get auto complete on the get length method because peaches term
is smart enough to kind of work that magic for you and we still don't have it on a
set link method. That method doesn't actually exist. So you guys know the cycle,
we've written the example, now we're going to move over, we're going to try to run
the code. It's going to fail because they set length methods not asks us if we want
to generate it, yes, we do reruns the SPEC, but of course it fails because our set
length method is not working correctly yet. Now move over and make this work exactly
how we want it. So I'll change this to an int length. Notice it and it realized we
needed an argument. It didn't know what the type or name of the argument was, but it
knows we need an argument and we'll say this->length = length. All right, move over
to try one more time and they pass. It is a very satisfying cycled to go with the
SPEC. So next, let's talk a little bit more about these matters and actually how we
could create our own mattress to make the language as natural and fluid as possible
in his classes.
Should return zero and that is a fully functional example.

Then Fun your browser and go to [inaudible] dot net. You can click into the manual and go to the mattress section and I just want you to be aware that there is really big documentation and all the different matchers, so we're using something right now called the identity matcher, which actually you can say should be, should be equal to, should return or should equal and all of these are different ways just to do a comparison operator using three equals, which means they are equal in value and type. There's also a comparison matcha where you can say should be like and that does two equals and there's many, many, many more and we'll talk about a lot of the most important ones a little bit later.

Alright, so now that we have a new example, obviously this is not going to pass. We do not have a good length method on our dinosaur class, but the cycle you're going to do is you're always going to describe it with an example and then go over here and we're going to run. It's not surprisingly, this fails because it says the get link method is not found, but check it out, just like before it realizes that we're describing some new behavior that doesn't exist in our demonstrate class, so asks us if we want to generate it. So let's say yes and I'll move over so we can look at our data server class and it did generate it. Of course it has no idea what logic to put inside so it just puts it to do. And then when peach respect tries to rerun our SPEC here, it says it should default to zero length. Expected Integer, zero Bugatti. No, because of course our new generation method is not returning anything. So this is great. So our job is to describe it. Peaches cycle generate as much as I can and now we just need to fill in the logic. So probably will want a length property. It's going to default to zero. We'll return this arrow length and also because we're using PHP seven, we'll add a integer return type.

Now if we go over and rerun peaches back, it passes. So let's go a bit further. If we're going to have a length, we're going to need a way to set it. Now we could decide that we want to have the length as a constructor argument inside of dinosaur, and that's something we're going to talk about later. How to test with construct arguments, but right now I'm going to say that I want a set link method, so very simply we're just going to describe that function. It should allow to set length, again, think of this object as the dentists are object. How would you set the length on the dinosaur object? Well, I would say this Arrow set length probably. We'll set it to nine.

Yeah,

and then I should be able to say this Arrow get length arrow should return. Not just like that. You guys know the drill now, now that we've run the example. Oh, and one thing I want to highlight here

is that you actually get auto complete on the get length method because peaches term is smart enough to kind of work that magic for you and we still don't have it on a set link method. That method doesn't actually exist. So you guys know the cycle, we've written the example, now we're going to move over, we're going to try to run the code. It's going to fail because they set length methods not asks us if we want to generate it, yes, we do reruns the SPEC, but of course it fails because our set length method is not working correctly yet. Now move over and make this work exactly how we want it. So I'll change this to an int length. Notice it and it realized we needed an argument. It didn't know what the type or name of the argument was, but it knows we need an argument and we'll say this arrow length equals length. All right, move over to try one more time and they pass. It is a very satisfying cycled to go with the SPEC. So next, let's talk a little bit more about these matters and actually how we could create our own mattress to make the language as natural and fluid as possible in his classes.