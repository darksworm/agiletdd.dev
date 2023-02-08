-- What question does this article answer?

Why and when use Outside-in TDD

-- What about the mock approach?

# What is TDD

TDD or Test-Driven-Development is a programming practice which runs on a Red, Green, Refactor cycle.

Red - a (minimal) failing test is written;
Green - just enough production code is written to pass the test;
Refactor - the written code is cleaned up.

If you're not familliar with TDD, you can read more about it in uncle bobs blog - http://www.butunclebob.com/ArticleS.UncleBob.TheThreeRulesOfTdd
Or get kent becks book "Test-Driven Development by example" https://www.amazon.com/gp/product/0321146530/ref=as_li_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN=0321146530&linkCode=as2&tag=martinfowlerc-20

# What is Outside-in-TDD / London school of TDD

In outside-in-tdd you start by writing a "guiding star" test that covers the whole feature/change you're going to implement.

Then you run the "guiding star" test, and see what fails.
Then you write a separate test for what fails
Then you pass it
And repeat.

Basically it's TDD but with a test which you run between your Red-Green-Refactor cycle to tell you what the next thing you have to implement is - that's why I've called it the "guiding star".

-- This is just a horrible segment, please reword me.

# Mocking, mocking, mocking

# What's my experience with it

My experience begun with a colleague mention it to me and then I fell down the rabbit hole of Uncle Bob and others.

A while down the rabbit hole, I stumbled upon the Chicaco vs London TDD series by uncle bob and Sandro Mancuso and intrigued, set on a mission to do the same coding katas as they did in their videos to learn more about outside in tdd.

Since I have used it professionally multiple times and plan to continue.

# What's good about OITDD
After you've written the Guiding star test, you have to think even less than when just doing TDD, because it tells you what code you have to write.

Because you have to write a test that encompasses the whole problem you're solving at the beginning of creating the solution, it makes you think it through (do I really know what needs to happen here?) before you embark on a coding session.

# What's not so good
The initial step of writing the guiding star test takes a lot of effort and brain power - it forces you to make decisions up front.




# What to look out for
Every new functionality should have its own test, do not rely on the guiding star test to provide functional test coverage. It is meant to be used as a temporary guide, instead of being an actual test you deploy.

The guiding star test will most likely not guide you into writing good error-handling as it is usually a golden path test, so you will have to handle those separately.

The feature you implement is going to depend on how you write your guiding star test, so you have to make sure you understand the requirements properly before beginning.

# Why do coding katas?

# Try it yourself
