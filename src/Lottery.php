<?php
declare(strict_types=1);

namespace Justin\NoiseAssessment;

final class Lottery
{

  private static function getPermutations(array $digits, int $index = 0, array $permutations = [], array $prepend = []): array
  {
    $new = [];

    $len = count($digits);
    if ($index > $len - 1) return [];

    for ($i = 0; $i < $len; $i++) {
      if ($i === $index) {
        $a = $digits[$i];
        $b = $digits[$i + 1];
        $new[] = intval("{$a}{$b}");
        $i += 1;
      } else {
        $new[] = $digits[$i];
      }
    }

    $prepended = array_merge($prepend, $new);
    $permutation = implode(' ', $prepended);
    $permutations[] = $permutation;

    $removed = array_splice($new, 0, 1);
    $prepend[] = $removed[0];

    $permutations += Lottery::getPermutations($new, $index, $permutations, $prepend);
    return $permutations;
  }

  public static function getValidNumbers(array $numbers): array
  {
    $valid_numbers = [];

    foreach ($numbers as $number) {
      $number_int = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
      $digits = str_split($number_int);

      $all = [];
      $len = count($digits);
      for ($i = 0; $i < $len; $i++) {
        $permutations = Lottery::getPermutations($digits, $i);
        $all = array_merge($all, $permutations);
      }

      $valid_numbers[$number] = $all;
    }

    return $valid_numbers;
  }
}
