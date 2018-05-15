<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyLowerTest extends AbstractTestCase
{
  /**
   * testDefault
   */
  public function testDefault()
  {
    $sortie = new Sortie('[foo->lower]');

    $actual = $sortie->process(['foo' => 'FOO']);

    $this->assertSame('foo', $actual);
  }

  /**
   * testIgnore
   */
  public function testIgnore()
  {
    $sortie = new Sortie('[foo->lower:BAR,BAZ]');

    $actual = $sortie->process(['foo' => 'BAZ']);

    $this->assertSame('BAZ', $actual);
  }
}
