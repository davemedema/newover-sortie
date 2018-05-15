<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyPickTest extends AbstractTestCase
{
  /**
   * testDefault
   */
  public function testDefault()
  {
    $sortie = new Sortie('[foo->pick]');

    $actual = $sortie->process(['foo' => 'bar,baz,qux']);

    $this->assertSame('bar,baz,qux', $actual);
  }

  /**
   * testPositiveIndex
   */
  public function testPositiveIndex()
  {
    $sortie = new Sortie('[foo->pick:,:1]');

    $actual = $sortie->process(['foo' => 'bar,baz,qux']);

    $this->assertSame('baz', $actual);
  }

  /**
   * testNegativeIndex
   */
  public function testNegativeIndex()
  {
    $sortie = new Sortie('[foo->pick:,:-1]');

    $actual = $sortie->process(['foo' => 'bar,baz,qux']);

    $this->assertSame('qux', $actual);
  }

  /**
   * testSpecialDelimiter
   */
  public function testSpecialDelimiter()
  {
    $sortie = new Sortie('[foo->pick:%SP%:1]');

    $actual = $sortie->process(['foo' => 'bar baz qux']);

    $this->assertSame('baz', $actual);
  }
}
