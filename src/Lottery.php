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
   * @param array $lottery_numbers A list of lottery numbers to filter
   * @return array
   */
  private static function validateNumbers(array $lottery_numbers): array
  {
    $lottery_numbers = array_unique($lottery_numbers);

    foreach ($lottery_numbers as $key => $lottery_number) {
      $valid = true;
      $digits = explode(' ', $lottery_number);

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
        unset($lottery_numbers[$key]);
      }
    }

    return $lottery_numbers;
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
   * @param string $number_string The series of digits we will permutate
   * @return array
   */
  private static function parseNumberString(string $number_string): array
  {
    $lottery_numbers = [];

    $digits = str_split($number_string);

    $chars = [0, 1];
    $size = count($digits);
    $binary_combinations = Lottery::getCharacterCombinations($chars, $size);

    foreach ($binary_combinations as $binary_string) {
      $lottery_number = [];
      $binary_values = str_split($binary_string);

      for ($i = 0; $i < $size; $i++) {
        $binary_value = $binary_values[$i];
        if ($binary_value == 1) {
          $a = $digits[$i];
          $b = $digits[$i + 1] ?? '';
          $lottery_number[] = (int)"{$a}{$b}";
          $i += 1;
        } else {
          $lottery_number[] = $digits[$i];
        }
      }

      $lottery_numbers[$binary_string] = implode(' ', $lottery_number);
    }

    return $lottery_numbers;
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
  private static function getCharacterCombinations(array $chars, int $size, array $combinations = []): array
  {
    if (empty($combinations)) $combinations = $chars;
    if ($size == 1) return $combinations;
    $new_combinations = [];
    foreach ($combinations as $combination) {
      foreach ($chars as $char) {
        $new_combinations[] = $combination . $char;
      }
    }
    return Lottery::getCharacterCombinations($chars, $size - 1, $new_combinations);
  }

  /**
   * Finds valid lottery combinations given a series of numbers.
   *getValidTickets
   * Example:
   * 4938532894754 -> 49 38 53 28 9 47 54
   * 1234567 -> 1 2 3 4 5 6 7
   *
   * @param array $number_strings A list of possible lottery numbers
   * @return array
   */
  public static function getValidTickets(array $number_strings): array
  {
    $valid_numbers = [];
    foreach ($number_strings as $number_string) {
      $lottery_numbers = Lottery::parseNumberString($number_string);
      $lottery_numbers = Lottery::validateNumbers($lottery_numbers);
      foreach ($lottery_numbers as $lottery_number) {
        $valid_numbers[$number_string] = $lottery_number;
      }
    }
    return $valid_numbers;
  }
}
