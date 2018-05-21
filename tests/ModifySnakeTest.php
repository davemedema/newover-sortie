<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifySnakeTest extends AbstractTestCase
{
  /**
   * test
   */
  public function test()
  {
    $sortie = new Sortie('[foo->snake]');

    $actual = $sortie->process(['foo' => 'Foo Bar Baz']);

    $this->assertSame('foo_bar_baz', $actual);
  }
}
