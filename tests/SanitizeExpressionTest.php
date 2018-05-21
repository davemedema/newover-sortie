<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class SanitizeExpressionTest extends AbstractTestCase
{
  public function test()
  {
    // Default...
    $actual = Sortie::sanitizeExpression(' foo->bar:baz|qux ');

    $this->assertSame('foo->bar:baz|qux', $actual);

    // Invalid expression...
    $this->assertSame('', Sortie::sanitizeExpression(123));
  }
}
