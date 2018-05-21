<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyTitleTest extends AbstractTestCase
{
  /**
   * test
   */
  public function test()
  {
    // Default...
    $sortie = new Sortie('[foo->title]');

    $actual = $sortie->process(['foo' => 'Foo bar baz']);

    $this->assertSame('Foo Bar Baz', $actual);

    // Ignore...
    $sortie = new Sortie('[foo->title:BAR,BAZ]');

    $actual = $sortie->process(['foo' => 'BAZ']);

    $this->assertSame('BAZ', $actual);
  }
}
