<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class SanitizeExpressionTest extends AbstractTestCase
{
  public function test()
  {
    $actual = Sortie::sanitizeExpression(' foo->bar:baz|qux ');

    $this->assertSame('foo->bar:baz|qux', $actual);
  }
}
