<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifySingularTest extends AbstractTestCase
{
  /**
   * test
   */
  public function test()
  {
    $sortie = new Sortie('[foo->singular]');

    $actual = $sortie->process(['foo' => 'Foos']);

    $this->assertSame('Foo', $actual);
  }
}
