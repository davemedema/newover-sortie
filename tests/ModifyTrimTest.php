<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyTrimTest extends AbstractTestCase
{
  /**
   * test
   */
  public function test()
  {
    $sortie = new Sortie('[foo->trim]');

    $actual = $sortie->process(['foo' => ' Foo ']);

    $this->assertSame('Foo', $actual);
  }
}
