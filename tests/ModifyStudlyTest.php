<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyStudlyTest extends AbstractTestCase
{
  /**
   * test
   */
  public function test()
  {
    $sortie = new Sortie('[foo->studly]');

    $actual = $sortie->process(['foo' => 'Foo Bar Baz']);

    $this->assertSame('FooBarBaz', $actual);
  }
}
