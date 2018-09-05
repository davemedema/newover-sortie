<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyTransmissionTest extends AbstractTestCase
{
  /**
   * data
   */
  public function data()
  {
    return [
      ['Automatic', 'automatic'],
      ['Manual', 'manual'],
      ['Foo', 'automatic'],
      ['Bar', 'automatic'],
    ];
  }

  /**
   * @dataProvider data()
   */
  public function test($input, $expected)
  {
    $sortie = new Sortie('[foo->transmission]');

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }
}
