<?php
declare(strict_types=1);

namespace Justin\NoiseAssessment;

final class Lottery
{
  public static function getValidNumbers(array $numbers): array
  {
    $valid_numbers = [];
    foreach ($numbers as $number) {
      $valid_numbers[$number] = true;
    }
    return $valid_numbers;
  }
}
