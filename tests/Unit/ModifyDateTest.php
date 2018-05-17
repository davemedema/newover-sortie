<?php
namespace Tests\Unit;

use ArgumentCountError;
use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyDateTest extends AbstractTestCase
{
  /**
   * ---
   */
  public function testMissingInput()
  {
    $this->expectException(ArgumentCountError::class);

    $actual = Sortie::modifyDate();
  }

  /**
   * ---
   */
  public function testInvalidInput()
  {
    foreach ($this->getNonStringTypes() as $type) {
      $this->assertSame('', Sortie::modifyDate($type));
    }
  }

  /**
   * ---
   */
  public function testDefault()
  {
    $inputs = [
      '2010-01-01 00:00:00',
      '2010-01-01T00:00:00+00:00',
    ];

    foreach ($inputs as $input) {
      $this->assertSame('01/01/2010', Sortie::modifyDate($input));
    }
  }

  /**
   * ---
   */
  public function testConstantFormats()
  {
    $constants = [
      'ATOM'    => '2010-01-01T00:00:00+00:00',
      'RFC3339' => '2010-01-01T00:00:00+00:00',
    ];

    $input = '2010-01-01 00:00:00';

    foreach ($constants as $constant => $expected) {
      $this->assertSame($expected, Sortie::modifyDate($input, [$constant]));
    }
  }

  /**
   * ---
   */
  public function testCustomFormats()
  {
    $formats = [
      "'n/j/Y @ g:i a'" => '1/1/2010 @ 12:00 am',
      "'Ymd'"           => '20100101',
    ];

    $input = '2010-01-01 00:00:00';

    foreach ($formats as $format => $expected) {
      $this->assertSame($expected, Sortie::modifyDate($input, [$format]));
    }
  }

  /**
   * ---
   */
  public function testQuickFormats()
  {
    $formats = [
      'datetime' => '2010-01-01 00:00:00',
    ];

    $input = '2010-01-01T00:00:00+00:00';

    foreach ($formats as $format => $expected) {
      $this->assertSame($expected, Sortie::modifyDate($input, [$format]));
    }
  }
}
