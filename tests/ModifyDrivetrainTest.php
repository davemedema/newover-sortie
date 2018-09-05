<?php
namespace Tests;

use Sortie\Sortie;
use Tests\AbstractTestCase;

class ModifyDrivetrainTest extends AbstractTestCase
{
  /**
   * data
   */
  public function data()
  {
    return [
      ['4WD', '4X4'],
      ['AWD', 'AWD'],
      ['FWD', 'FWD'],
      ['RWD', 'RWD'],
      ['FOO', 'Other'],
      ['BAR', 'Other'],
    ];
  }

  /**
   * @dataProvider data()
   */
  public function test($input, $expected)
  {
    $sortie = new Sortie('[foo->drivetrain]');

    $this->assertSame($expected, $sortie->process(['foo' => $input]));
  }
}
