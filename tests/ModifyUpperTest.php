<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyUpperTest extends AbstractTestCase
{
  /**
   * test
   */
  public function test()
  {
    // Default...
    $sortie = new Sortie('[foo->upper]');

    $actual = $sortie->process(['foo' => 'foo']);

    $this->assertSame('FOO', $actual);

    // Ignore...
    $sortie = new Sortie('[foo->upper:bar,baz]');

    $actual = $sortie->process(['foo' => 'baz']);

    $this->assertSame('baz', $actual);
  }
}
