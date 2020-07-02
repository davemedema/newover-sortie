<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyYearTest extends AbstractTestCase
{
  // Data Providers
  // ---------------------------------------------------------------------------

  /**
   * dataNoParams
   */
  public function dataNoParams()
  {
    return [
      ['',      ''],
      ['0',     ''],
      ['1',     ''],
      ['123',   ''],
      ['12345', ''],
      ['abc',   ''],
      ['abcd',  ''],
      ['00',    '00'],
      ['10',    '10'],
      ['90',    '90'],
      ['0000',  '0000'],
      ['1990',  '1990'],
      ['2000',  '2000'],
      ['2010',  '2010'],
    ];
  }

  /**
   * dataDigits
   */
  public function dataDigits()
  {
    return [
      ['2', '00',   '00'],
      ['2', '10',   '10'],
      ['2', '19',   '19'],
      ['2', '20',   '20'],
      ['2', '90',   '90'],
      ['2', '2000', '00'],
      ['2', '2010', '10'],
      ['2', '2019', '19'],
      ['2', '2020', '20'],
      ['2', '1990', '90'],
      ['4', '00',   '2000'],
      ['4', '10',   '2010'],
      ['4', '19',   '2019'],
      ['4', '20',   '2020'],
      ['4', '90',   '1990'],
      ['4', '2000', '2000'],
      ['4', '2010', '2010'],
      ['4', '2019', '2019'],
      ['4', '2020', '2020'],
      ['4', '1990', '1990'],
    ];
  }

  /**
   * dataDigitsCutoff
   */
  public function dataDigitsCutoff()
  {
    return [
      ['4', '19', '19', '2019'],
      ['4', '19', '20', '1920'],
      ['4', '19', '21', '1921'],
      ['4', '20', '19', '2019'],
      ['4', '20', '20', '2020'],
      ['4', '20', '21', '1921'],
    ];
  }

  // Tests
  // ---------------------------------------------------------------------------

  /**
   * @dataProvider dataNoParams()
   *
   * @group modify-year
   */
  public function test($input, $expected)
  {
    $sortie = new Sortie('[foo->year]');

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }

  /**
   * @dataProvider dataDigits()
   *
   * @group modify-year
   */
  public function testDigits($digits, $input, $expected)
  {
    $sortie = new Sortie("[foo->year:{$digits}]");

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }

  /**
   * @dataProvider dataDigitsCutoff()
   *
   * @group modify-year
   */
  public function testDigitsCutoff($digits, $cutoff, $input, $expected)
  {
    $sortie = new Sortie("[foo->year:{$digits}:{$cutoff}]");

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }
}
