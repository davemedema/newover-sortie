<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyCamelTest extends AbstractTestCase
{
  /**
   * data
   */
  public function data()
  {
    return [
      ['FooBarBaz',     'fooBarBaz'],
      ['Foo Bar Baz',   'fooBarBaz'],
      ['foo bar baz',   'fooBarBaz'],
      ['foo-bar-baz',   'fooBarBaz'],
      ['foo_bar_baz',   'fooBarBaz'],
      ['foo bar b a z', 'fooBarBAZ'],
      ['foo bar BAZ',   'fooBarBAZ'],
    ];
  }

  /**
   * @dataProvider data()
   */
  public function test($input, $expected)
  {
    $sortie = new Sortie('[foo->camel]');

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }
}
