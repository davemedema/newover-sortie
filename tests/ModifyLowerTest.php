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

    $this->assertSame('foo', $sortie->process(['foo' => 'FOO']));
  }

  /**
   * testIgnore
   */
  public function testIgnore()
  {
    $sortie = new Sortie('[foo->lower:FOO,BAR,BAZ]');

    $this->assertSame('BAZ', $sortie->process(['foo' => 'BAZ']));
  }
}
