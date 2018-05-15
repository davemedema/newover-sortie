<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyCleanTest extends AbstractTestCase
{
  /**
   * testDefault
   */
  public function testDefault()
  {
    $sortie = new Sortie('[foo->clean]');

    $actual = $sortie->process(['foo' => ' Foo     Bar     Baz ']);

    $this->assertSame('Foo Bar Baz', $actual);
  }
}
