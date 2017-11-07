# Noise Digital Tech Assessment

A PHP technical assessment made with ❤ for Noise Digital.

### How To Install

```
git clone https://github.com/jabes/noise-assessment.git
cd noise-assessment
php -S localhost:8000
xdg-open http://localhost:8000/
```

### How To Test

```
composer install
vendor/bin/phpunit --bootstrap src/Lottery.php tests/LotteryTest.php
```

### Winning Ticket!

Your favorite grandpa, Rick, is crazy about the lottery and even crazier about how he picks his “lucky” numbers. And even though his “never fail” strategy has yet to succeed, Grandpa Rick doesn't let that get him down.

Every week he searches through the Sunday newspaper to find a string of digits that might be potential lottery picks. But this week the newspaper has moved to a new electronic format, and instead of a comfortable pile of papers, Grandpa Rick receives a text file with the stories.

Help your grandpa find his lotto picks. Given a large series of number strings, return each that might be suitable for a lottery ticket pick. Note that a valid lottery ticket must have 7 unique numbers between 1 and 59, digits must be used in order, and every digit must be used.

For example, given the following strings:

```
["569815571556", “4938532894754”, “1234567”, “472844278465445”]
```

Your function should return:

```
4938532894754 -> 49 38 53 28 9 47 54
1234567 -> 1 2 3 4 5 6 7
```

Additionally:

1) No output for invalid tickets.
2) Return a single valid pick per input.
3) Please return both the original string, e.g. "1234567" and the valid ticket created from it, e.g. "1 2 3 4 5 6 7", as it is done for the sample inputs.
