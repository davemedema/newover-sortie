<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyFuelTypeTest extends AbstractTestCase
{
  /**
   * data
   */
  public function data()
  {
    return [
      ['Diesel Fuel',   'Diesel'],
      ['Gasoline Fuel', 'Gasoline'],
      ['Flex Fuel',     'Flex'],
      ['Hybrid Fuel',   'Hybrid'],
      ['Foo',           'Gasoline'],
      ['Bar',           'Gasoline'],
    ];
  }

  /**
   * @dataProvider data()
   */
  public function test($input, $expected)
  {
    $sortie = new Sortie('[foo->fueltype]');

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }
}
