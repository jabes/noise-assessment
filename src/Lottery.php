<?php
declare(strict_types=1);

namespace Justin\NoiseAssessment;

final class Lottery
{

  /**
   * Filters a set of lottery numbers based on the following criteria:
   *
   * 1. No duplicate series
   * 3. Each series must contain exactly 7 numbers
   * 3. Each number must be between 1 and 59
   *
   * @param array $permutations A list of lottery numbers to filter
   * @return array
   */
  private static function filterPermutations(array $permutations): array
  {
    $permutations = array_unique($permutations);

    foreach ($permutations as $key => $permutation) {
      $valid = true;
      $digits = explode(' ', $permutation);

      if (count($digits) !== 7) {
        $valid = false;
      } else {
        foreach ($digits as $digit) {
          if ($digit < 1 || $digit > 59) {
            $valid = false;
            break;
          }
        }
      }

      if (!$valid) {
        unset($permutations[$key]);
      }
    }

    return $permutations;
  }

  /**
   * Find all possible permutations of a given series of numbers.
   * This works by assigning binary values to each number,
   * which will determine 1 of 2 possible outcomes:
   *
   * If the binary value is 1: Concat the current number with the following to make a double digit
   * numbers: 1 2 3 4
   *  binary: 1 0 1 0
   *  output: 12 34
   *
   * If the binary value is 0: Keep the current number as a single digit
   * numbers: 1 2 3 4
   *  binary: 0 0 1 0
   *  output: 1 2 34
   *
   * Example:
   * numbers: 4 9 3 8 5 3 2 8 9 4 7 5 4
   *  binary: 1 0 1 0 1 0 1 0 0 1 0 1 0
   *  output: 49 38 53 28 9 47 54
   *
   * @param string $lottery_number The series of digits we will permutate
   * @return array
   */
  private static function getPermutations(string $lottery_number): array
  {
    $permutations = [];

    $lottery_digits = str_split($lottery_number);

    $chars = [0, 1];
    $size = count($lottery_digits);
    $binary_combinations = Lottery::getCharCombinations($chars, $size);

    foreach ($binary_combinations as $binary_combination) {
      $binary_items = str_split($binary_combination);

      $permutation = [];
      for ($i = 0; $i < $size; $i++) {
        $a = $lottery_digits[$i];
        $b = $lottery_digits[$i + 1] ?? '';

        $binary_item = $binary_items[$i];
        if ($binary_item == 1) {
          $permutation[] = (int)"{$a}{$b}";
          $i += 1;
        } else {
          $permutation[] = $a;
        }
      }

      $permutations[$binary_combination] = implode(' ', $permutation);
    }

    return $permutations;
  }

  /**
   * Generates an array of all possible combinations of a given length.
   *
   * Example Output: Given $chars of ['a', 'b'] and $size of 3
   * [0] => aaa
   * [1] => aab
   * [2] => aba
   * [3] => abb
   * [4] => baa
   * [5] => bab
   * [6] => bba
   * [7] => bbb
   *
   * @param array $chars A list of characters to create combinations with
   * @param int $size The length of each combination
   * @param array $combinations The resulting array, passed for recursive purposes
   * @return array
   */
  private static function getCharCombinations(array $chars, int $size, array $combinations = []): array
  {
    if (empty($combinations)) $combinations = $chars;
    if ($size == 1) return $combinations;
    $new_combinations = [];
    foreach ($combinations as $combination) {
      foreach ($chars as $char) {
        $new_combinations[] = $combination . $char;
      }
    }
    return Lottery::getCharCombinations($chars, $size - 1, $new_combinations);
  }

  /**
   * Finds valid lottery combinations given a series of numbers.
   *
   * Example:
   * 4938532894754 -> 49 38 53 28 9 47 54
   * 1234567 -> 1 2 3 4 5 6 7
   *
   * @param array $numbers A list of possible lottery numbers
   * @return array
   */
  public static function getValidNumbers(array $numbers): array
  {
    $valid_numbers = [];
    foreach ($numbers as $number) {
      $permutations = Lottery::getPermutations($number);
      $permutations = Lottery::filterPermutations($permutations);
      foreach ($permutations as $permutation) {
        $valid_numbers[$number] = $permutation;
      }
    }
    return $valid_numbers;
  }
}
