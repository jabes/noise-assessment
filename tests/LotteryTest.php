<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Justin\NoiseAssessment\Lottery;

final class LotteryTest extends TestCase
{

  public function testValidNumbers(): void
  {
    $this->assertEquals(
      Lottery::getValidTickets([
        '569815571556',
        '4938532894754',
        '1234567',
      ]),
      [
        '569815571556' => '56 9 8 15 57 15 56',
        '4938532894754' => '49 38 53 28 9 47 54',
        '1234567' => '1 2 3 4 5 6 7',
      ]
    );
  }

  public function testInvalidNumbers(): void
  {
    $this->assertEquals(
      Lottery::getValidTickets([
        '472844278465445',
      ]),
      [
        // empty
      ]
    );
  }

}
