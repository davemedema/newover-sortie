<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyTest extends AbstractTestCase
{
  /**
   * test
   *
   * @group modify
   */
  public function test()
  {
    // Empty modifier...
    $sortie = new Sortie('[foo->]');

    $actual = $sortie->process(['foo' => 'Foo']);

    $this->assertSame('Foo', $actual);
  }
}
