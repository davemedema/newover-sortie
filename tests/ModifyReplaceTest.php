<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyReplaceTest extends AbstractTestCase
{
  /**
   * test
   *
   * @group modify-replace
   */
  public function test()
  {
    // Default...
    $sortie = new Sortie("[foo->replace]");

    $actual = $sortie->process(['foo' => 'Foo 123 Bar 123 Baz']);

    $this->assertSame('Foo 123 Bar 123 Baz', $actual);

    // Basic...
    $sortie = new Sortie("[foo->replace:'/\d+/':'000']");

    $actual = $sortie->process(['foo' => 'Foo 123 Bar 123 Baz']);

    $this->assertSame('Foo 000 Bar 000 Baz', $actual);

    // Complex...
    $sortie = new Sortie("http://[foo->replace:'/\/$/':'']/bar.html");

    $actual = $sortie->process(['foo' => 'foo.com/']);

    $this->assertSame('http://foo.com/bar.html', $actual);

    // Brackets...
    $sortie = new Sortie("[foo->replace:'/%LB%f%RB%oo/':'FOO']");

    $actual = $sortie->process(['foo' => 'foo bar baz']);

    $this->assertSame('FOO bar baz', $actual);
  }
}
