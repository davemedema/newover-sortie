<?php
namespace Tests\Unit;

use ArgumentCountError;
use Sortie\Sortie;
use Tests\AbstractTestCase;

class SanitizeExpressionTest extends AbstractTestCase
{
  /**
   * ---
   */
  public function testMissingExpression()
  {
    $this->expectException(ArgumentCountError::class);

    $actual = Sortie::sanitizeExpression();
  }

  /**
   * ---
   */
  public function testInvalidExpression()
  {
    foreach ($this->getNonStringTypes() as $type) {
      $this->assertSame('', Sortie::sanitizeExpression($type));
    }
  }

  /**
   * ---
   */
  public function testDefault()
  {
    $actual = Sortie::sanitizeExpression(' foo->bar:baz|qux ');

    $this->assertSame('foo->bar:baz|qux', $actual);
  }
}
