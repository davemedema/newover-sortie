<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyCleanTest extends AbstractTestCase
{
  /**
   * data
   */
  public function data()
  {
    return [
      [' foo  bar   baz    ', 'foo bar baz'],
    ];
  }

  /**
   * @dataProvider data()
   */
  public function test($input, $expected)
  {
    $sortie = new Sortie('[foo->clean]');

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }
}
