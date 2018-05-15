<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyCamelTest extends AbstractTestCase
{
  /**
   * testDefault
   */
  public function testDefault()
  {
    $sortie = new Sortie('[foo->camel]');

    $actual = $sortie->process(['foo' => 'Foo Bar Baz']);

    $this->assertSame('fooBarBaz', $actual);
  }
}
