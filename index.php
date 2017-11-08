<?php

require __DIR__ . '/vendor/autoload.php';

use Justin\NoiseAssessment\Lottery;

$number_strings = [
  '569815571556',
  '4938532894754',
  '1234567',
  '472844278465445',
];

$lottery_numbers = Lottery::getValidTickets($number_strings);

?><!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Winning Ticket!</title>
    <meta name="description" content="A PHP technical assessment made with ❤ for Noise Digital.">
  </head>
  <body>
    <h1>Winning Ticket!</h1>
    <p>A PHP technical assessment made with ❤ for Noise Digital.</p>
    <ul>
      <?php foreach ($lottery_numbers as $original_number => $valid_number): ?>
        <li><?= "{$original_number} → {$valid_number}" ?></li>
      <?php endforeach; ?>
    </ul>
  </body>
</html>
