<?php
namespace Tests\Unit;

use ArgumentCountError;
use Sortie\Sortie;
use Tests\AbstractTestCase;

class SanitizeDataTest extends AbstractTestCase
{
  /**
   * ---
   */
  public function testMissingData()
  {
    $this->expectException(ArgumentCountError::class);

    $actual = Sortie::sanitizeData();
  }

  /**
   * ---
   */
  public function testInvalidData()
  {
    foreach ($this->getNonArrayTypes() as $type) {
      $this->assertSame([], Sortie::sanitizeData($type));
    }
  }

  /**
   * ---
   */
  public function testDefault()
  {
    $actual = Sortie::sanitizeData([
      ' foo ' => 'foo',
      ' BAR ' => 'bar',
    ]);

    $expected = [
      'foo' => 'foo',
      'bar' => 'bar',
    ];

    $this->assertSame($expected, $actual);
  }
}
