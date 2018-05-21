<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyUcfirstTest extends AbstractTestCase
{
  /**
   * test
   */
  public function test()
  {
    $sortie = new Sortie('[foo->ucfirst]');

    $actual = $sortie->process(['foo' => 'foo']);

    $this->assertSame('Foo', $actual);
  }
}
