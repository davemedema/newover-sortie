<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class SanitizeDataTest extends AbstractTestCase
{
  public function test()
  {
    // Default...
    $actual = Sortie::sanitizeData([
      ' foo ' => 'foo',
      ' BAR ' => 'bar',
    ]);

    $expected = [
      'foo' => 'foo',
      'bar' => 'bar',
    ];

    $this->assertSame($expected, $actual);

    // Invalid data...
    $this->assertSame([], Sortie::sanitizeData('foo'));
  }
}
