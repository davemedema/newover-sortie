<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifySlugTest extends AbstractTestCase
{
  /**
   * test
   */
  public function test()
  {
    $sortie = new Sortie('[foo->slug]');

    $actual = $sortie->process(['foo' => 'Foo Bar Baz']);

    $this->assertSame('foo-bar-baz', $actual);
  }
}
