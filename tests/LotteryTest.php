<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class LotteryTest extends TestCase
{
  public function testCanBeUsedAsString(): void
  {
    $numbers = [
      '569815571556',
      '4938532894754',
      '1234567',
      '472844278465445',
    ];
    $this->assertEquals(
      Lottery::getValidNumbers($numbers),
      [
        '4938532894754' => '49 38 53 28 9 47 54',
        '1234567' => '1 2 3 4 5 6 7',
      ]
    );
  }
}
