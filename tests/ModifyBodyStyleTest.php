<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyBodyStyleTest extends AbstractTestCase
{
  /**
   * data
   */
  public function data()
  {
    return [
      ['convertible', 'CONVERTIBLE'],
      ['coupe',       'COUPE'],
      ['crossover',   'CROSSOVER'],
      ['hatchback',   'HATCHBACK'],
      ['minivan',     'MINIVAN'],
      ['pickup',      'TRUCK'],
      ['sedan',       'SEDAN'],
      ['suv',         'SUV'],
      ['wagon',       'WAGON'],
      ['van',         'VAN'],
      ['specialty',   'OTHER'],
      ['foo',         'OTHER'],
      ['bar',         'OTHER'],
    ];
  }

  /**
   * @dataProvider data()
   */
  public function test($input, $expected)
  {
    $sortie = new Sortie('[foo->bodystyle]');

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }
}
