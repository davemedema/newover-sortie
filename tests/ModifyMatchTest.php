<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyMatchTest extends AbstractTestCase
{
  /**
   * test
   *
   * @group modify-match
   */
  public function test()
  {
    // Default...
    $sortie = new Sortie("[foo->match]");

    $actual = $sortie->process(['foo' => 'Foo 123 Bar 456 Baz']);

    $this->assertSame('Foo 123 Bar 456 Baz', $actual);

    // No match...
    $sortie = new Sortie("[foo->match:'/Bar/']");

    $actual = $sortie->process(['foo' => 'Foo 123 456 Baz']);

    $this->assertSame('Foo 123 456 Baz', $actual);

    // Full pattern match...
    $sortie = new Sortie("[foo->match:'/Bar/']");

    $actual = $sortie->process(['foo' => 'Foo 123 Bar 456 Baz']);

    $this->assertSame('Bar', $actual);

    // Subpatter match...
    $sortie = new Sortie("[foo->match:'/123\s(Bar)/:1']");

    $actual = $sortie->process(['foo' => 'Foo 123 Bar 456 Baz']);

    $this->assertSame('Bar', $actual);

    // Invalid subpattern index...
    $sortie = new Sortie("[foo->match:'/123\s(Bar)/:2']");

    $actual = $sortie->process(['foo' => 'Foo 123 Bar 456 Baz']);

    $this->assertSame('Foo 123 Bar 456 Baz', $actual);
  }
}
