<?php

require __DIR__ . '/vendor/autoload.php';

use Justin\NoiseAssessment\Lottery;

$valid_numbers = Lottery::getValidNumbers([
  '569815571556',
  '4938532894754',
  '1234567',
  '472844278465445',
]);

foreach ($valid_numbers as $original_number => $valid_number) {
  echo "{$original_number} -> {$valid_number}" . PHP_EOL;
}
