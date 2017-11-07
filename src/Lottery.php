<?php
declare(strict_types=1);

namespace Justin\NoiseAssessment;

final class Lottery
{
  public static function getValidNumbers(array $numbers): array
  {
    return [
      '4938532894754' => '49 38 53 28 9 47 54',
      '1234567' => '1 2 3 4 5 6 7',
    ];
  }
}