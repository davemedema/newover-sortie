<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyDateTest extends AbstractTestCase
{
  const TEST_ATOM     = '2010-01-01T00:00:00+00:00';
  const TEST_DATETIME = '2010-01-01 00:00:00';
  const TEST_DEFAULT  = '01/01/2010';

  // Data Providers
  // ---------------------------------------------------------------------------

  /**
   * dataNoFormat
   */
  public function dataNoFormat()
  {
    return [
      [self::TEST_DATETIME, self::TEST_DEFAULT],
      [self::TEST_ATOM,     self::TEST_DEFAULT],
    ];
  }

  /**
   * dataFormat
   */
  public function dataFormat()
  {
    return [
      // Quick...
      ['ATOM',            self::TEST_DATETIME, self::TEST_ATOM],
      ['ISO8601',         self::TEST_DATETIME, self::TEST_ATOM],
      ['RFC3339',         self::TEST_DATETIME, self::TEST_ATOM],
      ['datetime',        self::TEST_ATOM,     self::TEST_DATETIME],
      // Custom...
      ['"n/j/Y @ g:i a"', self::TEST_DATETIME, '1/1/2010 @ 12:00 am'],
      ['"Ymd"',           self::TEST_DATETIME, '20100101'],
    ];
  }

  // Tests
  // ---------------------------------------------------------------------------

  /**
   * @dataProvider dataNoFormat()
   */
  public function testNoFormat($input, $expected)
  {
    $sortie = new Sortie('[foo->date]');

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }

  /**
   * @dataProvider dataFormat()
   */
  public function testFormat($format, $input, $expected)
  {
    $sortie = new Sortie("[foo->date:{$format}]");

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }
}
