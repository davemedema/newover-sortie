<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyPluralTest extends AbstractTestCase
{
  /**
   * test
   */
  public function test()
  {
    $sortie = new Sortie('[foo->plural]');

    $actual = $sortie->process(['foo' => 'Foo']);

    $this->assertSame('Foos', $actual);
  }
}
