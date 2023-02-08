## How TDD can make refactoring easier
[Intro] [Easy] [Test Driven Development]

Refactoring is hard. It is even harder when you don't understand the code that you have to refactor. \
To ensure that you've your job properly, you should understand the code you're editing completely.
Does that sound correct to you? I want to break that necessity by using tests to take that weight of of my shoulders.

Here are the rules:
1. Don't make any changes to production code before all functionality is covered by tests
2. Refer to rule 1

How do you do it? Well, I'll try to show you.

Here is a piece of PHP I found on github that supposedly sorts an array using the bubble-sort algorithm. \
I am using the word "supposedly" because I don't really know what the code does - by all means it looks like a \
sorting function, but I don't trust it because I don't know it.

```php
function bubbleSort($arr) {
    $temp;

    for ($i = 0; $i < count($arr); $i++) {
        for ($j = 1; $j < (count($arr)-$i); $j++) {
            if ($arr[$j-1] > $arr[$j]) {
                $temp = $arr[$j-1];
                $arr[$j-1] = $arr[$j];
                $arr[$j] = $temp;
            }
        }
    }

    return $arr;
}
```

You can immediately notice some weird things in the code, like for example, the first line in the function is just \
`$temp` which literally does nothing. Then there's two for loops and some funky stuff going on, I'm not sure how this sort \
works but I don't want to try figuring it out by reading the code, because I don't have to, because when writing tests \
I don't care about the inner workings of the code under test, just the results and side-effects.

I will begin with the simplest test I can imagine.

```php
public function test_sortedEmptyArray_isEmptyArray()
{
    $this->assertEquals([], bubbleSort([]));
}
```

And it passes! Amazing. I am a real programmer. Okay, jokes aside - I write the simplest tests first, because I don't \
want to exert more effort than necessary and because if I go straight for the hard paths, I might leave some simple cases \
uncovered and those are just as liable to bugs as the simplest paths. Generally I try to avoid testing the "golden path" \
until I have covered everything else.

```php
public function test_arrayAlreadySorted_isStillSorted()
{
    $this->assertEquals([1, 2, 3], bubbleSort([1, 2, 3]));
}
```

This one also may seem redundant, but if we want to have trustworthy test coverage, we have to make sure that we test for \
all scenarios, that means we sometimes have to order elephants or even beers at a bar!

For pure functions we only have to consider what are the possible inputs and what the output should be for that input. \
Now we're not going to write tests for every possible array to be sorted, because that's impossible, but instead we can \
find some groups of input types and test a few of each to gain certainty that the code operates correctly.

I can imagine these input/output combinations for a function that takes an array, and returns a sorted version of it:
1. empty array -> empty array
2. sorted array -> sorted array
3. unsorted array -> sorted array (golden path)
4. garbage -> error?

Note that I'm unsure about the last case, because generally I would want my code to handle garbage input by throwing or \
showing an error, but in this case, we're only here to refactor, not add/remove or change functionality, so we will omit \
this scenario.

We've already covered everything but the golden path, so let's write some tests for that.

```php
public function test_unsortedArray_getsSorted()
{
    $this->assertEquals([1, 2, 3], bubbleSort([3, 2, 1]));
}
```

And that passes, but I don't think one case is enough, so let's parametrize this test and cover more ground.

```php
/** @dataProvider unsortedArrayProvider */
public function test_unsortedArray_getsSorted(array $unsorted, array $sorted)
{
    $this->assertEquals($sorted, bubbleSort($unsorted));
}

public static function unsortedArrayProvider()
{
    return [
        ['unsorted' => [3, 2, 1], 'sorted' => [1, 2, 3]],
        ['unsorted' => [0, 0, 2, 1], 'sorted' => [0, 0, 1, 2]],
        ['unsorted' => [7, 0, 2, 1], 'sorted' => [0, 1, 2, 7]],
    ];
}
```

```
OK (5 tests, 5 assertions)
```

Looks like we've completed our tests, so now I can finally refactor. Here comes the beauty of having tests when refactoring. \
After every change I make, I will run the tests and they will tell me whether it still does what it's supposed to. Let's begin by \
removing the first line which does nothing.

```php 
function bubbleSort($arr)
{
    for ($i = 0; $i < count($arr); $i++) {
        for ($j = 1; $j < (count($arr) - $i); $j++) {
            if ($arr[$j - 1] > $arr[$j]) {
                $temp = $arr[$j - 1];
                $arr[$j - 1] = $arr[$j];
                $arr[$j] = $temp;
            }
        }
    }

    return $arr;
}
```

And the tests still pass, so I can move on. Next up I'm going to extract the `count($arr)` into a variable so that it \
does not get called in every loop, but just once.

```php 
function bubbleSort($arr)
{
    $count = count($arr);

    for ($i = 0; $i < $count; $i++) {
        for ($j = 1; $j < ($count - $i); $j++) {
            if ($arr[$j - 1] > $arr[$j]) {
                $temp = $arr[$j - 1];
                $arr[$j - 1] = $arr[$j];
                $arr[$j] = $temp;
            }
        }
    }

    return $arr;
}
```

This might break the code... I wish there was some way to validate that it did not... Wait, there is!
```
OK (5 tests, 5 assertions)
```

I've only now just realised that php actually has built-in sorting methods, so maybe we can improve the code by using \
that instead of having our own algorithm.

```php 
function bubbleSort($arr)
{
    return sort($arr);
}
```

This should do it. The best code is no code, right?

```
FAILURES!
Tests: 5, Assertions: 5, Failures: 5.
```

Uh oh. I broke something... Let's look at what the tests say.

```
1) SortTest::test_sortedEmptyArray_isEmptyArray
true does not match expected type "array".
```

Huh. Interesting. It looks like the `sort` function in PHP does not in fact return the sorted array, but a boolean? Weird, \
but OK, let's fix this.

```
function bubbleSort($arr)
{
    sort($arr);
    return $arr;
}
```

```
OK (5 tests, 5 assertions)
```

Now there's only one more thing left to refactor - typehints.

```php 
function bubbleSort(array $arr): array
{
    sort($arr);
    return $arr;
}
```

```
OK (5 tests, 5 assertions)
```

And we're done and I did not even have to understand how a bubble sort works, amazing, is it not? This is the power of \
focusing on behaviors instead of the inner clockwork of software.

So in summary:
1. Write the simplest tests first
2. Don't test every possible combination of inputs, but generalize them into groups
3. Focus on the behavior instead of the inner workings of code
4. Don't make any changes to production code before all functionality is covered by tests

This is a very simple example of how using tests or TDD can make refactoring easier. If you're looking for more advanced \
refactoring guides or want to continue on your journey of TDD, take a look at these articles:

- Covering existing code with tests by using comments
- Covering existing code with tests if you don't know what it does
- Refactoring uncovered code with side-effects using TDD