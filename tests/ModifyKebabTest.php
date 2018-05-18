<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyKebabTest extends AbstractTestCase
{
  /**
   * data
   */
  public function data()
  {
    return [
      ['Foo Bar Baz', 'foo-bar-baz'],
    ];
  }

  /**
   * @dataProvider data()
   */
  public function test($input, $expected)
  {
    $sortie = new Sortie('[foo->kebab]');

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }
}
