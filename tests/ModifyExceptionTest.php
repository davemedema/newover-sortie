<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyExceptionTest extends AbstractTestCase
{
  /**
   * test
   *
   * @group modify-exception
   */
  public function test()
  {
    $sortie = new Sortie('[foo->exception]');

    $actual = $sortie->process(['foo' => 'Foo']);

    $this->assertSame('Foo', $actual);
  }
}
