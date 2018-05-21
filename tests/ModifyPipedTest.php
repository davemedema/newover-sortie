<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyPipedTest extends AbstractTestCase
{
  /**
   * testDefault
   */
  public function testDefault()
  {
    $sortie = new Sortie('[foo->piped]');

    $actual = $sortie->process(['foo' => 'bar|baz|qux']);

    $this->assertSame('bar|baz|qux', $actual);
  }

  /**
   * testPositiveIndex
   */
  public function testPositiveIndex()
  {
    $sortie = new Sortie('[foo->piped:1]');

    $actual = $sortie->process(['foo' => 'bar|baz|qux']);

    $this->assertSame('baz', $actual);
  }
}
