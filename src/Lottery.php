<?php
declare(strict_types=1);

namespace Justin\NoiseAssessment;

final class Lottery
{

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

  private static function getCharCombinations(array $chars, int $size, array $combinations = []): array
  {
    # if it's the first iteration,
    # the first set of combinations is the same as the set of characters
    if (empty($combinations)) $combinations = $chars;

    # we're done if we're at size 1
    if ($size == 1) return $combinations;

    # initialise array to put new values in
    $new_combinations = [];

    # loop through existing combinations and character set to create strings
    foreach ($combinations as $combination) {
      foreach ($chars as $char) {
        $new_combinations[] = $combination . $char;
      }
    }

    return Lottery::getCharCombinations($chars, $size - 1, $new_combinations);
  }

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
