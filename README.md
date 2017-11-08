# Noise Digital Tech Assessment

A PHP technical assessment made with ❤ for Noise Digital.

### How It Works

We need to find a valid arrangement of single and double digits given a series of random numbers.
My solution was to find every possible permutation, and filter them given the valid criteria.

1. Generate a list of every possible binary combination that is the same length as our lottery number.

   ```
   0000000000000
   0000000000001
   0000000000010
   ...
   0110110100011
   0110110100100
   0110110100101
   ...
   1111111111101
   1111111111110
   1111111111111
   ```

2. Use each binary permutation as a legend to formulate a lottery number.
   Each binary value will be assigned to a corresponding digit and will decide one of two possible outcomes.

   If the binary value is `1`: concat the current digit with the following digit to make a double digit.

   ```
   numbers: 1 2 3 4
    binary: 1 0 1 0
            ^
    output: 12 34
   ```

   If the binary value is `0`: use the current digit as a single digit.

   ```
   numbers: 1 2 3 4
    binary: 0 0 1 0
            ^
    output: 1 2 34
   ```

3. Loop over every formulated lottery number and validate it based on the defined criteria.

   ```
   0001100111110 -> 4 9 3 85 3 2 89 47 54
   ✕ Invlid: Too many numbers, must have exactly 7

   1001010101010 -> 49 3 85 32 89 47 54
   ✕ Invlid: All numbers must be between 1 and 59

   1010111001010 -> 49 38 53 28 9 47 54
   ✓ Valid
   ```

### How To Install

```
git clone https://github.com/jabes/noise-assessment.git
cd noise-assessment
composer install
php -S localhost:8000
xdg-open http://localhost:8000/
```

### How To Test

```
vendor/bin/phpunit tests
```

### Winning Ticket!

Your favorite grandpa, Rick, is crazy about the lottery and even crazier about how he picks his “lucky” numbers. And even though his “never fail” strategy has yet to succeed, Grandpa Rick doesn't let that get him down.

![rick](rick.jpg)

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
