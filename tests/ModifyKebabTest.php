<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyKebabTest extends AbstractTestCase
{
  /**
   * test
   */
  public function test()
  {
    $sortie = new Sortie('[foo->kebab]');

    $actual = $sortie->process(['foo' => 'Foo Bar Baz']);

    $this->assertSame('foo-bar-baz', $actual);
  }
}
