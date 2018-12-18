# Audio Addition

Coming soon...

Do you want other enhancement to enclose your Spec? I want to make, and that's that
it's already really easy to, uh, create a spec enclosure with basic security. But I
also want the ability to pass dinosaurs into the constructor, but what I really want
to do is make sure that if we pass dinosaurs to the constructor that doesn't skip our
check for security. So let's create a new function in here called it should fail it,
providing initial dinosaurs without security. We'll say this->be constructed with say
false, but then we'll pass in an array with a new dinosaur. Now the interesting thing
about this is that we actually want the exception. The exception is actually going to
happen during instantiation, not during one of these methods being called like during
ad dinosaur. So this time we're going to start pretty simple, very similar with
should throw this time, I'll just do the dinosaurs are running rampant exemption
::class. We don't care about the message and as you can see here, it's suggested is
we can say during instantiation. And that's it. Now if you run this apps, it will
fail. Of course says that there was no exception thrown, but notice one thing it
doesn't do is this is the first time that we're using deconstructed move with a
second argument. Since the construct meant that already exists, it doesn't offer to
generate a second argument automatically when you need to do that by hand. So say
array initial data source

= arrive. What does the loop over initial dinosaurs as dinosaurs and say, this->add
dinosaur dinosaur, and because ad dinosaur has all the security checks, we should be
good. The bug we're catching here is it would've been very easy for me just to say
this->dinosaurs = initial dinosaurs. In that way there would not be a security check.
Let's move over. Run the test again. Got It.